# Database Migration - Sugarbase

## 📊 Status Database

### ✅ Tabel Bisnis (9 tabel)
- **KATEGORI** - Kategori produk
- **PRODUK** - Data produk dengan stok, harga, dan manager (user_id FK)
- **KERANJANG** - Shopping cart pelanggan (user_id FK)
- **KERANJANG_ITEM** - Item di dalam keranjang
- **PESANAN** - Pesanan dari pelanggan (user_id FK)
- **PESANAN_ITEM** - Detail item pesanan
- **PEMBAYARAN** - Transaksi pembayaran
- **TRACKING_STATUS** - Tracking status pengiriman
- **NOTIFIKASI** - Notifikasi sistem (user_id FK)

### ✅ Tabel Laravel Bawaan (4 tabel)
- **users** - Default Laravel users table (menggantikan AKUN/ADMIN/PELANGGAN)
- **migrations** - Track migration history
- **password_reset_tokens** - Password reset tokens
- **sessions** - Session storage

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

✓ Dihapus 3 tabel custom (duplicate Laravel):
- AKUN → diganti users
- ADMIN → diganti users + roles
- PELANGGAN → diganti users

✓ Dikonfigurasi 3 driver ke file-based:
- SESSION_DRIVER=file
- CACHE_STORE=file
- QUEUE_CONNECTION=sync

✓ Hasil: 13 tabel (9 bisnis + 4 Laravel)

---

## 📝 Relasi Tabel

```
AKUN (parent)
├── ADMIN (child)
│   └── PRODUK
│       ├── KERANJANG_ITEM
│       └── PESANAN_ITEM

users (Laravel parent)
├── PRODUK (user_id = manager)
├── KERANJANG (user_id = pembeli)
│   └── KERANJANG_ITEM → PRODUK
├── PESANAN (user_id = pembeli)
│   ├── PESANAN_ITEM → PRODUK
│   ├── PEMBAYARAN
│   └── TRACKING_STATUS
└── NOTIFIKASI (user_id = penerima)

KATEGORI
└── PRODUK
```

---

## ✨ Features

- ✓ Cascade delete untuk relasi
- ✓ Timestamps (created_at, updated_at)
- ✓ Enum fields untuk status
- ✓ Nullable fields untuk opsional data
- ✓ Foreign keys dengan ON DELETE CASCADE/SET NULL
- ✓ Comment untuk dokumentasi kolom
- ✓ 10 Eloquent Models dengan relationships

---

## 💡 Completion Status

1. ✓ Database schema dengan 13 tabel
2. ✓ 2 migrations (users + business tables)
3. ✓ 10 Eloquent Models dengan relationships
4. ✓ 7 Controllers dengan routes
5. ✓ Responsive UI dengan sidebar navigation
6. ✓ Configuration fixed (SESSION/CACHE/QUEUE)
7. ✓ Server accessible via 192.168.2.33:8000


**Database ready! 🎉**
