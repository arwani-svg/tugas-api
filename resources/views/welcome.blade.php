<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Panduan Uji API — User & Buku</title>
<style>
:root{--bg:#f4f6fb;--card:#fff;--ink:#0f172a;--muted:#64748b;--line:#e2e8f0;--green:#15803d;--greenbg:#dcfce7;--blue:#1d4ed8;--bluebg:#dbeafe;--orange:#c2410c;--orangebg:#ffedd5;--red:#b91c1c;--redbg:#fee2e2;--slate:#475569;--slatebg:#f1f5f9}
*{box-sizing:border-box}body{font-family:system-ui,-apple-system,Segoe UI,Roboto,Arial,sans-serif;background:var(--bg);margin:0;color:var(--ink)}
.wrap{max-width:1020px;margin:0 auto;padding:28px 18px 60px}
.hero{background:linear-gradient(135deg,#0f172a,#1e40af);color:#fff;border-radius:16px;padding:28px;box-shadow:0 10px 30px rgba(15,23,42,.2)}
.hero h1{margin:0 0 6px;font-size:28px}.hero p{margin:6px 0;color:#cbd5e1}
.basebar{display:flex;flex-wrap:wrap;gap:10px;margin-top:14px}
.basebar .url{background:#fff;color:#0f172a;border-radius:10px;padding:10px 14px;font-weight:600}
.chip{background:rgba(255,255,255,.15);border:1px solid rgba(255,255,255,.25);padding:6px 12px;border-radius:999px;font-size:13px}
.card{background:var(--card);border:1px solid var(--line);border-radius:14px;padding:22px;margin-top:18px;box-shadow:0 4px 16px rgba(15,23,42,.05)}
.card h2{margin:0 0 4px;font-size:20px}.sub{color:var(--muted);font-size:14px;margin:0 0 14px}
.steps{display:grid;gap:12px;margin-top:12px}
.step{display:flex;gap:14px;border:1px solid var(--line);border-radius:12px;padding:14px;background:#f8fafc}
.num{flex:0 0 34px;height:34px;border-radius:50%;background:#0f172a;color:#fff;display:flex;align-items:center;justify-content:center;font-weight:700}
.step h3{margin:0 0 4px;font-size:15px}.step p,.step li{font-size:14px;color:#334155;margin:4px 0}
.step ol{margin:6px 0 0 18px;padding:0}
.fieldtable{width:100%;border-collapse:collapse;font-size:14px;margin-top:10px}
.fieldtable th,.fieldtable td{border:1px solid var(--line);padding:8px 10px;text-align:left;vertical-align:top}
.fieldtable th{background:#f8fafc;font-size:12px;text-transform:uppercase;letter-spacing:.04em;color:var(--muted)}
.req{color:var(--red);font-weight:700}.opt{color:var(--muted)}
.ep{border:1px solid var(--line);border-radius:12px;padding:12px 14px;margin:10px 0;display:flex;flex-wrap:wrap;gap:10px;align-items:center;background:#fff}
.method{font-size:12px;font-weight:800;padding:5px 10px;border-radius:999px;min-width:64px;text-align:center}
.m-get{background:var(--greenbg);color:var(--green)}.m-post{background:var(--bluebg);color:var(--blue)}.m-put{background:var(--orangebg);color:var(--orange)}.m-del{background:var(--redbg);color:var(--red)}
.path{font-family:ui-monospace,Menlo,Consolas,monospace;font-size:14px;font-weight:600}
.lock{font-size:12px;background:var(--slatebg);color:var(--slate);padding:4px 10px;border-radius:999px}
.lock.ok{background:var(--greenbg);color:var(--green)}
.btn{border:1px solid var(--line);background:#fff;border-radius:9px;padding:8px 12px;font-size:13px;cursor:pointer}
.btn:hover{border-color:#0f172a}.btn.primary{background:#0f172a;color:#fff;border-color:#0f172a}.btn.small{padding:5px 10px;font-size:12px}
.grid2{display:grid;grid-template-columns:1fr 1fr;gap:14px}@media(max-width:760px){.grid2{grid-template-columns:1fr}}
label{font-size:13px;font-weight:600;color:#334155;display:block;margin:10px 0 4px}
input,select,textarea{width:100%;border:1px solid var(--line);border-radius:9px;padding:10px;font-size:14px;background:#fff}
textarea{min-height:76px;font-family:ui-monospace,Menlo,monospace;font-size:13px}
.result{border:1px solid var(--line);border-radius:10px;background:#f8fafc;padding:12px;margin-top:10px;font-size:13px}
.status{font-weight:800;padding:3px 10px;border-radius:999px;font-size:12px}
.s-ok{background:var(--greenbg);color:var(--green)}.s-err{background:var(--redbg);color:var(--red)}.s-warn{background:var(--orangebg);color:var(--orange)}
.jsonbox{background:#fff;border:1px dashed var(--line);border-radius:8px;padding:10px;margin-top:8px;white-space:pre-wrap;word-break:break-word;font-family:ui-monospace,Menlo,monospace;font-size:12px;color:#0f172a;max-height:260px;overflow:auto}
.check{width:100%;border-collapse:collapse;font-size:14px}
.check th,.check td{border:1px solid var(--line);padding:10px;text-align:left}
.check th{background:#0f172a;color:#fff;font-size:12px}
code.light{background:var(--slatebg);color:#0f172a;padding:2px 7px;border-radius:6px;font-size:13px}
.note{background:#fffbeb;border:1px solid #fcd34d;border-radius:10px;padding:12px;font-size:14px;margin-top:12px}
.tokbox{display:flex;gap:8px;align-items:center}.tokbox input{font-family:ui-monospace,monospace;font-size:12px}
footer{color:var(--muted);font-size:13px;text-align:center;margin-top:22px}
</style>
</head>
<body>
<div class="wrap">

<div class="hero">
<h1>Panduan Uji API — User &amp; Buku</h1>
<p>Tugas Pemrograman Integratif &middot; Laravel 11 + Sanctum &middot; Fokus penilaian: endpoint API berjalan dan middleware ownership benar.</p>
<div class="basebar">
<span class="url" id="baseUrlLabel">{{ url('/api') }}</span>
<button class="btn small" onclick="salin(document.getElementById('baseUrlLabel').innerText)">Salin Base URL</button>
<span class="chip">Header wajib: Accept: application/json</span>
<span class="chip">Auth: Authorization: Bearer TOKEN</span>
</div>
</div>

<div class="card">
<h2>A. Alur uji yang disarankan (5 langkah)</h2>
<p class="sub">Ikuti urutan ini dari atas ke bawah. Bisa lewat panel interaktif di bawah, atau lewat Postman / Thunder Client.</p>
<div class="steps">
<div class="step"><div class="num">1</div><div><h3>Daftarkan 2 user berbeda</h3><p>Gunakan form <b>Register</b> di panel bawah, atau <span class="method m-post">POST</span> <span class="path">/api/register</span></p><ol><li>User A: nama User A, email a@mail.com, password password123</li><li>User B: nama User B, email b@mail.com, password password123</li></ol></div></div>
<div class="step"><div class="num">2</div><div><h3>Login dan simpan token masing-masing</h3><p>Gunakan form <b>Login</b>. Token A dan Token B harus dibedakan. Token tampil otomatis dan tersimpan di browser.</p></div></div>
<div class="step"><div class="num">3</div><div><h3>User A membuat 1–2 buku</h3><p>Gunakan form <b>Buat Buku</b> dengan Token A. Catat <code class="light">id</code> buku yang terbentuk, misal id = 1.</p></div></div>
<div class="step"><div class="num">4</div><div><h3>Uji akses normal (harus berhasil)</h3><ol><li>Token A → Lihat daftar buku, detail buku, dan <span class="path">/api/users/{id}/bukus</span> milik sendiri → harus <b>200</b></li><li>Token B → Lihat daftar bukunya sendiri → boleh kosong tapi <b>200</b></li></ol></div></div>
<div class="step"><div class="num">5</div><div><h3>Uji middleware kepemilikan (harus ditolak)</h3><ol><li>Token B → coba buka, ubah, hapus buku id milik A → harus <b>403</b></li><li>Token B → coba buka <span class="path">/api/users/1/bukus</span> milik A → harus <b>403</b></li></ol></div></div>
</div>
<div class="note">Patokan lulus: akses milik sendiri = <b>200 / 201</b>, akses milik user lain = <b>403 Forbidden</b>, tanpa token = <b>401 Unauthenticated</b>.</div>
</div>

<div class="card">
<h2>B. Daftar endpoint dan data yang dibutuhkan</h2>
<p class="sub">Tidak perlu hafal curl. Cukup tahu method, alamat, dan field-nya. Tombol Salin untuk ditempel ke Postman.</p>

<h3>1. Auth</h3>
<div class="ep"><span class="method m-post">POST</span><span class="path">/api/register</span><span class="lock">tanpa token</span><button class="btn small" onclick="salin(base()+'/register')">Salin</button></div>
<div class="ep"><span class="method m-post">POST</span><span class="path">/api/login</span><span class="lock">tanpa token</span><button class="btn small" onclick="salin(base()+'/login')">Salin</button></div>
<div class="ep"><span class="method m-post">POST</span><span class="path">/api/logout</span><span class="lock ok">butuh token</span><button class="btn small" onclick="salin(base()+'/logout')">Salin</button></div>
<div class="ep"><span class="method m-get">GET</span><span class="path">/api/me</span><span class="lock ok">butuh token</span><button class="btn small" onclick="salin(base()+'/me')">Salin</button></div>

<table class="fieldtable">
<tr><th>Form</th><th>Field</th><th>Wajib</th></tr>
<tr><td>Register</td><td>name, email, password, password_confirmation</td><td><span class="req">wajib semua</span>, password min 6</td></tr>
<tr><td>Login</td><td>email, password</td><td><span class="req">wajib</span></td></tr>
</table>

<h3 style="margin-top:18px">2. User</h3>
<div class="ep"><span class="method m-get">GET</span><span class="path">/api/users</span><span class="lock ok">butuh token</span><button class="btn small" onclick="salin(base()+'/users')">Salin</button></div>
<div class="ep"><span class="method m-get">GET</span><span class="path">/api/users/{id}</span><span class="lock ok">token + milik sendiri</span></div>
<div class="ep"><span class="method m-put">PUT</span><span class="path">/api/users/{id}</span><span class="lock ok">token + milik sendiri</span></div>
<div class="ep"><span class="method m-del">DELETE</span><span class="path">/api/users/{id}</span><span class="lock ok">token + milik sendiri</span></div>
<div class="ep"><span class="method m-get">GET</span><span class="path">/api/users/{id}/bukus</span><span class="lock ok">token + milik sendiri — bukti akses buku dari user</span></div>

<h3 style="margin-top:18px">3. Buku</h3>
<div class="ep"><span class="method m-get">GET</span><span class="path">/api/bukus</span><span class="lock ok">butuh token, hanya milik sendiri</span><button class="btn small" onclick="salin(base()+'/bukus')">Salin</button></div>
<div class="ep"><span class="method m-post">POST</span><span class="path">/api/bukus</span><span class="lock ok">butuh token</span><button class="btn small" onclick="salin(base()+'/bukus')">Salin</button></div>
<div class="ep"><span class="method m-get">GET</span><span class="path">/api/bukus/{id}</span><span class="lock ok">token + buku.owner</span></div>
<div class="ep"><span class="method m-put">PUT</span><span class="path">/api/bukus/{id}</span><span class="lock ok">token + buku.owner</span></div>
<div class="ep"><span class="method m-del">DELETE</span><span class="path">/api/bukus/{id}</span><span class="lock ok">token + buku.owner</span></div>

<table class="fieldtable">
<tr><th>Field buku</th><th>Aturan</th></tr>
<tr><td>judul</td><td><span class="req">wajib</span>, teks max 255</td></tr>
<tr><td>penulis</td><td><span class="req">wajib</span>, teks max 255</td></tr>
<tr><td>penerbit</td><td><span class="opt">opsional</span></td></tr>
<tr><td>tahun_terbit</td><td><span class="opt">opsional</span>, 4 digit misal 2005</td></tr>
<tr><td>isbn</td><td><span class="opt">opsional</span></td></tr>
<tr><td>deskripsi</td><td><span class="opt">opsional</span></td></tr>
</table>
<p class="sub">Contoh isi: judul Laskar Pelangi, penulis Andrea Hirata, penerbit Bentang Pustaka, tahun_terbit 2005.</p>
</div>

<div class="card">
<h2>C. Uji langsung dari halaman ini</h2>
<p class="sub">Isi form lalu tekan tombol. Hasil muncul di bawah tiap form beserta kode statusnya. Token tersimpan otomatis di browser.</p>
<div class="grid2">
<div>
<label>Base URL API</label>
<div class="tokbox"><input id="baseUrl" value="{{ url('/api') }}"><button class="btn" onclick="resetBase()">Reset</button></div>
<label>Token aktif (dapat dari Register / Login)</label>
<div class="tokbox"><input id="token" placeholder="Bearer token akan muncul di sini"><button class="btn" onclick="navigator.clipboard.writeText(document.getElementById('token').value);alert('Token disalin')">Salin</button></div>
<p class="sub">Beralih user cukup login ulang sebagai user lain, token akan terganti. Untuk uji 403, login sebagai B lalu akses id milik A.</p>
</div>
<div>
<label>Hasil terakhir</label>
<div class="result" id="globalResult">Belum ada request. Mulai dari Register di bawah.</div>
</div>
</div>

<div class="grid2">
<div class="card" style="margin-top:14px">
<h3>Register</h3>
<label>Nama</label><input id="r_name" value="User A">
<label>Email</label><input id="r_email" value="a@mail.com">
<label>Password</label><input id="r_pass" type="password" value="password123">
<button class="btn primary" style="margin-top:10px" onclick="doRegister()">Daftar</button>
<div class="result" id="resRegister">-</div>
</div>
<div class="card" style="margin-top:14px">
<h3>Login</h3>
<label>Email</label><input id="l_email" value="a@mail.com">
<label>Password</label><input id="l_pass" type="password" value="password123">
<button class="btn primary" style="margin-top:10px" onclick="doLogin()">Masuk &amp; pakai token</button>
<div class="result" id="resLogin">-</div>
</div>
</div>

<div class="grid2">
<div class="card" style="margin-top:14px">
<h3>Buat Buku (butuh token)</h3>
<label>Judul *</label><input id="b_judul" value="Laskar Pelangi">
<label>Penulis *</label><input id="b_penulis" value="Andrea Hirata">
<label>Penerbit</label><input id="b_penerbit" value="Bentang Pustaka">
<label>Tahun terbit</label><input id="b_tahun" value="2005">
<button class="btn primary" style="margin-top:10px" onclick="doCreateBuku()">Simpan buku</button>
<div class="result" id="resCreate">-</div>
</div>
<div class="card" style="margin-top:14px">
<h3>Lihat / Uji kepemilikan (butuh token)</h3>
<label>ID buku</label><input id="c_id" value="1">
<div style="display:flex;gap:8px;flex-wrap:wrap;margin-top:10px">
<button class="btn" onclick="doList()">List milikku</button>
<button class="btn" onclick="doDetail()">Detail per ID</button>
<button class="btn" onclick="doDelete()">Hapus per ID</button>
</div>
<label>ID user untuk cek buku dari user</label>
<div style="display:flex;gap:8px"><input id="u_id" value="1"><button class="btn" onclick="doUserBukus()">Cek</button></div>
<div class="result" id="resCheck">-</div>
</div>
</div>
</div>

<div class="card">
<h2>D. Checklist pembuktian untuk dosen</h2>
<p class="sub">Centang satu per satu. Kolom Harapan adalah kunci penilaian middleware.</p>
<table class="check">
<tr><th>No</th><th>Aktor</th><th>Tindakan</th><th>Harapan</th></tr>
<tr><td>1</td><td>Tanpa token</td><td>Buka <code class="light">GET /api/bukus</code></td><td><span class="status s-warn">401 Unauthenticated</span></td></tr>
<tr><td>2</td><td>User A</td><td>Buat buku, lalu <code class="light">GET /api/bukus/1</code></td><td><span class="status s-ok">200 + data buku</span></td></tr>
<tr><td>3</td><td>User A</td><td>Buka <code class="light">GET /api/users/1/bukus</code></td><td><span class="status s-ok">200 + list buku A</span></td></tr>
<tr><td>4</td><td>User B</td><td>Buka <code class="light">GET /api/bukus/1</code> milik A</td><td><span class="status s-err">403 Forbidden</span></td></tr>
<tr><td>5</td><td>User B</td><td>Ubah / hapus <code class="light">/api/bukus/1</code> milik A</td><td><span class="status s-err">403 Forbidden</span></td></tr>
<tr><td>6</td><td>User B</td><td>Buka <code class="light">GET /api/users/1/bukus</code> milik A</td><td><span class="status s-err">403 Forbidden</span></td></tr>
</table>
<div class="note">Pesan 403 yang benar: <code class="light">Forbidden: buku ini milik user lain, tidak bisa diakses.</code> — berasal dari middleware <code class="light">EnsureBukuOwner</code> dan <code class="light">EnsureUserOwner</code>.</div>
</div>

<div class="card">
<h2>E. File yang dinilai</h2>
<p class="sub"><code class="light">routes/api.php</code> · <code class="light">bootstrap/app.php</code> (alias buku.owner, user.owner) · <code class="light">app/Http/Middleware/EnsureBukuOwner.php</code> · <code class="light">app/Http/Middleware/EnsureUserOwner.php</code> · <code class="light">app/Http/Controllers/Api/</code> · <code class="light">app/Models/Buku.php</code></p>
</div>

<footer>Sistem API User &amp; Buku · Laravel 11 · Uji via halaman ini / Postman / Thunder Client / test-api.sh</footer>
</div>

<script>
function base(){return document.getElementById('baseUrl').value.replace(/\/$/,'')}
function salin(t){navigator.clipboard.writeText(t).then(()=>alert('Disalin: '+t))}
function resetBase(){document.getElementById('baseUrl').value=document.getElementById('baseUrlLabel').innerText}
function authH(){const t=document.getElementById('token').value.trim();return t?{'Authorization':'Bearer '+t}:{} }
function show(el,data,status){const box=document.getElementById(el);const g=document.getElementById('globalResult');let cls=status>=200&&status<300?'s-ok':(status===403||status===401?'s-err':'s-warn');let html='<span class="status '+cls+'">'+status+'</span><div class="jsonbox">'+escapeHtml(JSON.stringify(data,null,2))+'</div>';box.innerHTML=html;g.innerHTML='<b>'+el+'</b> → '+html}
function escapeHtml(s){return s.replace(/&/g,'&amp;').replace(/</g,'&lt;')}
async function req(method,path,body,useAuth=true){let h={'Accept':'application/json','Content-Type':'application/json'};if(useAuth)Object.assign(h,authH());let o={method,headers:h};if(body)o.body=JSON.stringify(body);let r=await fetch(base()+path,o);let d={};try{d=await r.json()}catch(e){d={raw:await r.text()}}return{status:r.status,data:d}}
async function doRegister(){let b={name:val('r_name'),email:val('r_email'),password:val('r_pass'),password_confirmation:val('r_pass')};let r=await req('POST','/register',b,false);if(r.data.token)document.getElementById('token').value=r.data.token;show('resRegister',r.data,r.status)}
async function doLogin(){let b={email:val('l_email'),password:val('l_pass')};let r=await req('POST','/login',b,false);if(r.data.token)document.getElementById('token').value=r.data.token;show('resLogin',r.data,r.status)}
async function doCreateBuku(){let b={judul:val('b_judul'),penulis:val('b_penulis'),penerbit:val('b_penerbit'),tahun_terbit:val('b_tahun')};let r=await req('POST','/bukus',b,true);show('resCreate',r.data,r.status)}
async function doList(){let r=await req('GET','/bukus',null,true);show('resCheck',r.data,r.status)}
async function doDetail(){let r=await req('GET','/bukus/'+val('c_id'),null,true);show('resCheck',r.data,r.status)}
async function doDelete(){if(!confirm('Hapus buku id '+val('c_id')+'?'))return;let r=await req('DELETE','/bukus/'+val('c_id'),null,true);show('resCheck',r.data,r.status)}
async function doUserBukus(){let r=await req('GET','/users/'+val('u_id')+'/bukus',null,true);show('resCheck',r.data,r.status)}
function val(id){return document.getElementById(id).value.trim()}
</script>
</body>
</html>
