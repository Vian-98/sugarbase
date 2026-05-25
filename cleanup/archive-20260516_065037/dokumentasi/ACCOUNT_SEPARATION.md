# 👥 PEMBAGIAN AKUN: ADMIN VS PELANGGAN

## 🔑 SISTEM PEMBAGIAN

Setiap user di SugarBase memiliki **role** yang menentukan tampilan dan akses:

```
┌─────────────────────────────────────────────────────────┐
│                  DATABASE (users table)                 │
│  ┌─────┬─────────┬────────────┬──────────────────────┐ │
│  │ id  │ name    │ email      │ role                 │ │
│  ├─────┼─────────┼────────────┼──────────────────────┤ │
│  │ 1   │ Admin   │ admin@...  │ 'admin'     ← Redirect /admin/dashboard
│  │ 2   │ Budi    │ budi@...   │ 'pelanggan' ← Redirect /beranda
│  │ 3   │ Siti    │ siti@...   │ 'pelanggan' ← Redirect /beranda
│  └─────┴─────────┴────────────┴──────────────────────┘ │
└─────────────────────────────────────────────────────────┘

AuthController login() method:
if (Auth::attempt(...)) {
    $user = Auth::user();
    return redirect($user->role === 'admin' 
        ? '/admin/dashboard'  ← Admin ke sini
        : '/beranda'          ← Pelanggan ke sini
    );
}
```

---

## 📱 LAYOUT PERBANDINGAN

### **AKUN PELANGGAN (Customer)** 👤

```
┌────────────────────────────────────────────────────────┐
│ NAVBAR (sticky top)                                    │
│ 🍰 SugarBase │ [Search Bar] │ 🔔 🛒 [Avatar ▼]     │
├────────────────────────────────────────────────────────┤
│                                                        │
│                   MAIN CONTENT                        │
│                  @yield('content')                    │
│                                                        │
│  Hero banner, kategori, produk, dll                  │
│                                                        │
├────────────────────────────────────────────────────────┤
│ BOTTOM NAV (mobile only, < 768px)                     │
│ 🏠 🍰 🛒 📦 👤  (5 menu items)                        │
└────────────────────────────────────────────────────────┘

File: resources/views/layouts/app.blade.php
Route: /beranda, /katalog, /produk/{id}
Features:
  ✓ Search bar
  ✓ Notifications bell
  ✓ Cart with badge
  ✓ Avatar dropdown (Profil, Riwayat, Logout)
  ✓ Bottom navigation mobile
```

---

### **AKUN ADMIN** 👨‍💼

```
┌──────────────┬────────────────────────────────────────┐
│              │ HEADER (sticky top)                    │
│ SIDEBAR      │ [Breadcrumb] [Admin Name] [Avatar]    │
│ (fixed       ├────────────────────────────────────────┤
│  250px)      │                                        │
│              │        MAIN CONTENT                    │
│ 🍰 SugarBase │       @yield('content')               │
│ ─────────    │                                        │
│ 📊 Dashboard │  Dashboard stats, tables, forms       │
│ 📦 Produk    │                                        │
│ 📂 Kategori  │                                        │
│ 🛒 Pesanan   │                                        │
│ 👥 Pelanggan │                                        │
│ 💳 Pembayaran│                                        │
│ ─────────    │                                        │
│ 🚪 Logout    │                                        │
└──────────────┴────────────────────────────────────────┘

File: resources/views/layouts/admin.blade.php
Route: /admin/dashboard, /admin/produk, etc
Features:
  ✓ Fixed sidebar (left)
  ✓ Active link indicator
  ✓ Header with breadcrumb
  ✓ Admin info display
  ✓ Grid layout system
```

---

## 🎨 VISUAL LAYOUT PERBANDINGAN

### **DESKTOP VIEW**

**← PELANGGAN (Customer)**
```
┌────────────────────────────────────────────┐
│ NAVBAR dengan search bar                   │ ← Sticky top
├────────────────────────────────────────────┤
│                                            │
│           CONTENT AREA                    │
│  (Hero + Kategori + Produk)               │ ← Main area
│                                            │
│                                            │
└────────────────────────────────────────────┘
```

**ADMIN (Management) →**
```
┌──────────┬──────────────────────────────┐
│ SIDEBAR  │ HEADER (breadcrumb)          │ ← Sticky
│  250px   ├──────────────────────────────┤
│          │                              │
│ Menu     │     CONTENT AREA             │ ← Main area
│ Items    │   (Dashboard/Tables/Forms)  │
│          │                              │
│          │                              │
│ Logout   │                              │
└──────────┴──────────────────────────────┘
```

---

### **MOBILE VIEW (< 768px)**

**← PELANGGAN**
```
┌──────────────────────┐
│ NAVBAR + Search      │ ← Sticky top
├──────────────────────┤
│                      │
│   CONTENT AREA       │ ← Full width
│  (Hero + Kategori)   │
│                      │
├──────────────────────┤
│ 🏠 🍰 🛒 📦 👤      │ ← Fixed bottom nav
└──────────────────────┘
```

