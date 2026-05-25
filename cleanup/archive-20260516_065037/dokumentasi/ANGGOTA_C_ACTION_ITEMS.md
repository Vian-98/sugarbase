# 📝 TUGAS ANGGOTA C — ACTION ITEMS
**Prioritas:** URGENT (Harus dikerjakan segera)  
**Estimasi:** 2-3 jam untuk completion  
**Deadline:** Hari ini/besok pagi  

---

## 🎯 TASK 1: Tracking System (30 menit)

### Step 1.1: Buat TrackingController
File: `app/Http/Controllers/TrackingController.php`

```php
<?php
namespace App\Http\Controllers;

use App\Models\Pesanan;
use Illuminate\Support\Facades\Auth;

class TrackingController extends Controller
{
    public function show($id)
    {
        $pesanan = Pesanan::with(['tracking' => fn($q) => $q->orderBy('waktu_update', 'asc'), 'items.produk'])
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        return view('tracking.show', compact('pesanan'));
    }

    public function status($id)
    {
        $pesanan = Pesanan::with('tracking')
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        return response()->json($pesanan->tracking);
    }
}
```

### Step 1.2: Buat Admin TrackingController
File: `app/Http/Controllers/Admin/TrackingController.php`

```php
<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use App\Models\TrackingStatus;
use App\Models\Notifikasi;
use Illuminate\Http\Request;

class TrackingController extends Controller
{
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

        $statusMap = [
            'Sedang Diproses'   => 'diproses',
            'Dalam Pengiriman'  => 'dikirim',
            'Pesanan Selesai'   => 'selesai',
            'Pesanan Dibatalkan'=> 'dibatalkan',
        ];

        if (isset($statusMap[$request->status])) {
            Pesanan::find($id_pesanan)->update(['status_pesanan' => $statusMap[$request->status]]);

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
}
```

### Step 1.3: Buat View Tracking
File: `resources/views/tracking/show.blade.php`

```blade
@extends('layouts.app')

@section('title', 'Tracking Pesanan')

@section('content')
<div class="container-fluid py-4">
    <h2 class="fw-bold mb-4">📍 Tracking Pesanan #{{ $pesanan->id_pesanan }}</h2>

    <div class="row">
        <!-- Timeline -->
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <div class="timeline">
                        @php
                            $allStatuses = [
                                'Pesanan Diterima',
                                'Pembayaran Dikonfirmasi',
                                'Sedang Diproses',
                                'Dalam Pengiriman',
                                'Pesanan Selesai',
                            ];
                        @endphp

                        @foreach($allStatuses as $i => $statusName)
                        @php
                            $tracking = $pesanan->tracking()->where('status', $statusName)->first();
                            $completed = !is_null($tracking);
                        @endphp
                        <div class="timeline-item {{ $completed ? 'completed' : '' }}">
                            <div class="timeline-marker">
                                <span class="badge {{ $completed ? 'bg-success' : 'bg-secondary' }}">
                                    {{ $completed ? '✓' : '○' }}
                                </span>
                            </div>
                            <div class="timeline-content">
                                <h5>{{ $statusName }}</h5>
                                @if($tracking)
                                <p class="text-muted">
                                    {{ $tracking->waktu_update->format('d M Y — H:i') }}<br>
                                    {{ $tracking->keterangan }}
                                </p>
                                @else
                                <p class="text-muted">(menunggu)</p>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Summary -->
        <div class="col-lg-4">
            <div class="card bg-light">
                <div class="card-body">
                    <h6 class="fw-bold mb-3">Status Saat Ini</h6>
                    @php
                        $status = $pesanan->status_pesanan;
                        $color = match($status) {
                            'pending' => 'warning',
                            'diproses' => 'info',
                            'dikirim' => 'primary',
                            'selesai' => 'success',
                            'dibatalkan' => 'danger',
                            default => 'secondary'
                        };
                    @endphp
                    <span class="badge bg-{{ $color }} p-2">{{ ucfirst($status) }}</span>
                    
                    <hr>
                    
                    <h6 class="fw-bold mb-2">Detail Pesanan</h6>
                    <small class="d-block">Total: Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</small>
                    <small class="d-block">Tanggal: {{ $pesanan->tanggal_pesan->format('d M Y') }}</small>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-4">
        <a href="/pesanan/saya" class="btn btn-secondary">← Kembali</a>
    </div>
</div>

<style>
    .timeline { position: relative; }
    .timeline-item {
        display: flex;
        margin-bottom: 30px;
        opacity: 0.6;
    }
    .timeline-item.completed { opacity: 1; }
    .timeline-marker { margin-right: 20px; }
    .timeline-content { flex: 1; }
</style>
@endsection
```

