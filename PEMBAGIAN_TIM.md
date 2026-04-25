# 👥 PEMBAGIAN TUGAS TIM SUGARBASE
## Proyek: E-Commerce Dessert — Laravel Full-Stack
### Format: 3 Orang × Full-Stack (Frontend + Backend + Database)

---

## 🗺️ PETA FITUR LENGKAP

```
SugarBase
├── AUTH            → Login, Register, Logout
├── BERANDA         → Hero, produk unggulan, kategori, promo
├── KATALOG         → Filter kategori, sort harga, grid produk
├── SEARCH          → Real-time search di sidebar
├── DETAIL PRODUK   → Foto, deskripsi, stok, tombol keranjang
├── KERANJANG       → List item, qty, subtotal, checkout
├── PEMBAYARAN      → Pilih metode, konfirmasi, upload bukti
├── ORDER TRACKING  → Timeline status pesanan real-time
├── NOTIFIKASI      → Bell icon, list notif, badge unread
├── PROFIL          → Edit profil, riwayat pesanan
└── ADMIN PANEL
    ├── Dashboard   → Statistik penjualan, grafik
    ├── Produk      → CRUD produk, upload foto, manage stok
    ├── Kategori    → CRUD kategori
    ├── Pesanan     → List pesanan, update status
    └── Pelanggan   → List & detail pelanggan
```

---

## ⚠️ PENTING SEBELUM MULAI

Tambahkan migration ini **pertama** sebelum fitur apapun:

```bash
php artisan make:migration add_role_to_users_table
```

Isi method `up()`:
```php
$table->enum('role', ['admin', 'pelanggan'])->default('pelanggan')->after('name');
```

Lalu jalankan:
```bash
php artisan migrate
```

---

---

# 👤 ANGGOTA A — Auth, Layout & Katalog

## Tanggung Jawab Utama:
Halaman Login, Register, struktur Layout + Sidebar + Navbar, halaman Beranda, halaman Katalog (filter + sort), dan fitur Search global.

---

## 📋 DAFTAR TASK DETAIL

### A1. Migration Tambahan
File: `database/migrations/2026_04_25_000004_add_role_to_users_table.php`
- Tambahkan kolom `role` enum ('admin', 'pelanggan') ke tabel `users`
- Jalankan `php artisan migrate`

---

### A2. Halaman Login
**Route:** `GET /login` | `POST /login`
**Controller:** `AuthController@showLogin`, `AuthController@login`
**View:** `resources/views/auth/login.blade.php`

Tampilan yang harus ada:
- Logo SugarBase di tengah atas
- Form: email + password
- Tombol "Masuk"
- Link "Belum punya akun? Daftar"
- Validasi error inline (email tidak valid, password salah, dll)
- Redirect setelah login:
  - Jika `role = admin` → `/admin/dashboard`
  - Jika `role = pelanggan` → `/beranda`

Backend:
```php
public function login(Request $request)
{
    $request->validate([
        'email'    => 'required|email',
        'password' => 'required|min:6',
    ]);

    if (Auth::attempt($request->only('email', 'password'))) {
        $request->session()->regenerate();
        $user = Auth::user();
        return redirect($user->role === 'admin' ? '/admin/dashboard' : '/beranda');
    }

    return back()->withErrors(['email' => 'Email atau password salah.']);
}
```

---

### A3. Halaman Register
**Route:** `GET /register` | `POST /register`
**Controller:** `AuthController@showRegister`, `AuthController@register`
**View:** `resources/views/auth/register.blade.php`

Tampilan yang harus ada:
- Form: name, email, password, password_confirmation
- Role default otomatis = 'pelanggan' (tidak ditampilkan ke user)
- Validasi: email unique, password minimal 8 karakter, konfirmasi password cocok
- Redirect ke `/beranda` setelah berhasil daftar + auto-login

---

### A4. Middleware & Auth Guard
**File baru:** `app/Http/Middleware/AdminMiddleware.php`

```php
public function handle(Request $request, Closure $next): Response
{
    if (!Auth::check() || Auth::user()->role !== 'admin') {
        return redirect('/login')->with('error', 'Akses ditolak.');
    }
    return $next($request);
}
```

Daftarkan di `bootstrap/app.php`:
```php
->withMiddleware(function (Middleware $middleware) {
    $middleware->alias([
        'admin' => \App\Http\Middleware\AdminMiddleware::class,
    ]);
})
```

---

### A5. Layout Utama (Pelanggan)
**File:** `resources/views/layouts/app.blade.php`

Struktur halaman:
```
┌──────────────────────────────────────────────────────┐
│ NAVBAR TOP                                            │
│ [Logo SugarBase] [Search Bar] [🔔] [🛒] [Avatar]    │
├──────────────────────────────────────────────────────┤
│            @yield('content')                         │
│                                                      │
├──────────────────────────────────────────────────────┤
│ BOTTOM NAV (mobile) [🏠][🍰][🛒][📦][👤]            │
└──────────────────────────────────────────────────────┘
```

Komponen yang harus ada di layout ini:
- **Navbar:** Logo, search bar (input global), bell icon + badge count unread notif, cart icon + badge count, avatar dropdown (Profil, Riwayat Pesanan, Logout)
- **Bottom Nav Mobile:** Beranda, Katalog, Keranjang, Pesanan, Profil
- Include CSS color: `#FBFBFB` (background), `#E8F9FF` (card), `#C4D9FF` (border/accent), `#C5BAFF` (highlight)

