# 🔴 AUDIT LAPORAN — CRITICAL BUGS & ISSUES

**Tanggal:** 16 Mei 2026  
**Status:** ⚠️ 8 BUGS TERIDENTIFIKASI (3 CRITICAL, 2 MEDIUM, 3 LOW)

---

## 🔴 BUG 1: KeranjangItem Primary Key Mismatch [CRITICAL]

**File:** [app/Models/KeranjangItem.php](app/Models/KeranjangItem.php)

### Masalah:
```php
protected $primaryKey = 'id_item';  // ❌ SALAH
protected $table = 'keranjang_item';
```

Model mendeklarasikan `id_item` sebagai primary key, tetapi:
- Database migration membuat kolom `id_keranjang_item`
- Kolom `id_item` **TIDAK PERNAH DIBUAT** di tabel
- `KeranjangController::hapus()` dan `update()` memanggil `KeranjangItem::findOrFail($id)` → **500 ERROR**

### Dampak:
- ❌ Customer TIDAK BISA menghapus item dari keranjang
- ❌ Customer TIDAK BISA mengupdate jumlah item
- ❌ Fitur keranjang RUSAK

### Perbaikan:
```php
protected $primaryKey = 'id_keranjang_item';  // ✅ BENAR
```

---

## 🔴 BUG 2: Pelanggan Pembayaran Konfirmasi Route Missing [CRITICAL]

**File:** [resources/views/pembayaran/show.blade.php](resources/views/pembayaran/show.blade.php), [routes/web.php](routes/web.php)

### Masalah:
1. **View** post ke endpoint:
   ```blade
   <form action="/pembayaran/{id}/konfirmasi" method="POST">
   ```

2. **Routes** hanya punya admin route:
   ```php
   Route::post('/pembayaran/{id}/konfirmasi', [Admin\PembayaranController::class, 'konfirmasi']);  // ✅ Ada (admin)
   ```

3. **TIDAK ADA** route untuk pelanggan:
   ```php
   // ❌ Route berikut HILANG untuk non-admin:
   Route::post('/pembayaran/{id}/konfirmasi', [PembayaranController::class, 'konfirmasiPelanggan']);
   ```

### Dampak:
- ❌ Customer click "Konfirmasi Pembayaran" → 404 ERROR
- ❌ Customer tidak bisa konfirmasi pembayaran manual
- ❌ Fitur pembayaran tidak lengkap

### Perbaikan:
Tambah route di `routes/web.php` dalam middleware `auth`:
```php
Route::post('/pembayaran/{id}/konfirmasi', [PembayaranController::class, 'konfirmasiPelanggan']);
```

---

## 🔴 BUG 3: $totalPerStatus Undefined Variable [CRITICAL]

**File:** [resources/views/pesanan/saya.blade.php](resources/views/pesanan/saya.blade.php), [app/Http/Controllers/PesananController.php](app/Http/Controllers/PesananController.php)

### Masalah:
**View** menggunakan variable:
```blade
@if(isset($totalPerStatus[$key]))
    <span>{{ $totalPerStatus[$key] }}</span>
@endif
```

**Controller** TIDAK PERNAH PASS variable ini:
```php
public function milikSaya(Request $request)
{
    $pesanan = Pesanan::with('pembayaran')->where('user_id', Auth::id())->latest()->get();
    return view('pesanan.saya', compact('pesanan'));
    // ❌ $totalPerStatus TIDAK DIKIRIM!
}
```

### Dampak:
- ⚠️ Tidak fatal, tapi logic filter status count tidak berfungsi
- View akan selalu `!isset($totalPerStatus)`, badge status count tidak tampil

### Perbaikan:
Hitung total per status di controller:
```php
public function milikSaya(Request $request)
{
    $query = Pesanan::with('pembayaran', 'items.produk')
        ->where('user_id', Auth::id())
        ->latest();

    if ($request->status && $request->status !== 'semua') {
        $query->where('status_pesanan', $request->status);
    }

    $pesanan = $query->get();
    
    // ✅ Hitung total per status
    $totalPerStatus = [
        'semua' => Pesanan::where('user_id', Auth::id())->count(),
        'pending' => Pesanan::where('user_id', Auth::id())->where('status_pesanan', 'pending')->count(),
        'diproses' => Pesanan::where('user_id', Auth::id())->where('status_pesanan', 'diproses')->count(),
        'dikirim' => Pesanan::where('user_id', Auth::id())->where('status_pesanan', 'dikirim')->count(),
        'selesai' => Pesanan::where('user_id', Auth::id())->where('status_pesanan', 'selesai')->count(),
        'dibatalkan' => Pesanan::where('user_id', Auth::id())->where('status_pesanan', 'dibatalkan')->count(),
    ];

    return view('pesanan.saya', compact('pesanan', 'totalPerStatus'));
}
```

