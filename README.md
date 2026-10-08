# Tugas API - User dan Buku

Tugas mata kuliah Pemrograman Integratif.
Isinya API CRUD user dan buku pakai Laravel. Tampilannya sederhana saja karena yang dinilai API nya.

## Cara jalan
```
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve
```
Buka http://localhost:8000 untuk panduan, API nya di http://localhost:8000/api

## Endpoint
Auth :
- POST /api/register (name, email, password)
- POST /api/login (email, password)
- POST /api/logout (token)
- GET /api/me (token)

User (harus login) :
- GET /api/users
- GET /api/users/{id} (hanya milik sendiri)
- PUT /api/users/{id} (hanya milik sendiri)
- DELETE /api/users/{id} (hanya milik sendiri)
- GET /api/users/{id}/bukus (lihat buku dari user, hanya milik sendiri)

Buku (harus login) :
- GET /api/bukus (hanya buku sendiri)
- POST /api/bukus (judul, penulis wajib)
- GET /api/bukus/{id} (hanya milik sendiri)
- PUT /api/bukus/{id} (hanya milik sendiri)
- DELETE /api/bukus/{id} (hanya milik sendiri)

Kalau buka data milik user lain akan muncul 403. Itu dari middleware.

## Middleware
- auth:sanctum (bawaan laravel, untuk cek sudah login atau belum)
- buku.owner (app/Http/Middleware/EnsureBukuOwner.php)
- user.owner (app/Http/Middleware/EnsureUserOwner.php)

## Cara kumpul
Buat repo public di github, lalu :
```
git init
git add .
git commit -m "tugas api"
git branch -M main
git remote add origin https://github.com/username/tugas-api.git
git push -u origin main
```
Link repo nya dikumpulkan di classroom.
