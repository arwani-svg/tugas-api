#!/bin/bash
# cara pakai: ./test-api.sh
# pastikan php artisan serve sudah jalan
BASE=${1:-http://localhost:8000/api}
echo "test ke $BASE"

echo "1. register A"
curl -s -X POST $BASE/register -H "Accept: application/json" -H "Content-Type: application/json" -d '{"name":"User A","email":"a@mail.com","password":"password123"}'
echo
echo "2. register B"
curl -s -X POST $BASE/register -H "Accept: application/json" -H "Content-Type: application/json" -d '{"name":"User B","email":"b@mail.com","password":"password123"}'
echo
echo "3. login A"
TOKEN_A=$(curl -s -X POST $BASE/login -H "Accept: application/json" -H "Content-Type: application/json" -d '{"email":"a@mail.com","password":"password123"}' | python3 -c "import sys,json; print(json.load(sys.stdin).get('token',''))")
echo "token A dapat"
echo "4. login B"
TOKEN_B=$(curl -s -X POST $BASE/login -H "Accept: application/json" -H "Content-Type: application/json" -d '{"email":"b@mail.com","password":"password123"}' | python3 -c "import sys,json; print(json.load(sys.stdin).get('token',''))")
echo "token B dapat"
echo "5. A tambah buku"
curl -s -X POST $BASE/bukus -H "Accept: application/json" -H "Authorization: Bearer $TOKEN_A" -H "Content-Type: application/json" -d '{"judul":"Laskar Pelangi","penulis":"Andrea Hirata"}'
echo
echo "6. A buka buku 1 (harusnya bisa)"
curl -s $BASE/bukus/1 -H "Accept: application/json" -H "Authorization: Bearer $TOKEN_A"
echo
echo "7. B buka buku 1 (harusnya 403)"
curl -s $BASE/bukus/1 -H "Accept: application/json" -H "Authorization: Bearer $TOKEN_B"
echo
echo "selesai"