---

### A6. Layout Admin
**File:** `resources/views/layouts/admin.blade.php`

Struktur:
```
┌──────────┬───────────────────────────────────────────┐
│ SIDEBAR  │ HEADER: [Breadcrumb] [Admin Avatar]       │
│ (fixed)  ├───────────────────────────────────────────┤
│ Logo     │                                           │
│ ─────    │   @yield('content')                       │
│ Dashboard│                                           │
│ Produk   │                                           │
│ Kategori │                                           │
│ Pesanan  │                                           │
│ Pelanggan│                                           │
│ ─────    │                                           │
│ Logout   │                                           │
└──────────┴───────────────────────────────────────────┘
```

Fitur sidebar:
- Active link highlight menggunakan `request()->routeIs('admin.*')`
- Search bar di dalam sidebar untuk filter menu
- Collapse ke icon saja di layar kecil

---

### A7. Halaman Beranda (Pelanggan)
**Route:** `GET /beranda` (atau `/`)
**Controller:** `BerandaController@index`
**View:** `resources/views/beranda/index.blade.php`
**Model yang digunakan:** `Produk`, `Kategori`

Section yang harus ada:

**7a. Hero Banner**
- Gambar/ilustrasi dessert besar
- Teks tagline: "Semua Manis, Satu Platform"
- Tombol "Belanja Sekarang" → ke `/katalog`

**7b. Kategori Cepat**
- Grid horizontal scrollable 6 kategori
- Klik kategori → ke `/katalog?kategori={id}`
- Ambil data dari: `Kategori::all()`

**7c. Produk Terlaris**
- 8 produk dengan stok tertinggi atau paling sering dipesan
- Query:
```php
$produkTerlaris = Produk::where('status_produk', 'aktif')
    ->withCount('pesananItem')
    ->orderBy('pesanan_item_count', 'desc')
    ->take(8)
    ->get();
```
- Card produk: foto, nama, harga, badge kategori, tombol "Tambah ke Keranjang"

**7d. Produk Terbaru**
- 4 produk paling baru (`orderBy('created_at', 'desc')`)

**7e. Banner Promo** (opsional)
- Banner statis atau dari database

---

### A8. Halaman Katalog
**Route:** `GET /katalog`
**Controller:** `KatalogController@index`
**View:** `resources/views/katalog/index.blade.php`

Filter yang harus berjalan:
- `?kategori={id}` → filter berdasarkan kategori
- `?sort=harga_asc` → harga terendah
- `?sort=harga_desc` → harga tertinggi
- `?sort=terbaru` → produk terbaru
- `?q={kata}` → search nama produk (dari sidebar)

Query builder:
```php
$query = Produk::with('kategori')->where('status_produk', 'aktif');

if ($request->filled('kategori')) {
    $query->where('id_kategori', $request->kategori);
}

if ($request->filled('q')) {
    $query->where('nama_produk', 'like', '%' . $request->q . '%');
}

match ($request->sort) {
    'harga_asc'  => $query->orderBy('harga', 'asc'),
    'harga_desc' => $query->orderBy('harga', 'desc'),
    default      => $query->latest(),
};

$produk = $query->paginate(12);
```

Tampilan:
- Filter bar di atas grid (tab kategori + sort dropdown)
- Grid produk: 2 kolom mobile, 3 kolom tablet, 4 kolom desktop
- Pagination laravel di bawah

---

### A9. Search Real-Time (Global)
**Route:** `GET /search` (AJAX)
**Controller:** `SearchController@index`
**View partial:** `resources/views/components/search-results.blade.php`

Cara kerja:
- Input search di navbar melakukan fetch ke `/search?q={kata}`
- Response JSON berisi array produk (id, nama, harga, foto)
- Ditampilkan sebagai dropdown dibawah input
- Klik item → ke halaman detail produk

```php
public function index(Request $request)
{
    $produk = Produk::where('nama_produk', 'like', '%' . $request->q . '%')
        ->where('status_produk', 'aktif')
        ->take(5)
        ->get(['id_produk', 'nama_produk', 'harga', 'foto']);

    return response()->json($produk);
}
```

---

### A10. Model yang Dibuat Anggota A
```bash
php artisan make:model Kategori
php artisan make:model Produk
```

`Produk.php`:
```php
protected $primaryKey = 'id_produk';

public function kategori()
{
    return $this->belongsTo(Kategori::class, 'id_kategori', 'id_kategori');
}

public function keranjangItem()
{
    return $this->hasMany(KeranjangItem::class, 'id_produk', 'id_produk');
}

public function pesananItem()
{
    return $this->hasMany(PesananItem::class, 'id_produk', 'id_produk');
}
```

`Kategori.php`:
```php
protected $primaryKey = 'id_kategori';

public function produk()
{
    return $this->hasMany(Produk::class, 'id_kategori', 'id_kategori');
}
```

---

### A11. Routes yang Dibuat Anggota A
Tambahkan ke `routes/web.php`:
```php
/* Auth */
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

/* Pelanggan (harus login) */
Route::middleware('auth')->group(function () {
    Route::get('/', [BerandaController::class, 'index'])->name('beranda');
    Route::get('/beranda', [BerandaController::class, 'index']);
    Route::get('/katalog', [KatalogController::class, 'index'])->name('katalog');
    Route::get('/produk/{id}', [ProdukController::class, 'show'])->name('produk.show');
    Route::get('/search', [SearchController::class, 'index'])->name('search');
});
```

