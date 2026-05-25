# 🔐 TEST ACCOUNTS — SugarBase

## ✅ Akun Sudah Tersedia di Database

Berikut daftar semua test account yang sudah di-seed di database:

---

## 👨‍💼 ADMIN ACCOUNTS (3 akun)

| No | Nama | Email | Password | Role |
|----|------|-------|----------|------|
| 1 | Super Admin | `admin@sugarbase.id` | `admin123` | admin |
| 2 | Admin Produk | `produk@sugarbase.id` | `produk123` | admin |
| 3 | Admin Pesanan | `pesanan@sugarbase.id` | `pesanan123` | admin |

**Redirect setelah login:** → `/admin/dashboard`

---

## 👤 CUSTOMER ACCOUNTS (10 akun)

| No | Nama | Email | Password | Role |
|----|------|-------|----------|------|
| 1 | Rina Amelia | `rina@gmail.com` | `pelanggan123` | pelanggan |
| 2 | Budi Santoso | `budi@gmail.com` | `pelanggan123` | pelanggan |
| 3 | Citra Dewi | `citra@gmail.com` | `pelanggan123` | pelanggan |
| 4 | Dani Pratama | `dani@gmail.com` | `pelanggan123` | pelanggan |
| 5 | Eka Putri | `eka@gmail.com` | `pelanggan123` | pelanggan |
| 6 | Fajar Nugroho | `fajar@gmail.com` | `pelanggan123` | pelanggan |
| 7 | Gita Maharani | `gita@gmail.com` | `pelanggan123` | pelanggan |
| 8 | Hendra Wijaya | `hendra@gmail.com` | `pelanggan123` | pelanggan |
| 9 | Indah Lestari | `indah@gmail.com` | `pelanggan123` | pelanggan |
| 10 | Joko Susilo | `joko@gmail.com` | `pelanggan123` | pelanggan |

**Redirect setelah login:** → `/beranda`

---

## 🧪 TEST SCENARIOS

### Test Admin Login
```
Email:    admin@sugarbase.id
Password: admin123
Expected: Redirect ke /admin/dashboard
```

### Test Customer Login
```
Email:    budi@gmail.com
Password: pelanggan123
Expected: Redirect ke /beranda
```

---

## 🔗 URL Login

```
http://127.0.0.1:8000/login
```

---

## ⚙️ Jika Login Masih Gagal

### 1. Check Database Connection
```bash
php artisan migrate:fresh --seed
```

### 2. Check Vite Assets
```bash
npm run build
```

### 3. Clear Cache
```bash
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

### 4. Restart Server
```bash
php artisan serve --host=0.0.0.0
```

---

## 📝 Notes

- Semua password sudah di-hash di database (BCrypt)
- Email tidak case-sensitive di login form
- Password paling aman adalah `admin123` untuk admin dan `pelanggan123` untuk customer
- Dapat membuat akun baru via `/register` → otomatis role `pelanggan`

---

**Last Updated:** 26 April 2026  
**Status:** ✅ All accounts ready to use
