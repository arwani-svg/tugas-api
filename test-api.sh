#!/bin/bash
# Test otomatis Sistem API User & Buku
# Cara pakai: ./test-api.sh [base_url]
# Contoh: ./test-api.sh http://localhost:8000/api
BASE=${1:-http://localhost:8000/api}
echo "Base: $BASE"
echo "== 1. Register A =="
curl -s -X POST $BASE/register -H "Accept: application/json" -H "Content-Type: application/json" -d '{"name":"User A","email":"a@mail.com","password":"password123","password_confirmation":"password123"}'; echo
echo "== 2. Register B =="
curl -s -X POST $BASE/register -H "Accept: application/json" -H "Content-Type: application/json" -d '{"name":"User B","email":"b@mail.com","password":"password123","password_confirmation":"password123"}'; echo
echo "== 3. Login A =="
TOKEN_A=$(curl -s -X POST $BASE/login -H "Accept: application/json" -H "Content-Type: application/json" -d '{"email":"a@mail.com","password":"password123"}' | python3 -c "import sys,json; print(json.load(sys.stdin).get('token',''))")
echo "TOKEN_A=${TOKEN_A:0:15}..."
echo "== 4. Login B =="
TOKEN_B=$(curl -s -X POST $BASE/login -H "Accept: application/json" -H "Content-Type: application/json" -d '{"email":"b@mail.com","password":"password123"}' | python3 -c "import sys,json; print(json.load(sys.stdin).get('token',''))")
echo "TOKEN_B=${TOKEN_B:0:15}..."
echo "== 5. A buat buku =="
curl -s -X POST $BASE/bukus -H "Accept: application/json" -H "Authorization: Bearer $TOKEN_A" -H "Content-Type: application/json" -d '{"judul":"Laskar Pelangi","penulis":"Andrea Hirata","penerbit":"Bentang","tahun_terbit":"2005"}'; echo
echo "== 6. A GET /bukus/1 (harap 200) =="
curl -s $BASE/bukus/1 -H "Accept: application/json" -H "Authorization: Bearer $TOKEN_A"; echo
echo "== 7. B GET /bukus/1 (harap 403) =="
curl -s $BASE/bukus/1 -H "Accept: application/json" -H "Authorization: Bearer $TOKEN_B"; echo
echo "== 8. B PUT /bukus/1 (harap 403) =="
curl -s -X PUT $BASE/bukus/1 -H "Accept: application/json" -H "Authorization: Bearer $TOKEN_B" -H "Content-Type: application/json" -d '{"judul":"Hacked"}'; echo
echo "== 9. B GET /users/1/bukus (harap 403) =="
curl -s $BASE/users/1/bukus -H "Accept: application/json" -H "Authorization: Bearer $TOKEN_B"; echo
echo "== 10. A GET /users/1/bukus (harap 200) =="
curl -s $BASE/users/1/bukus -H "Accept: application/json" -H "Authorization: Bearer $TOKEN_A"; echo
echo "SELESAI. Jika no 7,8,9 = 403 dan lainnya 200/201 berarti middleware benar."