### Step 1.4: Tambah Routes
Edit: `routes/web.php` di bagian middleware('auth')

```php
Route::get('/pesanan/{id}/tracking', [TrackingController::class, 'show'])->name('tracking.show');
Route::get('/pesanan/{id}/tracking/status', [TrackingController::class, 'status']);
```

Tambah juga di admin routes:
```php
Route::post('/pesanan/{id}/tracking', [Admin\TrackingController::class, 'tambah'])->name('pesanan.tracking');
```

### Step 1.5: Import di web.php
Tambahkan di bagian imports:
```php
use App\Http\Controllers\TrackingController;
```

---

## 🎯 TASK 2: Admin CRUD Produk (20 menit)

### Step 2.1: Buat ProdukController lengkap
Edit: `app/Http/Controllers/ProdukController.php`

```php
<?php
namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Kategori;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    public function index()
    {
        $produk = Produk::with('kategori')->paginate(15);
        return view('admin.produk.index', compact('produk'));
    }

    public function create()
    {
        $kategori = Kategori::all();
        return view('admin.produk.create', compact('kategori'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_produk' => 'required|string|max:100',
            'id_kategori' => 'required|exists:kategori,id_kategori',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'status_produk' => 'required|in:aktif,nonaktif',
            'deskripsi_produk' => 'nullable|string|max:255',
        ]);

        $path = $request->file('foto')->store('produk', 'public');

        Produk::create([
            'nama_produk' => $request->nama_produk,
            'id_kategori' => $request->id_kategori,
            'harga' => $request->harga,
            'stok' => $request->stok,
            'foto' => $path,
            'status_produk' => $request->status_produk,
            'deskripsi_produk' => $request->deskripsi_produk,
        ]);

        return redirect('/admin/produk')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $produk = Produk::findOrFail($id);
        $kategori = Kategori::all();
        return view('admin.produk.edit', compact('produk', 'kategori'));
    }

    public function update(Request $request, $id)
    {
        $produk = Produk::findOrFail($id);

        $request->validate([
            'nama_produk' => 'required|string|max:100',
            'id_kategori' => 'required|exists:kategori,id_kategori',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'status_produk' => 'required|in:aktif,nonaktif',
        ]);

        $data = $request->only(['nama_produk', 'id_kategori', 'harga', 'stok', 'status_produk', 'deskripsi_produk']);

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('produk', 'public');
        }

        $produk->update($data);

        return redirect('/admin/produk')->with('success', 'Produk berhasil diupdate.');
    }

    public function destroy($id)
    {
        Produk::findOrFail($id)->delete();
        return back()->with('success', 'Produk berhasil dihapus.');
    }

    public function show($id)
    {
        $produk = Produk::with('kategori')->findOrFail($id);
        return view('produk.show', compact('produk'));
    }
}
```

### Step 2.2: Buat Views Produk CRUD
Buat: `resources/views/admin/produk/create.blade.php`

```blade
@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">
    <h2 class="fw-bold mb-4">➕ Tambah Produk</h2>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="/admin/produk" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Nama Produk</label>
                    <input type="text" name="nama_produk" class="form-control @error('nama_produk') is-invalid @enderror" required>
                    @error('nama_produk') <span class="invalid-feedback">{{ $message }}</span> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Kategori</label>
                    <select name="id_kategori" class="form-select @error('id_kategori') is-invalid @enderror" required>
                        <option value="">Pilih Kategori</option>
                        @foreach($kategori as $k)
                        <option value="{{ $k->id_kategori }}">{{ $k->nama_kategori }}</option>
                        @endforeach
                    </select>
                    @error('id_kategori') <span class="invalid-feedback">{{ $message }}</span> @enderror
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Harga</label>
                            <input type="number" name="harga" class="form-control @error('harga') is-invalid @enderror" min="0" required>
                            @error('harga') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Stok</label>
                            <input type="number" name="stok" class="form-control @error('stok') is-invalid @enderror" min="0" required>
                            @error('stok') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Foto</label>
                    <input type="file" name="foto" class="form-control @error('foto') is-invalid @enderror" accept="image/*" required>
                    @error('foto') <span class="invalid-feedback">{{ $message }}</span> @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="status_produk" value="aktif" checked>
                            <label class="form-check-label">Aktif</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="status_produk" value="nonaktif">
                            <label class="form-check-label">Nonaktif</label>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Deskripsi (opsional)</label>
                    <textarea name="deskripsi_produk" class="form-control" rows="3" max="255"></textarea>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">💾 Simpan</button>
                    <a href="/admin/produk" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
```