**ADMIN →**
```
┌──────────────────────┐
│ HEADER + Breadcrumb  │ ← Sticky
├──────────────────────┤
│                      │
│   CONTENT AREA       │ ← Full width
│  (Dashboard/Tables)  │
│                      │
│ (Sidebar collapse)   │
└──────────────────────┘
```

---

## 🔐 PERBEDAAN AKSES

| Feature | Pelanggan | Admin |
|---------|-----------|-------|
| Login page | ✅ | ✅ |
| Register page | ✅ | ❌ |
| Beranda | ✅ | ❌ |
| Katalog | ✅ | ❌ |
| Keranjang | ✅ | ❌ |
| Admin Dashboard | ❌ | ✅ |
| Produk management | ❌ | ✅ |
| Kategori management | ❌ | ✅ |
| Pesanan management | ❌ | ✅ |
| Pelanggan list | ❌ | ✅ |
| Pembayaran report | ❌ | ✅ |

---

## 🛡️ MIDDLEWARE PROTECTION

**AdminMiddleware (auth/admin middleware):**
```php
// Proteksi semua route dengan prefix /admin/

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', ...);    // Hanya admin yang bisa akses
    Route::get('/produk', ...);       // Hanya admin yang bisa akses
    Route::get('/kategori', ...);     // Hanya admin yang bisa akses
    // dll
});

// Jika pelanggan coba akses /admin/dashboard:
// → Redirect ke /login dengan error message
```

**Customer routes (hanya auth):**
```php
Route::middleware('auth')->group(function () {
    Route::get('/beranda', ...);      // Semua user login bisa akses
    Route::get('/katalog', ...);      // Pelanggan dan admin bisa lihat
    // dll
});
```

---

## 📊 FLOW AUTHENTICATION

```
User di login page
        ↓
[Email] [Password] → Submit
        ↓
     Database
    Check user
        ↓
    Role check?
   /        \
  /          \
admin      pelanggan
  │            │
  └─→ /admin/dashboard
       (AdminMiddleware check)
       
  └─→ /beranda
      (No special middleware)
```

---

## 🎯 REDIRECT LOGIC

**Setelah login berhasil (AuthController@login):**

```php
if (Auth::attempt($request->only('email', 'password'))) {
    $request->session()->regenerate();
    
    $user = Auth::user();
    
    // Role-based redirect
    if ($user->role === 'admin') {
        return redirect('/admin/dashboard');  // ← Admin
    } else {
        return redirect('/beranda');           // ← Pelanggan
    }
}
```

---

## 📁 FILE YANG BERBEDA

### **Untuk Pelanggan:**
```
resources/views/layouts/app.blade.php
resources/views/beranda/index.blade.php
resources/views/katalog/index.blade.php
resources/views/produk/show.blade.php
resources/views/auth/login.blade.php
resources/views/auth/register.blade.php
```

### **Untuk Admin:**
```
resources/views/layouts/admin.blade.php
resources/views/admin/dashboard.blade.php
resources/views/admin/produk/index.blade.php
resources/views/admin/kategori/index.blade.php
resources/views/admin/pesanan/index.blade.php
resources/views/admin/pelanggan/index.blade.php
resources/views/admin/pembayaran/index.blade.php
```

---

## 🎨 WARNA & STYLING

**Pelanggan (app.blade.php):**
- Primary color: #667eea (purple)
- Secondary: #764ba2 (dark purple)
- Background: #fbfbfb (light)
- Card: #e8f9ff (very light blue)
- Border: #c4d9ff (light purple-blue)

**Admin (admin.blade.php):**
- Sidebar gradient: #667eea → #764ba2 (purple to dark purple)
- Header: White
- Icons: Emoji-based

---

## 💡 CONTOH AKUN TEST

**Admin:**
```
Email: admin@sugarbase.id
Password: admin123
Role: admin
Login → /admin/dashboard
```

**Pelanggan:**
```
Email: budi@gmail.com
Password: pelanggan123
Role: pelanggan
Login → /beranda
```

---

## ✨ SUMMARY

| Aspek | Pelanggan | Admin |
|-------|-----------|-------|
| **Layout** | Navbar top + Bottom nav | Sidebar + Header |
| **Role** | 'pelanggan' | 'admin' |
| **After Login** | Redirect /beranda | Redirect /admin/dashboard |
| **Features** | Browse, Search, Cart | Manage, Report, Settings |
| **Protection** | Only 'auth' middleware | 'auth' + 'admin' middleware |
| **Sidebar** | ❌ No | ✅ Yes (fixed left) |
| **Search bar** | ✅ Yes | ❌ No |
| **Bottom nav** | ✅ Yes (mobile) | ❌ No |

---

**Kesimpulan:** Sistem pembagian sudah jelas dengan middleware protection dan conditional redirect! 🎉
