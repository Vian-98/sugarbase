# Database Migration - Sugarbase

## 📊 Status Database

### ✅ Tabel Utama (12 tabel)
- **AKUN** - Master data akun pengguna
- **ADMIN** - Data admin dengan level akses
- **PELANGGAN** - Data pelanggan reguler/premium
- **KATEGORI** - Kategori produk
- **PRODUK** - Data produk dengan stok dan harga
- **KERANJANG** - Shopping cart pelanggan
- **KERANJANG_ITEM** - Item di dalam keranjang
- **PESANAN** - Pesanan dari pelanggan
- **PESANAN_ITEM** - Detail item pesanan
- **PEMBAYARAN** - Transaksi pembayaran
- **TRACKING_STATUS** - Tracking status pengiriman
- **NOTIFIKASI** - Notifikasi sistem

### ✅ Tabel Laravel (2 tabel)
- **migrations** - Track migration history
- **users** - Default Laravel users table

---

## 🔧 Migration File

**File:** `database/migrations/2026_04_25_000003_create_sugarbase_tables.php`

Satu file migration komprehensif yang mencakup:
- Semua 12 tabel utama dari project EBIS
- Foreign key relationships
- Enum fields untuk status
- Default values
- Timestamps untuk created_at dan updated_at

---

## 🚀 Cara Menggunakan

### Fresh Install
```bash
php artisan migrate
```

### Reset Database
```bash
php artisan migrate:refresh
```

### Rollback
```bash
php artisan migrate:rollback
```

### Rollback Semua
```bash
php artisan migrate:reset
```

---

## 🗑️ Cleanup Done

✓ Dihapus 7 tabel yang tidak perlu:
- cache
- cache_locks
- failed_jobs
- job_batches
- jobs
- password_reset_tokens
- sessions

✓ Dihapus 2 migration yang tidak perlu:
- 0001_01_01_000001_create_cache_table.php
- 0001_01_01_000002_create_jobs_table.php

✓ Dihapus file SQL helper:
- sugarbase.sql
- proyekebis.sql
- check_db.php
- cleanup_db.php
- drop_all_tables.php

---

## 📝 Relasi Tabel

```
AKUN (parent)
├── ADMIN (child)
│   └── PRODUK
│       ├── KERANJANG_ITEM
│       └── PESANAN_ITEM
└── PELANGGAN (child)
    ├── KERANJANG
    │   └── KERANJANG_ITEM
    └── PESANAN
        ├── PESANAN_ITEM
        ├── PEMBAYARAN
        └── TRACKING_STATUS

KATEGORI
└── PRODUK

NOTIFIKASI
└── AKUN
```

---

## ✨ Features

- ✓ Cascade delete untuk relasi
- ✓ Soft delete ready (dapat ditambah dengan SoftDeletes)
- ✓ Timestamps (created_at, updated_at)
- ✓ Enum fields untuk status
- ✓ Nullable fields untuk opsional data
- ✓ Unique constraint untuk email
- ✓ Comment untuk dokumentasi kolom

---

## 💡 Next Steps

1. Buat Models untuk setiap tabel
2. Setup relationships di Model
3. Buat Controllers dengan logic bisnis
4. Test setiap endpoint

**Database ready! 🎉**
