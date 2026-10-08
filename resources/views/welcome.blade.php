<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Sistem API - User & Buku | Tugas Pemrograman Integratif</title>
<style>
body{font-family:system-ui,Arial,sans-serif;background:#f6f7f9;margin:0;color:#1f2937}
.container{max-width:900px;margin:0 auto;padding:32px 20px}
.card{background:#fff;border-radius:12px;padding:24px;box-shadow:0 4px 20px rgba(0,0,0,.06);margin-bottom:20px}
h1{margin:0 0 8px}.muted{color:#6b7280}
code{background:#111827;color:#f9fafb;padding:2px 8px;border-radius:6px;font-size:13px}
pre{background:#111827;color:#e5e7f;border-radius:10px;padding:16px;overflow:auto;font-size:13px}
table{width:100%;border-collapse:collapse;font-size:14px}
th,td{text-align:left;padding:10px;border-bottom:1px solid #e5e7eb}
th{background:#f9fafb}
.badge{display:inline-block;background:#dcfce7;color:#166534;padding:2px 10px;border-radius:999px;font-size:12px}
.badge.red{background:#fee2e2;color:#991b1b}
a{color:#2563eb}
</style>
</head>
<body>
<div class="container">
<div class="card">
<h1>Sistem API — User & Buku</h1>
<p class="muted">Tugas Pemrograman Integratif. Stack: Laravel 11 + Blade sederhana + Sanctum. Fokus ke API, tampilan ini hanya dokumentasi.</p>
<p><span class="badge">Base URL lokal: http://localhost:8000/api</span></p>
<p>Gunakan header untuk request yang butuh auth:<br><code>Accept: application/json</code> <code>Authorization: Bearer TOKEN_ANDA</code></p>
</div>

<div class="card">
<h2>1. Auth</h2>
<table>
<tr><th>Method</th><th>Endpoint</th><th>Auth</th><th>Keterangan</th></tr>
<tr><td>POST</td><td><code>/api/register</code></td><td>-</td><td>name, email, password, password_confirmation</td></tr>
<tr><td>POST</td><td><code>/api/login</code></td><td>-</td><td>email, password -&gt; dapat token</td></tr>
<tr><td>POST</td><td><code>/api/logout</code></td><td><span class="badge">token</span></td><td>Hapus token saat ini</td></tr>
<tr><td>GET</td><td><code>/api/me</code></td><td><span class="badge">token</span></td><td>Profil user login</td></tr>
</table>
</div>

<div class="card">
<h2>2. CRUD User</h2>
<table>
<tr><th>Method</th><th>Endpoint</th><th>Middleware</th></tr>
<tr><td>GET</td><td><code>/api/users</code></td><td>auth:sanctum</td></tr>
<tr><td>GET</td><td><code>/api/users/{id}</code></td><td>auth + <code>user.owner</code> (hanya milik sendiri, user lain = 403)</td></tr>
<tr><td>PUT/PATCH</td><td><code>/api/users/{id}</code></td><td>auth + <code>user.owner</code></td></tr>
<tr><td>DELETE</td><td><code>/api/users/{id}</code></td><td>auth + <code>user.owner</code></td></tr>
<tr><td>GET</td><td><code>/api/users/{id}/bukus</code></td><td>auth (akses buku dari user via endpoint api, hanya milik sendiri)</td></tr>
</table>
</div>

<div class="card">
<h2>3. CRUD Buku</h2>
<table>
<tr><th>Method</th><th>Endpoint</th><th>Middleware</th></tr>
<tr><td>GET</td><td><code>/api/bukus</code></td><td>auth (hanya buku milik sendiri)</td></tr>
<tr><td>POST</td><td><code>/api/bukus</code></td><td>auth</td></tr>
<tr><td>GET</td><td><code>/api/bukus/{id}</code></td><td>auth + <code>buku.owner</code> (403 jika milik user lain)</td></tr>
<tr><td>PUT/PATCH</td><td><code>/api/bukus/{id}</code></td><td>auth + <code>buku.owner</code></td></tr>
<tr><td>DELETE</td><td><code>/api/bukus/{id}</code></td><td>auth + <code>buku.owner</code></td></tr>
</table>
<pre>{
  "judul": "Laskar Pelangi",
  "penulis": "Andrea Hirata",
  "penerbit": "Bentang Pustaka",
  "tahun_terbit": "2005",
  "isbn": "978-979-3062-79-2",
  "deskripsi": "Novel inspiratif."
}</pre>
</div>

<div class="card">
<h2>4. Cara Test Cepat</h2>
<pre># 1. register
curl -X POST http://localhost:8000/api/register \
 -H "Accept: application/json" \
 -H "Content-Type: application/json" \
 -d '{"name":"Budi","email":"budi@mail.com","password":"password123","password_confirmation":"password123"}'

# 2. login -> simpan token
curl -X POST http://localhost:8000/api/login \
 -H "Accept: application/json" \
 -H "Content-Type: application/json" \
 -d '{"email":"budi@mail.com","password":"password123"}'

# 3. buat buku (ganti TOKEN)
curl -X POST http://localhost:8000/api/bukus \
 -H "Accept: application/json" -H "Authorization: Bearer TOKEN" \
 -H "Content-Type: application/json" \
 -d '{"judul":"Laskar Pelangi","penulis":"Andrea Hirata"}'

# 4. lihat buku sendiri
curl http://localhost:8000/api/bukus \
 -H "Accept: application/json" -H "Authorization: Bearer TOKEN"
</pre>
<p class="muted">Bukti middleware: login sebagai user B, coba GET/PUT/DELETE buku milik user A -&gt; akan dapat <span class="badge red">403 Forbidden</span>.</p>
</div>

<div class="card">
<p class="muted">File penting untuk dinilai dosen: <code>routes/api.php</code>, <code>app/Http/Middleware/EnsureBukuOwner.php</code>, <code>app/Http/Middleware/EnsureUserOwner.php</code>, <code>app/Http/Controllers/Api/</code>, <code>app/Models/Buku.php</code>.</p>
</div>
</div>
</body>
</html>