---

### A12. Checklist Anggota A
- [ ] Migration `add_role_to_users_table` berjalan
- [ ] Login berhasil + redirect berdasarkan role
- [ ] Register membuat akun dengan role 'pelanggan'
- [ ] Middleware admin menolak pelanggan masuk area admin
- [ ] Layout app.blade.php tampil di semua halaman pelanggan
- [ ] Layout admin.blade.php tampil di semua halaman admin
- [ ] Sidebar admin memiliki active link indicator
- [ ] Beranda menampilkan: hero, kategori, produk terlaris, terbaru
- [ ] Katalog dapat filter by kategori
- [ ] Katalog dapat sort (harga naik, harga turun, terbaru)
- [ ] Search real-time menghasilkan dropdown
- [ ] Responsive: beranda & katalog tampil baik di mobile

---

---

# 👤 ANGGOTA B — Keranjang, Pesanan & Pembayaran

## Tanggung Jawab Utama:
Halaman Detail Produk, Keranjang belanja, proses Checkout, halaman Pembayaran (pilih metode, konfirmasi, upload bukti), dan halaman Riwayat Pesanan milik pelanggan.

---

## 📋 DAFTAR TASK DETAIL

### B1. Halaman Detail Produk
**Route:** `GET /produk/{id}`
**Controller:** `ProdukController@show`
**View:** `resources/views/produk/show.blade.php`

Yang harus ditampilkan:
- Foto produk besar (jika tidak ada foto tampilkan placeholder)
- Nama, kategori badge, harga, stok tersedia
- Deskripsi produk
- Input jumlah (qty) dengan tombol +/−
- Tombol "Tambah ke Keranjang" (POST ke `/keranjang/tambah`)
- Validasi: jumlah tidak boleh melebihi stok

---

### B2. Keranjang — Tampil
**Route:** `GET /keranjang`
**Controller:** `KeranjangController@index`
**View:** `resources/views/keranjang/index.blade.php`

Logic:
```php
public function index()
{
    $keranjang = Keranjang::with('items.produk')
        ->where('user_id', Auth::id())
        ->where('status_keranjang', 'aktif')
        ->first();

    return view('keranjang.index', compact('keranjang'));
}
```

Tampilan tabel keranjang:
```
┌──────┬───────────────────┬──────┬──────────┬──────────┬────────┐
│ Foto │ Nama Produk       │ Harga│  Jumlah  │ Subtotal │ Hapus  │
├──────┼───────────────────┼──────┼──────────┼──────────┼────────┤
│  🍰  │ Red Velvet Slice  │ 38rb │ [−][2][+]│   76rb   │   🗑   │
│  🍦  │ Boba Brown Sugar  │ 28rb │ [−][2][+]│   56rb   │   🗑   │
└──────┴───────────────────┴──────┴──────────┴──────────┴────────┘
                                        Total: Rp 132.000
                                        [Lanjut ke Pembayaran]
```

---

### B3. Keranjang — Tambah Item
**Route:** `POST /keranjang/tambah`
**Controller:** `KeranjangController@tambah`

Logic:
```php
public function tambah(Request $request)
{
    $request->validate([
        'id_produk' => 'required|exists:produk,id_produk',
        'jumlah'    => 'required|integer|min:1',
    ]);

    $produk = Produk::findOrFail($request->id_produk);

    if ($request->jumlah > $produk->stok) {
        return back()->with('error', 'Stok tidak mencukupi.');
    }

    $keranjang = Keranjang::firstOrCreate(
        ['user_id' => Auth::id(), 'status_keranjang' => 'aktif'],
        ['tanggal_dibuat' => today()]
    );

    $item = $keranjang->items()->where('id_produk', $request->id_produk)->first();

    if ($item) {
        $jumlahBaru = $item->jumlah_keranjang + $request->jumlah;
        $item->update([
            'jumlah_keranjang'   => $jumlahBaru,
            'subtotal_keranjang' => $produk->harga * $jumlahBaru,
        ]);
    } else {
        $keranjang->items()->create([
            'id_produk'               => $request->id_produk,
            'jumlah_keranjang'        => $request->jumlah,
            'harga_satuan_keranjang'  => $produk->harga,
            'subtotal_keranjang'      => $produk->harga * $request->jumlah,
        ]);
    }

    return redirect('/keranjang')->with('success', 'Produk ditambahkan ke keranjang!');
}
```

---

### B4. Keranjang — Update Jumlah
**Route:** `POST /keranjang/update/{id_item}`
**Controller:** `KeranjangController@update`

- Recalculate `subtotal_keranjang` = `harga_satuan × jumlah_baru`
- Validasi jumlah tidak melebihi stok produk

---

### B5. Keranjang — Hapus Item
**Route:** `DELETE /keranjang/hapus/{id_item}`
**Controller:** `KeranjangController@hapus`

- Soft delete item dari `keranjang_item`
- Jika keranjang kosong, tampilkan ilustrasi kosong

---

### B6. Checkout — Konfirmasi Pesanan
**Route:** `GET /checkout` | `POST /checkout`
**Controller:** `CheckoutController@index`, `CheckoutController@proses`
**View:** `resources/views/checkout/index.blade.php`