---

## 🟡 BUG 4: Pesanan Items Not Eager Loaded [MEDIUM]

**File:** [app/Http/Controllers/PesananController.php](app/Http/Controllers/PesananController.php), [resources/views/pesanan/saya.blade.php](resources/views/pesanan/saya.blade.php)

### Masalah:
```php
public function milikSaya(Request $request)
{
    // ❌ MISSING: items.produk
    $pesanan = Pesanan::with('pembayaran')  // Items tidak di-load!
        ->where('user_id', Auth::id())
        ->latest()
        ->get();
}
```

**View** mengakses:
```blade
@foreach($item->items as $pi)  // N+1 QUERY! Setiap pesanan trigger query items
    {{ $pi->produk->nama_produk }}
@endforeach
```

### Dampak:
- ⚠️ N+1 Query Problem: Jika user punya 10 pesanan → 1 + 10 + 10 = 21 queries!
- 🐢 Performance lambat untuk user dengan banyak pesanan

### Perbaikan:
```php
$pesanan = Pesanan::with('pembayaran', 'items.produk')  // ✅ Eager load
    ->where('user_id', Auth::id())
    ->latest()
    ->get();
```

---

## 🟡 BUG 5: Migration Conflict - Duplicate Pesanan Tables [MEDIUM]

**File:** [database/migrations/2026_04_25_000003_create_sugarbase_tables.php](database/migrations/2026_04_25_000003_create_sugarbase_tables.php), [database/migrations/2026_04_30_153032_create_pesanan_table.php](database/migrations/2026_04_30_153032_create_pesanan_table.php)

### Masalah:
**Migration 1** (2026_04_25) membuat:
```php
Schema::create('pesanan', ...);      // Nama: pesanan (tanpa 's')
Schema::create('pesanan_item', ...);
```

**Migration 2** (2026_04_30) drop dan recreate dengan nama BERBEDA:
```php
Schema::dropIfExists('pesanan_item');
Schema::dropIfExists('pesanans');    // ❌ Mencari pesanans, bukan pesanan!

Schema::create('pesanans', function(...) { // ❌ Nama: pesanans (ada 's')
```

### Dampak:
- ⚠️ Inconsistency: Tabel sebenarnya bernama `pesanan`, tapi migration create `pesanans`
- Tabel `pesanan_item` kembali diciptakan (redundant)
- Potensi error jika foreign key mismatch

### Perbaikan:
Hapus migration kedua atau konsistensikan nama tabel. **Nama tabel yang BENAR**: `pesanan` (dari migration pertama):
```php
// Di 2026_04_30_153032, ubah:
Schema::create('pesanans', ...);  // ❌
// Menjadi:
Schema::create('pesanan', ...);   // ✅
```

---

## 🟢 BUG 6: NotifikasiController Missing User Filter [LOW]

**File:** [app/Http/Controllers/NotifikasiController.php](app/Http/Controllers/NotifikasiController.php)

### Masalah:
```php
public function index()
{
    // ❌ Menampilkan SEMUA notifikasi di database, bukan user-specific!
    $notifikasi = Notifikasi::orderByRaw(...)
        ->orderBy('waktu_kirim', 'desc')
        ->get();  // Tidak ada WHERE clause!
}
```

### Dampak:
- 🔒 **SECURITY**: User bisa melihat notifikasi user lain
- 💥 Jika ada 1000+ notifikasi global → halaman loading slow

### Perbaikan:
```php
public function index()
{
    $notifikasi = Notifikasi::where('user_id', Auth::id())  // ✅ Filter user
        ->orderByRaw("CASE WHEN status_baca = 'belum' THEN 0 ELSE 1 END")
        ->orderBy('waktu_kirim', 'desc')
        ->get();
}
```

---

## 🟢 BUG 7: User Model Missing no_telepon & alamat Columns [LOW]

**File:** [app/Models/User.php](app/Models/User.php), [resources/views/pelanggan/show.blade.php](resources/views/pelanggan/show.blade.php)

### Masalah:
**Migration** tidak pernah menambah kolom:
```php
// ❌ Database migration tidak ada:
// $table->string('no_telepon');
// $table->text('alamat');
```

