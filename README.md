# Sistem API — User & Buku (Laravel 11 + Sanctum)

Tugas **Pemrograman Integratif**: System API CRUD User dan Buku.
Fokus penilaian: **API / URL-nya bisa dan tepat**, bukan tampilan. Tampilan Blade di `/` hanya dokumentasi.

## Fitur sesuai soal
- [x] CRUD **User** via endpoint API
- [x] CRUD **Buku** via endpoint API
- [x] Bisa akses **buku dari user via endpoint API**: `GET /api/users/{id}/bukus`
- [x] Ada **middleware**:
  - `auth:sanctum` (harus login/token)
  - `buku.owner` (`EnsureBukuOwner`) — jaga show/update/delete buku
  - `user.owner` (`EnsureUserOwner`) — jaga show/update/delete user
- [x] **Tidak bisa edit, delete, get dari user lain** → `403 Forbidden`

## Tech — sengaja simpel, tanpa banyak konfigurasi
- Laravel 11 (Blade biasa, tanpa Vue/React, tanpa MySQL)
- Database SQLite (file `database/database.sqlite`, tinggal `migrate`)
- Auth Sanctum (token Bearer)
- 1 tabel tambahan: `bukus` (`user_id, judul, penulis, penerbit, tahun_terbit, isbn, deskripsi`)

## Cara jalan lokal (2 menit)
```bash
composer install
cp .env.example .env
php artisan key:generate
touch database/database.sqlite
php artisan migrate
php artisan serve
# buka http://localhost:8000/ untuk dokumentasi
# base API: http://localhost:8000/api
```

## Daftar Endpoint

### Auth (public)
| Method | Endpoint | Body |
|---|---|---|
| POST | `/api/register` | name, email, password, password_confirmation |
| POST | `/api/login` | email, password |

### Auth (butuh token: `Authorization: Bearer TOKEN`)
| Method | Endpoint | Keterangan |
|---|---|---|
| POST | `/api/logout` | hapus token |
| GET | `/api/me` | profil sendiri |

### User
| Method | Endpoint | Middleware |
|---|---|---|
| GET | `/api/users` | auth |
| GET | `/api/users/{id}` | auth + `user.owner` |
| PUT/PATCH | `/api/users/{id}` | auth + `user.owner` |
| DELETE | `/api/users/{id}` | auth + `user.owner` |
| GET | `/api/users/{id}/bukus` | auth (buku milik user tsb, user lain = 403) |

### Buku
| Method | Endpoint | Middleware |
|---|---|---|
| GET | `/api/bukus` | auth, hanya milik sendiri |
| POST | `/api/bukus` | auth |
| GET | `/api/bukus/{id}` | auth + `buku.owner` |
| PUT/PATCH | `/api/bukus/{id}` | auth + `buku.owner` |
| DELETE | `/api/bukus/{id}` | auth + `buku.owner` |

Body buku:
```json
{
  "judul": "Laskar Pelangi",
  "penulis": "Andrea Hirata",
  "penerbit": "Bentang Pustaka",
  "tahun_terbit": "2005",
  "isbn": "978-979-3062-79-2",
  "deskripsi": "Novel inspiratif."
}
```

## Test cepat via curl
```bash
# register
curl -X POST http://localhost:8000/api/register -H "Accept: application/json" -H "Content-Type: application/json" -d '{"name":"Budi","email":"budi@mail.com","password":"password123","password_confirmation":"password123"}'

# login -> copy token
curl -X POST http://localhost:8000/api/login -H "Accept: application/json" -H "Content-Type: application/json" -d '{"email":"budi@mail.com","password":"password123"}'

# buat buku
curl -X POST http://localhost:8000/api/bukus -H "Accept: application/json" -H "Authorization: Bearer TOKEN" -H "Content-Type: application/json" -d '{"judul":"Laskar Pelangi","penulis":"Andrea Hirata"}'

# list buku sendiri
curl http://localhost:8000/api/bukus -H "Accept: application/json" -H "Authorization: Bearer TOKEN"

# akses buku dari user
curl http://localhost:8000/api/users/1/bukus -H "Accept: application/json" -H "Authorization: Bearer TOKEN"
```

### Bukti middleware (untuk demo ke dosen)
1. Register+login sebagai User A → buat buku (id=1).
2. Register+login sebagai User B → `GET /api/bukus/1` pakai token B → `403 {"message":"Forbidden: buku ini milik user lain..."}`.
3. Sama untuk PUT, DELETE, dan `GET /api/users/1/bukus` pakai token B → 403.

## File penting untuk dinilai
- `routes/api.php`
- `bootstrap/app.php` (registrasi alias middleware)
- `app/Http/Middleware/EnsureBukuOwner.php`
- `app/Http/Middleware/EnsureUserOwner.php`
- `app/Http/Controllers/Api/AuthController.php`
- `app/Http/Controllers/Api/UserController.php`
- `app/Http/Controllers/Api/BukuController.php`
- `app/Models/Buku.php`, `app/Models/User.php`
- `database/migrations/2025_01_01_000000_create_bukus_table.php`
- `resources/views/welcome.blade.php` (dokumentasi di `/`)

## Cara kumpul (GitHub public + Classroom)
1. Buat repo baru di github.com → nama misal `tugas-api-user-buku` → pilih **Public** → Create.
2. Di folder project ini:
```bash
git init
git add .
git commit -m "Sistem API User & Buku - Laravel Sanctum + middleware ownership"
git branch -M main
git remote add origin https://github.com/USERNAME_KAMU/tugas-api-user-buku.git
git push -u origin main
```
3. Copy link repo (misal `https://github.com/USERNAME_KAMU/tugas-api-user-buku`) → paste di kolom tugas Google Classroom → Turn in.