Halaman konfirmasi menampilkan:
- Ringkasan item keranjang (read-only)
- Total harga
- Form pilih metode pembayaran (radio: Transfer Bank / COD / E-Wallet)
- Tombol "Buat Pesanan"

Logic POST:
```php
public function proses(Request $request)
{
    $keranjang = Keranjang::with('items.produk')
        ->where('user_id', Auth::id())
        ->where('status_keranjang', 'aktif')
        ->firstOrFail();

    $total = $keranjang->items->sum('subtotal_keranjang');

    /* Buat pesanan */
    $pesanan = Pesanan::create([
        'user_id'        => Auth::id(),
        'tanggal_pesan'  => today(),
        'total_harga'    => $total,
        'status_pesanan' => 'pending',
    ]);

    /* Pindahkan item keranjang → pesanan_item */
    foreach ($keranjang->items as $item) {
        $pesanan->items()->create([
            'id_produk'            => $item->id_produk,
            'jumlah_pesanan'       => $item->jumlah_keranjang,
            'harga_satuan_pesanan' => $item->harga_satuan_keranjang,
            'subtotal_pesanan'     => $item->subtotal_keranjang,
        ]);

        /* Kurangi stok produk */
        $item->produk->decrement('stok', $item->jumlah_keranjang);
    }

    /* Buat record pembayaran */
    Pembayaran::create([
        'id_pesanan'        => $pesanan->id_pesanan,
        'metode_pembayaran' => $request->metode,
        'status_pembayaran' => 'menunggu',
        'tanggal_bayar'     => today(),
        'jumlah_bayar'      => $total,
    ]);

    /* Update status keranjang → checkout */
    $keranjang->update(['status_keranjang' => 'checkout']);

    /* Buat notifikasi (panggil NotifikasiSeeder helper atau langsung insert) */
    Notifikasi::create([
        'user_id'     => Auth::id(),
        'judul'       => 'Pesanan Berhasil Dibuat',
        'pesan'       => "Pesanan #{$pesanan->id_pesanan} berhasil dibuat. Segera lakukan pembayaran.",
        'waktu_kirim' => now(),
        'status_baca' => 'belum',
    ]);

    return redirect("/pembayaran/{$pesanan->id_pesanan}");
}
```

---

### B7. Halaman Pembayaran
**Route:** `GET /pembayaran/{id_pesanan}`
**Controller:** `PembayaranController@show`
**View:** `resources/views/pembayaran/show.blade.php`

Tampilan berdasarkan metode:

**Transfer Bank:**
- Tampilkan nomor rekening tujuan
- Instruksi transfer
- Tombol "Konfirmasi Sudah Transfer" → update status jadi 'lunas'

**COD:**
- Informasi "Bayar saat barang tiba"
- Tombol "OK, Mengerti"

**E-Wallet:**
- QR Code atau nomor e-wallet
- Tombol "Konfirmasi Pembayaran"

---

### B8. Konfirmasi Pembayaran (Admin approve)
**Route:** `POST /admin/pembayaran/{id}/konfirmasi`
**Controller:** `Admin\PembayaranController@konfirmasi`

```php
public function konfirmasi($id)
{
    $pembayaran = Pembayaran::findOrFail($id);
    $pembayaran->update(['status_pembayaran' => 'lunas']);
    $pembayaran->pesanan->update(['status_pesanan' => 'diproses']);

    /* Kirim notifikasi ke pelanggan */
    Notifikasi::create([
        'user_id'     => $pembayaran->pesanan->user_id,
        'judul'       => 'Pembayaran Dikonfirmasi',
        'pesan'       => "Pembayaran pesanan #{$pembayaran->id_pesanan} telah dikonfirmasi.",
        'waktu_kirim' => now(),
        'status_baca' => 'belum',
    ]);

    return redirect()->back()->with('success', 'Pembayaran dikonfirmasi.');
}
```

---

### B9. Riwayat Pesanan Pelanggan
**Route:** `GET /pesanan/saya`
**Controller:** `PesananController@milikSaya`
**View:** `resources/views/pesanan/saya.blade.php`

- List semua pesanan milik user yang login
- Filter by status (tab: Semua, Pending, Diproses, Dikirim, Selesai, Dibatalkan)
- Klik pesanan → ke halaman detail & tracking (dikerjakan Anggota C)

---

### B10. Admin: Daftar Semua Pesanan
**Route:** `GET /admin/pesanan` (pakai middleware 'admin')
**Controller:** `Admin\PesananController@index`
**View:** `resources/views/admin/pesanan/index.blade.php`

- DataTable semua pesanan dengan filter status
- Tombol update status di setiap baris
- Total revenue per hari ditampilkan di atas tabel

---

### B11. Model yang Dibuat Anggota B
```bash
php artisan make:model Keranjang
php artisan make:model KeranjangItem
php artisan make:model Pesanan
php artisan make:model PesananItem
php artisan make:model Pembayaran
```

`Keranjang.php`:
```php
protected $primaryKey = 'id_keranjang';
protected $table      = 'keranjang';

public function items()
{
    return $this->hasMany(KeranjangItem::class, 'id_keranjang', 'id_keranjang');
}

public function user()
{
    return $this->belongsTo(User::class);
}
```