**View** mengakses kolom yang tidak ada:
```blade
{{ $p->no_telepon ?? '-' }}  // Selalu '-'
{{ $p->alamat ?? '-' }}      // Selalu '-'
```

### Dampak:
- 📍 Address & phone number functionality tidak tersedia
- Checkout form tidak bisa save delivery info

### Perbaikan:
Buat migration untuk menambah kolom:
```bash
php artisan make:migration add_contact_info_to_users_table
```

```php
public function up(): void
{
    Schema::table('users', function (Blueprint $table) {
        $table->string('no_telepon')->nullable();
        $table->text('alamat')->nullable();
    });
}

public function down(): void
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn(['no_telepon', 'alamat']);
    });
}
```

Run: `php artisan migrate`

---

## 🟢 BUG 8: Admin\TrackingController Not Routed [LOW]

**File:** [app/Http/Controllers/Admin/TrackingController.php](app/Http/Controllers/Admin/TrackingController.php), [routes/web.php](routes/web.php)

### Masalah:
**Controller** punya method `tambah()`:
```php
class TrackingController extends Controller {
    public function tambah(Request $request, $id_pesanan) { ... }
}
```

**Tapi TIDAK ADA route** untuk `Admin\TrackingController`:
```php
// routes/web.php - Admin routes TIDAK punya:
// Route::post('/pesanan/{id}/tracking', [Admin\TrackingController::class, 'tambah']);
```

**Sebaliknya**, logic duplicate di `Admin\PesananController::addTracking()`:
```php
class PesananController extends Controller {
    public function addTracking(...) { ... }  // ✅ Ini yang dipakai
}
```

### Dampak:
- 🔀 Duplicate logic di 2 controller
- 📁 `Admin\TrackingController` unused/orphaned
- Maintenance sulit jika ada bug di tracking logic

### Perbaikan:
**Opsi 1:** Hapus `Admin\TrackingController.php` (karena logic sudah di `Admin\PesananController`)

**Opsi 2:** Gunakan `Admin\TrackingController` dan pindahkan logic:
```php
// Di routes/web.php (admin group):
Route::post('/pesanan/{id}/tracking', [Admin\TrackingController::class, 'tambah']);

// Di Admin\PesananController, gunakan:
// Pesanan::with(...)->findOrFail($id); // hanya query
// kemudian redirect ke tracking form
```

---

## 📊 SUMMARY TABEL

| # | Judul Bug | Severity | Status | Impact | Fix Difficulty |
|---|-----------|----------|--------|--------|-----------------|
| 1 | KeranjangItem Primary Key | 🔴 CRITICAL | Active | Cart 100% broken | Easy |
| 2 | Payment Confirmation Route | 🔴 CRITICAL | Active | Payment 0% works | Easy |
| 3 | totalPerStatus Undefined | 🔴 CRITICAL | Active | UI cosmetic | Medium |
| 4 | Items Not Eager Loaded | 🟡 MEDIUM | Active | Performance N+1 | Easy |
| 5 | Migration Conflict | 🟡 MEDIUM | Active | DB inconsistency | Medium |
| 6 | Notifikasi Security | 🟢 LOW | Active | Privacy leak | Easy |
| 7 | Missing User Columns | 🟢 LOW | Blocked | Features incomplete | Medium |
| 8 | TrackingController Orphaned | 🟢 LOW | Active | Code maintenance | Easy |

---

## 🎯 PRIORITAS PERBAIKAN

### Fase 1: CRITICAL (Harus diperbaiki hari ini)
1. ✅ Fix BUG 1: KeranjangItem Primary Key (`id_item` → `id_keranjang_item`)
2. ✅ Fix BUG 2: Tambah payment confirmation route untuk pelanggan
3. ✅ Fix BUG 3: Hitung `$totalPerStatus` di controller

### Fase 2: MEDIUM (Harus diperbaiki minggu ini)
4. ✅ Fix BUG 4: Eager load `items.produk` di `milikSaya()`
5. ✅ Fix BUG 5: Konsistensikan nama tabel migration

### Fase 3: LOW (Bisa diperbaiki nanti)
6. ✅ Fix BUG 6: Filter notifikasi by user
7. ✅ Fix BUG 7: Tambah user columns (no_telepon, alamat)
8. ✅ Fix BUG 8: Hapus atau route orphaned TrackingController

---

**Status Laporan:** FINAL  
**Recommended Action:** Start dengan Phase 1 immediately
