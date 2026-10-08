<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Tugas API - User dan Buku</title>
<style>
body { font-family: Arial; margin: 20px; background: #f2f2f2; }
.box { background: white; padding: 20px; margin-bottom: 15px; border: 1px solid #ccc; }
table { border-collapse: collapse; width: 100%; margin-top: 10px; }
table, th, td { border: 1px solid black; }
th, td { padding: 8px; text-align: left; font-size: 14px; }
h1 { font-size: 24px; }
h2 { font-size: 18px; background: #e8e8e8; padding: 8px; }
.contoh { background: #f9f9f9; border: 1px solid #ddd; padding: 10px; font-size: 13px; }
</style>
</head>
<body>

<div class="box">
<h1>Tugas Pemrograman Integratif - Sistem API User dan Buku</h1>
<p>Halo pak, ini tugas saya tentang API. Jadi tampilannya memang sederhana, yang penting API nya jalan.</p>
<p><b>Base URL :</b> {{ url('/api') }}</p>
<p>Untuk yang butuh login, tambahkan di Header : <br>
Accept : application/json <br>
Authorization : Bearer TOKEN (token didapat dari login/register)
</p>
</div>

<div class="box">
<h2>1. Cara menjalankan di laptop</h2>
<ol>
<li>composer install</li>
<li>copy .env.example jadi .env</li>
<li>php artisan key:generate</li>
<li>php artisan migrate</li>
<li>php artisan serve, lalu buka http://localhost:8000</li>
</ol>
</div>

<div class="box">
<h2>2. Daftar Endpoint</h2>

<p><b>A. Auth (tidak perlu token)</b></p>
<table>
<tr><th>Method</th><th>URL</th><th>Input</th></tr>
<tr><td>POST</td><td>/api/register</td><td>name, email, password</td></tr>
<tr><td>POST</td><td>/api/login</td><td>email, password</td></tr>
</table>

<p><b>B. Auth (harus pakai token)</b></p>
<table>
<tr><th>Method</th><th>URL</th><th>Keterangan</th></tr>
<tr><td>POST</td><td>/api/logout</td><td>logout</td></tr>
<tr><td>GET</td><td>/api/me</td><td>lihat profil sendiri</td></tr>
</table>

<p><b>C. User (harus login)</b></p>
<table>
<tr><th>Method</th><th>URL</th><th>Middleware</th></tr>
<tr><td>GET</td><td>/api/users</td><td>auth</td></tr>
<tr><td>GET</td><td>/api/users/{id}</td><td>auth + user.owner (hanya milik sendiri)</td></tr>
<tr><td>PUT</td><td>/api/users/{id}</td><td>auth + user.owner</td></tr>
<tr><td>DELETE</td><td>/api/users/{id}</td><td>auth + user.owner</td></tr>
<tr><td>GET</td><td>/api/users/{id}/bukus</td><td>auth (lihat buku dari user, hanya milik sendiri)</td></tr>
</table>

<p><b>D. Buku (harus login)</b></p>
<table>
<tr><th>Method</th><th>URL</th><th>Middleware</th></tr>
<tr><td>GET</td><td>/api/bukus</td><td>auth (hanya tampil buku sendiri)</td></tr>
<tr><td>POST</td><td>/api/bukus</td><td>auth</td></tr>
<tr><td>GET</td><td>/api/bukus/{id}</td><td>auth + buku.owner</td></tr>
<tr><td>PUT</td><td>/api/bukus/{id}</td><td>auth + buku.owner</td></tr>
<tr><td>DELETE</td><td>/api/bukus/{id}</td><td>auth + buku.owner</td></tr>
</table>

<p>Input buku : judul (wajib), penulis (wajib), penerbit, tahun_terbit, isbn, deskripsi.</p>
</div>

<div class="box">
<h2>3. Cara testing pakai Postman (langkah-langkah)</h2>
<ol>
<li><b>Register user pertama.</b> Pilih POST, url http://localhost:8000/api/register, pilih Body - raw - JSON, isi :
<div class="contoh">{"name": "User A", "email": "a@mail.com", "password": "password123"}</div>
Klik Send, kalau berhasil akan muncul token. Simpan token A.
</li><br>
<li><b>Register user kedua.</b> Sama seperti di atas tapi email b@mail.com. Simpan token B.
</li><br>
<li><b>Login (kalau mau coba).</b> POST ke /api/login, isi email dan password. Nanti dapat token baru.
</li><br>
<li><b>Tambah buku pakai token A.</b> Pilih POST, url http://localhost:8000/api/bukus. Buka tab Authorization, pilih Bearer Token, tempel token A. Lalu di Body isi :
<div class="contoh">{"judul": "Laskar Pelangi", "penulis": "Andrea Hirata", "penerbit": "Bentang"}</div>
Klik Send. Catat id bukunya, misal id 1.
</li><br>
<li><b>Lihat buku sendiri.</b> Pilih GET, url http://localhost:8000/api/bukus, pakai token A, Send. Harusnya muncul list buku A.
</li><br>
<li><b>Lihat buku dari user.</b> GET ke http://localhost:8000/api/users/1/bukus pakai token A. Kalau id nya sama dengan id login, berhasil. Kalau coba pakai token B untuk buka /users/1/bukus, akan gagal 403.
</li><br>
<li><b>Buktikan middleware.</b> Login sebagai user B, lalu coba akses buku milik A :
<ul>
<li>GET http://localhost:8000/api/bukus/1 pakai token B = 403 Tidak bisa akses</li>
<li>PUT http://localhost:8000/api/bukus/1 pakai token B = 403</li>
<li>DELETE http://localhost:8000/api/bukus/1 pakai token B = 403</li>
</ul>
Kalau pakai token A untuk id 1 = berhasil 200. Itu buktinya middleware jalan.
</li>
</ol>
</div>

<div class="box">
<h2>4. File yang dipakai</h2>
<ul>
<li>routes/api.php - daftar url api</li>
<li>app/Http/Controllers/Api/AuthController.php - register, login, logout</li>
<li>app/Http/Controllers/Api/UserController.php - CRUD user</li>
<li>app/Http/Controllers/Api/BukuController.php - CRUD buku</li>
<li>app/Http/Middleware/EnsureBukuOwner.php - cek buku milik siapa</li>
<li>app/Http/Middleware/EnsureUserOwner.php - cek user milik siapa</li>
<li>app/Models/Buku.php dan User.php</li>
</ul>
<p>Sekian, terima kasih pak.</p>
</div>

</body>
</html>