`Pesanan.php`:
```php
protected $primaryKey = 'id_pesanan';

public function items()
{
    return $this->hasMany(PesananItem::class, 'id_pesanan', 'id_pesanan');
}

public function pembayaran()
{
    return $this->hasOne(Pembayaran::class, 'id_pesanan', 'id_pesanan');
}

public function tracking()
{
    return $this->hasMany(TrackingStatus::class, 'id_pesanan', 'id_pesanan');
}

public function user()
{
    return $this->belongsTo(User::class);
}
```

---

### B12. Routes yang Dibuat Anggota B
```php
Route::middleware('auth')->group(function () {
    /* Produk detail */
    Route::get('/produk/{id}', [ProdukController::class, 'show'])->name('produk.show');

    /* Keranjang */
    Route::get('/keranjang', [KeranjangController::class, 'index'])->name('keranjang');
    Route::post('/keranjang/tambah', [KeranjangController::class, 'tambah']);
    Route::post('/keranjang/update/{id}', [KeranjangController::class, 'update']);
    Route::delete('/keranjang/hapus/{id}', [KeranjangController::class, 'hapus']);

    /* Checkout & Pembayaran */
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
    Route::post('/checkout', [CheckoutController::class, 'proses']);
    Route::get('/pembayaran/{id}', [PembayaranController::class, 'show'])->name('pembayaran.show');
    Route::post('/pembayaran/{id}/konfirmasi', [PembayaranController::class, 'konfirmasiPelanggan']);

    /* Riwayat pesanan */
    Route::get('/pesanan/saya', [PesananController::class, 'milikSaya'])->name('pesanan.saya');
});

/* Admin pesanan */
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/pesanan', [Admin\PesananController::class, 'index'])->name('admin.pesanan');
    Route::post('/pesanan/{id}/status', [Admin\PesananController::class, 'updateStatus']);
    Route::post('/pembayaran/{id}/konfirmasi', [Admin\PembayaranController::class, 'konfirmasi']);
});
```

---

### B13. Checklist Anggota B
- [ ] Detail produk tampil dengan foto, stok, tombol tambah keranjang
- [ ] Tambah ke keranjang berhasil (termasuk jika produk sudah ada di keranjang → qty bertambah)
- [ ] Validasi stok saat tambah ke keranjang
- [ ] Update qty di keranjang berhasil (recalculate subtotal)
- [ ] Hapus item dari keranjang berhasil
- [ ] Checkout membuat record pesanan + pesanan_item + pembayaran
- [ ] Stok produk berkurang setelah checkout
- [ ] Keranjang berubah status 'checkout' setelah pesanan dibuat
- [ ] Halaman pembayaran tampil sesuai metode (transfer/COD/ewallet)
- [ ] Konfirmasi pembayaran update status pembayaran + pesanan
- [ ] Notifikasi dibuat otomatis saat pesanan dibuat & pembayaran dikonfirmasi
- [ ] Riwayat pesanan pelanggan tampil dengan filter status
- [ ] Admin dapat melihat semua pesanan dan update status

---

---

# 👤 ANGGOTA C — Tracking, Notifikasi & Admin Panel

## Tanggung Jawab Utama:
Order Tracking real-time, sistem Notifikasi (bell icon + badge), Admin Dashboard, Admin CRUD Produk, Admin CRUD Kategori, Admin manajemen Pelanggan, dan dark mode toggle (opsional).

---

## 📋 DAFTAR TASK DETAIL

### C1. Halaman Order Tracking (Pelanggan)
**Route:** `GET /pesanan/{id}/tracking`
**Controller:** `TrackingController@show`
**View:** `resources/views/tracking/show.blade.php`

Tampilan timeline vertikal:
```
Pesanan #0003 — Status: Dalam Pengiriman

  ✅ Pesanan Diterima         Senin, 18 Apr 2026 — 09:00
     Pesanan berhasil dibuat...

  ✅ Pembayaran Dikonfirmasi  Senin, 18 Apr 2026 — 09:30
     Pembayaran Rp169.000 dikonfirmasi...

  ✅ Sedang Diproses          Selasa, 19 Apr 2026 — 10:00
     Sedang diproses di dapur...

  🔄 Dalam Pengiriman         Jum'at, 24 Apr 2026 — 08:00  ← AKTIF
     Pesanan dalam perjalanan...

  ○ Pesanan Selesai           (menunggu)
```

Query:
```php
public function show($id)
{
    $pesanan = Pesanan::with(['tracking' => fn($q) => $q->orderBy('waktu_update', 'asc'), 'items.produk'])
        ->where('user_id', Auth::id())
        ->findOrFail($id);

    return view('tracking.show', compact('pesanan'));
}
```

Urutan status yang harus divisualisasikan:
1. Pesanan Diterima
2. Pembayaran Dikonfirmasi
3. Sedang Diproses
4. Dalam Pengiriman
5. Pesanan Selesai / Pesanan Dibatalkan

---

### C2. Auto-Refresh Tracking (Polling)
Tambahkan di view tracking dengan JavaScript sederhana:
```javascript
/* Refresh halaman setiap 30 detik untuk update status terbaru */
setTimeout(function() {
    location.reload();
}, 30000);
```

Alternatif lebih baik: gunakan AJAX fetch ke endpoint JSON:
**Route:** `GET /pesanan/{id}/tracking/status`
**Controller:** `TrackingController@status` → response JSON