Edit file yang ada: `resources/views/admin/produk/edit.blade.php` (similar ke create tapi dengan update action)

### Step 2.3: Update Routes di web.php
Pastikan routes ini ada dalam admin group:

```php
Route::get('/produk', [ProdukController::class, 'index'])->name('produk.index');
Route::get('/produk/tambah', [ProdukController::class, 'create'])->name('produk.create');
Route::post('/produk', [ProdukController::class, 'store'])->name('produk.store');
Route::get('/produk/{id}/edit', [ProdukController::class, 'edit'])->name('produk.edit');
Route::put('/produk/{id}', [ProdukController::class, 'update'])->name('produk.update');
Route::delete('/produk/{id}', [ProdukController::class, 'destroy'])->name('produk.destroy');
```

---

## 🎯 TASK 3: Admin CRUD Kategori (15 menit)

### Step 3.1: KategoriController
Buat/Edit: `app/Http/Controllers/KategoriController.php`

```php
<?php
namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Produk;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index()
    {
        $kategori = Kategori::withCount('produk')->paginate(15);
        return view('admin.kategori.index', compact('kategori'));
    }

    public function create()
    {
        return view('admin.kategori.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:100|unique:kategori',
            'deskripsi_kategori' => 'nullable|string|max:255',
        ]);

        Kategori::create($request->only(['nama_kategori', 'deskripsi_kategori']));

        return redirect('/admin/kategori')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $kategori = Kategori::findOrFail($id);
        return view('admin.kategori.edit', compact('kategori'));
    }

    public function update(Request $request, $id)
    {
        $kategori = Kategori::findOrFail($id);

        $request->validate([
            'nama_kategori' => 'required|string|max:100|unique:kategori,nama_kategori,' . $id . ',id_kategori',
            'deskripsi_kategori' => 'nullable|string|max:255',
        ]);

        $kategori->update($request->only(['nama_kategori', 'deskripsi_kategori']));

        return redirect('/admin/kategori')->with('success', 'Kategori berhasil diupdate.');
    }

    public function destroy($id)
    {
        $kategori = Kategori::withCount('produk')->findOrFail($id);

        if ($kategori->produk_count > 0) {
            return back()->with('error', 'Kategori tidak bisa dihapus karena masih memiliki produk.');
        }

        $kategori->delete();

        return back()->with('success', 'Kategori berhasil dihapus.');
    }
}
```

### Step 3.2: Kategori Routes
Tambah ke admin group di web.php:

```php
Route::get('/kategori', [KategoriController::class, 'index'])->name('kategori.index');
Route::get('/kategori/tambah', [KategoriController::class, 'create'])->name('kategori.create');
Route::post('/kategori', [KategoriController::class, 'store'])->name('kategori.store');
Route::get('/kategori/{id}/edit', [KategoriController::class, 'edit'])->name('kategori.edit');
Route::put('/kategori/{id}', [KategoriController::class, 'update'])->name('kategori.update');
Route::delete('/kategori/{id}', [KategoriController::class, 'destroy'])->name('kategori.destroy');
```

---

## 📋 CHECKLIST

### Done ✅
- [x] Database & migrations
- [x] Auth & layouts
- [x] Katalog & search
- [x] Cart & checkout  
- [x] Payment integration
- [x] Notifikasi system
- [x] Pelanggan management

### TODO (Urgent) ⏳
- [ ] Task 1: Tracking system (30 min)
- [ ] Task 2: Admin CRUD Produk (20 min)
- [ ] Task 3: Admin CRUD Kategori (15 min)
- [ ] Task 4: Dashboard stats (20 min - in PEMBAGIAN_TIM.md C7)

### OPTIONAL 🔵
- [ ] Dark mode (15 min - in PEMBAGIAN_TIM.md C11)

---

**Next Step:** Implementasikan Task 1, 2, 3 sesuai urutan di atas. Setelah itu, project siap untuk production!
