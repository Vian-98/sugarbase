<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // TABEL AKUN (Parent Table)
        Schema::create('akun', function (Blueprint $table) {
            $table->id('id_akun')->comment('Primary key akun');
            $table->string('nama', 100)->comment('Nama lengkap');
            $table->string('email', 100)->unique()->comment('Email unik untuk login');
            $table->string('password', 255)->comment('Password terenkripsi');
            $table->enum('role', ['admin', 'pelanggan'])->comment('admin / pelanggan');
            $table->enum('status_akun', ['aktif', 'nonaktif'])->default('aktif')->comment('aktif / nonaktif');
            $table->date('tanggal_daftar')->comment('Tanggal registrasi');
            $table->string('no_hp', 15)->nullable()->comment('Nomor HP opsional');
            $table->timestamps();
        });

        // TABEL ADMIN (Child dari AKUN)
        Schema::create('admin', function (Blueprint $table) {
            $table->unsignedBigInteger('id_akun')->comment('FK ke AKUN');
            $table->enum('level_akses', ['superadmin', 'admin'])->comment('superadmin / admin');
            $table->enum('status_admin', ['aktif', 'nonaktif'])->default('aktif')->comment('aktif / nonaktif');
            $table->primary('id_akun');
            $table->foreign('id_akun')->references('id_akun')->on('akun')->onDelete('cascade')->onUpdate('cascade');
        });

        // TABEL PELANGGAN (Child dari AKUN)
        Schema::create('pelanggan', function (Blueprint $table) {
            $table->unsignedBigInteger('id_akun')->comment('FK ke AKUN');
            $table->date('tanggal_lahir')->nullable()->comment('Tanggal lahir opsional');
            $table->enum('jenis_kelamin', ['L', 'P'])->nullable()->comment('L / P');
            $table->string('foto_profil', 255)->nullable()->comment('Path foto profil');
            $table->enum('status_member', ['reguler', 'premium'])->default('reguler')->comment('reguler / premium');
            $table->primary('id_akun');
            $table->foreign('id_akun')->references('id_akun')->on('akun')->onDelete('cascade')->onUpdate('cascade');
        });

        // TABEL KATEGORI
        Schema::create('kategori', function (Blueprint $table) {
            $table->id('id_kategori')->comment('Primary key kategori');
            $table->string('nama_kategori', 100)->comment('Nama kategori produk');
            $table->string('deskripsi_kategori', 255)->nullable()->comment('Deskripsi kategori');
            $table->timestamps();
        });

        // TABEL PRODUK
        Schema::create('produk', function (Blueprint $table) {
            $table->id('id_produk')->comment('Primary key produk');
            $table->unsignedBigInteger('id_kategori')->nullable()->comment('FK ke KATEGORI');
            $table->unsignedBigInteger('id_akun')->nullable()->comment('FK ke ADMIN yang mengelola');
            $table->string('nama_produk', 100)->comment('Nama produk');
            $table->decimal('harga', 12, 2)->comment('Harga produk');
            $table->integer('stok')->default(0)->comment('Jumlah stok tersedia');
            $table->string('foto', 255)->comment('Path foto produk');
            $table->enum('status_produk', ['aktif', 'nonaktif'])->default('aktif')->comment('aktif / nonaktif');
            $table->string('deskripsi_produk', 255)->nullable()->comment('Deskripsi produk');
            $table->timestamps();
            $table->foreign('id_kategori')->references('id_kategori')->on('kategori')->onDelete('set null')->onUpdate('cascade');
            $table->foreign('id_akun')->references('id_akun')->on('admin')->onDelete('set null')->onUpdate('cascade');
        });

        // TABEL KERANJANG
        Schema::create('keranjang', function (Blueprint $table) {
            $table->id('id_keranjang')->comment('Primary key keranjang');
            $table->unsignedBigInteger('id_akun')->nullable()->comment('FK ke PELANGGAN');
            $table->date('tanggal_dibuat')->comment('Tanggal keranjang dibuat');
            $table->enum('status_keranjang', ['aktif', 'checkout'])->default('aktif')->comment('aktif / checkout');
            $table->timestamps();
            $table->foreign('id_akun')->references('id_akun')->on('pelanggan')->onDelete('cascade')->onUpdate('cascade');
        });

        // TABEL KERANJANG_ITEM
        Schema::create('keranjang_item', function (Blueprint $table) {
            $table->id('id_keranjang_item')->comment('Primary key item keranjang');
            $table->unsignedBigInteger('id_keranjang')->nullable()->comment('FK ke KERANJANG');
            $table->unsignedBigInteger('id_produk')->nullable()->comment('FK ke PRODUK');
            $table->integer('jumlah_keranjang')->default(1)->comment('Jumlah produk di keranjang');
            $table->decimal('harga_satuan_keranjang', 12, 2)->comment('Harga satuan saat ditambah');
            $table->decimal('subtotal_keranjang', 12, 2)->comment('Subtotal item keranjang');
            $table->timestamps();
            $table->foreign('id_keranjang')->references('id_keranjang')->on('keranjang')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('id_produk')->references('id_produk')->on('produk')->onDelete('set null')->onUpdate('cascade');
        });

        // TABEL PESANAN
        Schema::create('pesanan', function (Blueprint $table) {
            $table->id('id_pesanan')->comment('Primary key pesanan');
            $table->unsignedBigInteger('id_akun')->nullable()->comment('FK ke PELANGGAN');
            $table->date('tanggal_pesan')->comment('Tanggal pesanan dibuat');
            $table->decimal('total_harga', 12, 2)->comment('Total harga pesanan');
            $table->enum('status_pesanan', ['pending', 'diproses', 'dikirim', 'selesai', 'dibatalkan'])->default('pending')->comment('Status pesanan');
            $table->timestamps();
            $table->foreign('id_akun')->references('id_akun')->on('pelanggan')->onDelete('set null')->onUpdate('cascade');
        });

        // TABEL PESANAN_ITEM
        Schema::create('pesanan_item', function (Blueprint $table) {
            $table->id('id_pesanan_item')->comment('Primary key item pesanan');
            $table->unsignedBigInteger('id_pesanan')->nullable()->comment('FK ke PESANAN');
            $table->unsignedBigInteger('id_produk')->nullable()->comment('FK ke PRODUK');
            $table->integer('jumlah_pesanan')->comment('Jumlah produk dipesan');
            $table->decimal('harga_satuan_pesanan', 12, 2)->comment('Harga satuan saat pesan');
            $table->decimal('subtotal_pesanan', 12, 2)->comment('Subtotal item pesanan');
            $table->timestamps();
            $table->foreign('id_pesanan')->references('id_pesanan')->on('pesanan')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('id_produk')->references('id_produk')->on('produk')->onDelete('set null')->onUpdate('cascade');
        });

        // TABEL PEMBAYARAN
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->id('id_pembayaran')->comment('Primary key pembayaran');
            $table->unsignedBigInteger('id_pesanan')->nullable()->comment('FK ke PESANAN');
            $table->enum('metode_pembayaran', ['transfer', 'cod', 'ewallet'])->comment('transfer / cod / ewallet');
            $table->enum('status_pembayaran', ['menunggu', 'lunas', 'gagal'])->default('menunggu')->comment('menunggu / lunas / gagal');
            $table->date('tanggal_bayar')->comment('Tanggal pembayaran');
            $table->decimal('jumlah_bayar', 12, 2)->comment('Jumlah yang dibayar');
            $table->timestamps();
            $table->foreign('id_pesanan')->references('id_pesanan')->on('pesanan')->onDelete('cascade')->onUpdate('cascade');
        });

        // TABEL TRACKING_STATUS
        Schema::create('tracking_status', function (Blueprint $table) {
            $table->id('id_tracking')->comment('Primary key tracking');
            $table->unsignedBigInteger('id_pesanan')->nullable()->comment('FK ke PESANAN');
            $table->string('status', 50)->comment('Status pengiriman');
            $table->dateTime('waktu_update')->comment('Waktu update status');
            $table->string('keterangan', 255)->comment('Keterangan detail status');
            $table->timestamps();
            $table->foreign('id_pesanan')->references('id_pesanan')->on('pesanan')->onDelete('cascade')->onUpdate('cascade');
        });

        // TABEL NOTIFIKASI
        Schema::create('notifikasi', function (Blueprint $table) {
            $table->id('id_notifikasi')->comment('Primary key notifikasi');
            $table->unsignedBigInteger('id_akun')->nullable()->comment('FK ke AKUN (bisa admin atau pelanggan)');
            $table->string('judul', 100)->comment('Judul notifikasi');
            $table->string('pesan', 255)->comment('Isi pesan notifikasi');
            $table->dateTime('waktu_kirim')->comment('Waktu notifikasi dikirim');
            $table->enum('status_baca', ['belum', 'sudah'])->default('belum')->comment('belum / sudah');
            $table->timestamps();
            $table->foreign('id_akun')->references('id_akun')->on('akun')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifikasi');
        Schema::dropIfExists('tracking_status');
        Schema::dropIfExists('pembayaran');
        Schema::dropIfExists('pesanan_item');
        Schema::dropIfExists('pesanan');
        Schema::dropIfExists('keranjang_item');
        Schema::dropIfExists('keranjang');
        Schema::dropIfExists('produk');
        Schema::dropIfExists('kategori');
        Schema::dropIfExists('pelanggan');
        Schema::dropIfExists('admin');
        Schema::dropIfExists('akun');
    }
};