---

### C3. Admin: Update Status Tracking
**Route:** `POST /admin/pesanan/{id}/tracking`
**Controller:** `Admin\TrackingController@tambah`
**View:** `resources/views/admin/pesanan/show.blade.php` (section tracking)

Logic:
```php
public function tambah(Request $request, $id_pesanan)
{
    $request->validate([
        'status'     => 'required|string|max:50',
        'keterangan' => 'required|string|max:255',
    ]);

    TrackingStatus::create([
        'id_pesanan'   => $id_pesanan,
        'status'       => $request->status,
        'waktu_update' => now(),
        'keterangan'   => $request->keterangan,
    ]);

    /* Update juga status_pesanan di tabel pesanan */
    $statusMap = [
        'Sedang Diproses'       => 'diproses',
        'Dalam Pengiriman'      => 'dikirim',
        'Pesanan Selesai'       => 'selesai',
        'Pesanan Dibatalkan'    => 'dibatalkan',
    ];

    if (isset($statusMap[$request->status])) {
        Pesanan::find($id_pesanan)->update(['status_pesanan' => $statusMap[$request->status]]);

        /* Kirim notifikasi ke pelanggan */
        $pesanan = Pesanan::find($id_pesanan);
        Notifikasi::create([
            'user_id'     => $pesanan->user_id,
            'judul'       => 'Update Pesanan #' . $id_pesanan,
            'pesan'       => $request->keterangan,
            'waktu_kirim' => now(),
            'status_baca' => 'belum',
        ]);
    }

    return redirect()->back()->with('success', 'Status tracking diperbarui.');
}
```

---

### C4. Sistem Notifikasi — Bell Icon
**Komponen:** Dibuat sebagai Blade component
**File:** `resources/views/components/notifikasi-bell.blade.php`

Cara kerja:
- Di `layouts/app.blade.php` (dikerjakan Anggota A, tapi diisi Anggota C):
```blade
<x-notifikasi-bell :count="$unreadCount" />
```

- Controller mengirim `$unreadCount` ke semua view via `View::share()` atau `AppServiceProvider`:
```php
public function boot(): void
{
    View::composer('*', function ($view) {
        if (Auth::check()) {
            $view->with('unreadCount', Notifikasi::where('user_id', Auth::id())
                ->where('status_baca', 'belum')
                ->count());
        }
    });
}
```

---

### C5. Halaman Semua Notifikasi
**Route:** `GET /notifikasi`
**Controller:** `NotifikasiController@index`
**View:** `resources/views/notifikasi/index.blade.php`

- List semua notifikasi user yang login, terbaru di atas
- Notifikasi belum dibaca → background biru muda (`#E8F9FF`)
- Klik notifikasi → tandai sebagai 'sudah' baca

---

### C6. Tandai Notifikasi Dibaca
**Route:** `POST /notifikasi/{id}/baca`
**Controller:** `NotifikasiController@tandaiBaca`

```php
public function tandaiBaca($id)
{
    Notifikasi::where('id_notifikasi', $id)
        ->where('user_id', Auth::id())
        ->update(['status_baca' => 'sudah']);

    return response()->json(['success' => true]);
}
```

**Route:** `POST /notifikasi/baca-semua`
**Controller:** `NotifikasiController@tandaiBacaSemua`

---

### C7. Admin Dashboard
**Route:** `GET /admin/dashboard`
**Controller:** `Admin\DashboardController@index`
**View:** `resources/views/admin/dashboard/index.blade.php`

Statistik yang ditampilkan (pakai card):
```
┌──────────────┬──────────────┬──────────────┬──────────────┐
│ Total Pesanan│ Revenue Hari │ Produk Aktif │ Pelanggan    │
│     10       │  Rp 750rb    │     23       │     10       │
└──────────────┴──────────────┴──────────────┴──────────────┘
```

Grafik (gunakan Chart.js via CDN):
- Grafik bar: pesanan per hari (7 hari terakhir)
- Grafik pie: distribusi status pesanan (pending, diproses, dll)

Query untuk statistik:
```php
$stats = [
    'total_pesanan'   => Pesanan::count(),
    'revenue_hari_ini'=> Pesanan::whereDate('tanggal_pesan', today())
                            ->where('status_pesanan', '!=', 'dibatalkan')
                            ->sum('total_harga'),
    'produk_aktif'    => Produk::where('status_produk', 'aktif')->count(),
    'total_pelanggan' => User::where('role', 'pelanggan')->count(),
    'pesanan_pending' => Pesanan::where('status_pesanan', 'pending')->count(),
];
```

Tabel "Pesanan Terbaru" di bawah grafik:
- 5 pesanan terbaru dengan nama pelanggan, total, dan status

---

### C8. Admin CRUD Produk
**Routes:**
```
GET    /admin/produk           → index (list semua)
GET    /admin/produk/tambah    → form tambah
POST   /admin/produk           → store
GET    /admin/produk/{id}/edit → form edit
PUT    /admin/produk/{id}      → update
DELETE /admin/produk/{id}      → destroy
```
**Controller:** `Admin\ProdukController`
**Views:** `resources/views/admin/produk/`

Fitur halaman index:
- Tabel: foto thumbnail, nama, kategori, harga, stok, status, aksi
- Filter by kategori (dropdown)
- Filter by status (aktif/nonaktif)
- Search by nama produk
- Tombol "Tambah Produk"

Form tambah/edit:
- Nama produk (required)
- Kategori (select dropdown dari tabel kategori)
- Harga (number, required)
- Stok (number, required)
- Foto (file upload, validasi: image, max 2MB)
- Status (radio: aktif/nonaktif)
- Deskripsi (textarea)

Upload foto:
```php
if ($request->hasFile('foto')) {
    $path = $request->file('foto')->store('produk', 'public');
    $data['foto'] = $path;
}
```

Hapus produk: softdelete atau ubah status ke 'nonaktif' (jangan hard delete jika masih ada di pesanan_item)

---

### C9. Admin CRUD Kategori
**Routes:**
```
GET    /admin/kategori
GET    /admin/kategori/tambah
POST   /admin/kategori
GET    /admin/kategori/{id}/edit
PUT    /admin/kategori/{id}
DELETE /admin/kategori/{id}
```
**Controller:** `Admin\KategoriController`

Halaman index:
- Tabel: nama kategori, deskripsi, jumlah produk, aksi
- Hapus kategori hanya bisa jika tidak ada produk yang menggunakannya:
```php
public function destroy($id)
{
    $kategori = Kategori::withCount('produk')->findOrFail($id);
    if ($kategori->produk_count > 0) {
        return back()->with('error', 'Kategori tidak bisa dihapus karena masih memiliki produk.');
    }
    $kategori->delete();
    return redirect('/admin/kategori')->with('success', 'Kategori dihapus.');
}
```

---

### C10. Admin Manajemen Pelanggan
**Route:** `GET /admin/pelanggan`
**Controller:** `Admin\PelangganController@index`
**View:** `resources/views/admin/pelanggan/index.blade.php`

Tabel pelanggan:
- Nama, email, jumlah pesanan, total belanja, tanggal daftar
- Klik nama → halaman detail dengan riwayat pesanan pelanggan tersebut

Query:
```php
$pelanggan = User::where('role', 'pelanggan')
    ->withCount('pesanan')
    ->withSum(['pesanan' => fn($q) => $q->where('status_pesanan', '!=', 'dibatalkan')], 'total_harga')
    ->paginate(15);
```

---

### C11. Dark Mode Toggle (Opsional)
**Implementasi:** CSS custom properties + localStorage

Di `layouts/app.blade.php` (koordinasi dengan Anggota A):
```html
<button id="darkModeToggle">🌙</button>
```

```javascript
const toggle = document.getElementById('darkModeToggle');
const html   = document.documentElement;

/* Load preferensi tersimpan */
if (localStorage.getItem('darkMode') === 'true') {
    html.classList.add('dark');
    toggle.textContent = '☀️';
}

toggle.addEventListener('click', () => {
    html.classList.toggle('dark');
    const isDark = html.classList.contains('dark');
    localStorage.setItem('darkMode', isDark);
    toggle.textContent = isDark ? '☀️' : '🌙';
});
```

Di CSS, gunakan variabel:
```css
:root {
    --bg-primary:  #FBFBFB;
    --bg-card:     #E8F9FF;
    --accent:      #C4D9FF;
    --highlight:   #C5BAFF;
    --text-main:   #1a1a2e;
}

.dark {
    --bg-primary: #1a1a2e;
    --bg-card:    #16213e;
    --accent:     #0f3460;
    --text-main:  #e8f9ff;
}
```

---

### C12. Model yang Dibuat Anggota C
```bash
php artisan make:model TrackingStatus
php artisan make:model Notifikasi
```

`TrackingStatus.php`:
```php
protected $table      = 'tracking_status';
protected $primaryKey = 'id_tracking';

protected $casts = ['waktu_update' => 'datetime'];

public function pesanan()
{
    return $this->belongsTo(Pesanan::class, 'id_pesanan', 'id_pesanan');
}
```

`Notifikasi.php`:
```php
protected $table      = 'notifikasi';
protected $primaryKey = 'id_notifikasi';

protected $casts = ['waktu_kirim' => 'datetime'];

public function user()
{
    return $this->belongsTo(User::class);
}
```

---

### C13. Routes yang Dibuat Anggota C
```php
/* Tracking (pelanggan) */
Route::middleware('auth')->group(function () {
    Route::get('/pesanan/{id}/tracking', [TrackingController::class, 'show'])->name('tracking.show');
    Route::get('/pesanan/{id}/tracking/status', [TrackingController::class, 'status']);

    /* Notifikasi */
    Route::get('/notifikasi', [NotifikasiController::class, 'index'])->name('notifikasi');
    Route::post('/notifikasi/{id}/baca', [NotifikasiController::class, 'tandaiBaca']);
    Route::post('/notifikasi/baca-semua', [NotifikasiController::class, 'tandaiBacaSemua']);
});

/* Admin Panel */
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [Admin\DashboardController::class, 'index'])->name('dashboard');

    /* CRUD Produk */
    Route::get('/produk', [Admin\ProdukController::class, 'index'])->name('produk.index');
    Route::get('/produk/tambah', [Admin\ProdukController::class, 'create'])->name('produk.create');
    Route::post('/produk', [Admin\ProdukController::class, 'store'])->name('produk.store');
    Route::get('/produk/{id}/edit', [Admin\ProdukController::class, 'edit'])->name('produk.edit');
    Route::put('/produk/{id}', [Admin\ProdukController::class, 'update'])->name('produk.update');
    Route::delete('/produk/{id}', [Admin\ProdukController::class, 'destroy'])->name('produk.destroy');

    /* CRUD Kategori */
    Route::get('/kategori', [Admin\KategoriController::class, 'index'])->name('kategori.index');
    Route::get('/kategori/tambah', [Admin\KategoriController::class, 'create'])->name('kategori.create');
    Route::post('/kategori', [Admin\KategoriController::class, 'store'])->name('kategori.store');
    Route::get('/kategori/{id}/edit', [Admin\KategoriController::class, 'edit'])->name('kategori.edit');
    Route::put('/kategori/{id}', [Admin\KategoriController::class, 'update'])->name('kategori.update');
    Route::delete('/kategori/{id}', [Admin\KategoriController::class, 'destroy'])->name('kategori.destroy');

    /* Pelanggan */
    Route::get('/pelanggan', [Admin\PelangganController::class, 'index'])->name('pelanggan.index');
    Route::get('/pelanggan/{id}', [Admin\PelangganController::class, 'show'])->name('pelanggan.show');

    /* Tracking update */
    Route::post('/pesanan/{id}/tracking', [Admin\TrackingController::class, 'tambah'])->name('pesanan.tracking');
});
```

---

### C14. Checklist Anggota C
- [ ] Halaman tracking menampilkan timeline visual per pesanan
- [ ] Status timeline sesuai dengan data di tabel `tracking_status`
- [ ] Auto-refresh tracking setiap 30 detik
- [ ] Admin dapat menambah entry tracking baru
- [ ] Tambah tracking otomatis update `status_pesanan` di tabel `pesanan`
- [ ] Tambah tracking otomatis kirim notifikasi ke pelanggan
- [ ] Bell icon di navbar menampilkan badge jumlah notif belum dibaca
- [ ] Halaman notifikasi menampilkan semua notif (unread di atas/highlight)
- [ ] Klik notifikasi → tandai sudah dibaca
- [ ] Tombol "Baca Semua" berfungsi
- [ ] Admin dashboard menampilkan 4 statistik card
- [ ] Grafik pesanan per hari tampil (Chart.js)
- [ ] CRUD Produk lengkap termasuk upload foto
- [ ] CRUD Kategori dengan validasi tidak bisa hapus jika ada produk
- [ ] Daftar pelanggan dengan jumlah pesanan dan total belanja
- [ ] Dark mode toggle berfungsi dan tersimpan di localStorage (opsional)
- [ ] View Composer untuk `$unreadCount` berjalan di semua halaman

---

---

## 🤝 KOORDINASI TIM — PENTING

### Titik Koordinasi Wajib

| Hal | Anggota A (buat) | Anggota B (pakai) | Anggota C (pakai) |
|-----|-----------------|------------------|------------------|
| `layouts/app.blade.php` | ✅ Buat | Extend untuk semua view | Tambahkan slot untuk bell notif |
| `layouts/admin.blade.php` | ✅ Buat | Extend admin pesanan | Extend semua admin page |
| Model `Produk` | ✅ Buat | Pakai untuk keranjang & pesanan | Pakai untuk admin CRUD |
| Model `Pesanan` | ❌ | ✅ Buat | Pakai untuk tracking |
| `AppServiceProvider` (View Composer) | ❌ | ❌ | ✅ Anggota C tambahkan |
| Notifikasi (create) | ❌ | ✅ Kirim saat checkout | ✅ Kirim saat update tracking |

### Setup Awal (Semua Harus Jalankan)
```bash
# 1. Pull repo terbaru
git pull origin main

# 2. Install dependencies
composer install

# 3. Setup env
cp .env.example .env
php artisan key:generate

# 4. Set database di .env (MySQL/SQLite sesuai tim)

# 5. Jalankan semua migration
php artisan migrate

# 6. Isi data dummy
php artisan db:seed

# 7. Link storage untuk upload foto
php artisan storage:link

# 8. Jalankan server
php artisan serve --host=0.0.0.0
```

### Akun Login Setelah Seed
| Role | Email | Password |
|------|-------|----------|
| Super Admin | admin@sugarbase.id | admin123 |
| Admin Produk | produk@sugarbase.id | admin123 |
| Pelanggan | rina@gmail.com | pelanggan123 |
| Pelanggan | budi@gmail.com | pelanggan123 |

---

## 📊 RINGKASAN PEMBAGIAN

| | Anggota A | Anggota B | Anggota C |
|---|---|---|---|
| **Halaman Pelanggan** | Login, Register, Beranda, Katalog, Search | Detail Produk, Keranjang, Checkout, Pembayaran, Riwayat Pesanan | Tracking, Notifikasi |
| **Halaman Admin** | — | Daftar Pesanan, Konfirmasi Bayar | Dashboard, CRUD Produk, CRUD Kategori, Pelanggan |
| **Model** | Produk, Kategori | Keranjang, KeranjangItem, Pesanan, PesananItem, Pembayaran | TrackingStatus, Notifikasi |
| **Layout** | app.blade.php, admin.blade.php | — | AppServiceProvider (View Composer) |
| **Migration** | add_role_to_users | — | — |
| **Extra** | Middleware Admin | Logika stok produk | Dark Mode (opsional) |

---

*Happy Coding! 🍰 — SugarBase Team*
