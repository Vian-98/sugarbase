/*==============================================================*/
/* DBMS name: MySQL 5.0                                         */
/* Project  : Sugarbase E-Commerce                              */
/* Created  : 25/04/2026                                        */
/*==============================================================*/

USE sugarbase;

SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS TRACKING_STATUS;
DROP TABLE IF EXISTS PESANAN_ITEM;
DROP TABLE IF EXISTS PEMBAYARAN;
DROP TABLE IF EXISTS PESANAN;
DROP TABLE IF EXISTS NOTIFIKASI;
DROP TABLE IF EXISTS KERANJANG_ITEM;
DROP TABLE IF EXISTS KERANJANG;
DROP TABLE IF EXISTS PRODUK;
DROP TABLE IF EXISTS KATEGORI;
DROP TABLE IF EXISTS ADMIN;
DROP TABLE IF EXISTS PELANGGAN;
DROP TABLE IF EXISTS AKUN;

SET FOREIGN_KEY_CHECKS = 1;

/*==============================================================*/
/* Table: AKUN (parent dari ADMIN dan PELANGGAN)                */
/*==============================================================*/
CREATE TABLE AKUN
(
   ID_AKUN              INT NOT NULL AUTO_INCREMENT COMMENT 'Primary key akun',
   NAMA                 VARCHAR(100) NOT NULL COMMENT 'Nama lengkap',
   EMAIL                VARCHAR(100) NOT NULL UNIQUE COMMENT 'Email unik untuk login',
   PASSWORD             VARCHAR(255) NOT NULL COMMENT 'Password terenkripsi',
   ROLE                 VARCHAR(20) NOT NULL COMMENT 'admin / pelanggan',
   STATUS_AKUN          VARCHAR(20) NOT NULL DEFAULT 'aktif' COMMENT 'aktif / nonaktif',
   TANGGAL_DAFTAR       DATE NOT NULL COMMENT 'Tanggal registrasi',
   NO_HP                VARCHAR(15) COMMENT 'Nomor HP opsional',
   PRIMARY KEY (ID_AKUN)
);

/*==============================================================*/
/* Table: ADMIN (child dari AKUN)                               */
/*==============================================================*/
CREATE TABLE ADMIN
(
   ID_AKUN              INT NOT NULL COMMENT 'FK ke AKUN',
   LEVEL_AKSES          VARCHAR(20) NOT NULL COMMENT 'superadmin / admin',
   STATUS_ADMIN         VARCHAR(20) NOT NULL DEFAULT 'aktif' COMMENT 'aktif / nonaktif',
   PRIMARY KEY (ID_AKUN),
   CONSTRAINT FK_ADMIN_AKUN FOREIGN KEY (ID_AKUN)
      REFERENCES AKUN (ID_AKUN) ON DELETE CASCADE ON UPDATE CASCADE
);

/*==============================================================*/
/* Table: PELANGGAN (child dari AKUN)                           */
/*==============================================================*/
CREATE TABLE PELANGGAN
(
   ID_AKUN              INT NOT NULL COMMENT 'FK ke AKUN',
   TANGGAL_LAHIR        DATE COMMENT 'Tanggal lahir opsional',
   JENIS_KELAMIN        VARCHAR(20) COMMENT 'L / P',
   FOTO_PROFIL          VARCHAR(255) COMMENT 'Path foto profil',
   STATUS_MEMBER        VARCHAR(20) NOT NULL DEFAULT 'reguler' COMMENT 'reguler / premium',
   PRIMARY KEY (ID_AKUN),
   CONSTRAINT FK_PELANGGAN_AKUN FOREIGN KEY (ID_AKUN)
      REFERENCES AKUN (ID_AKUN) ON DELETE CASCADE ON UPDATE CASCADE
);

/*==============================================================*/
/* Table: KATEGORI                                              */
/*==============================================================*/
CREATE TABLE KATEGORI
(
   ID_KATEGORI          INT NOT NULL AUTO_INCREMENT COMMENT 'Primary key kategori',
   NAMA_KATEGORI        VARCHAR(100) NOT NULL COMMENT 'Nama kategori produk',
   DESKRIPSI_KATEGORI   VARCHAR(255) COMMENT 'Deskripsi kategori',
   PRIMARY KEY (ID_KATEGORI)
);

/*==============================================================*/
/* Table: PRODUK                                                */
/*==============================================================*/
CREATE TABLE PRODUK
(
   ID_PRODUK            INT NOT NULL AUTO_INCREMENT COMMENT 'Primary key produk',
   ID_KATEGORI          INT COMMENT 'FK ke KATEGORI',
   ID_AKUN              INT COMMENT 'FK ke ADMIN yang mengelola',
   NAMA_PRODUK          VARCHAR(100) NOT NULL COMMENT 'Nama produk',
   HARGA                DECIMAL(12,2) NOT NULL COMMENT 'Harga produk',
   STOK                 INT NOT NULL DEFAULT 0 COMMENT 'Jumlah stok tersedia',
   FOTO                 VARCHAR(255) NOT NULL COMMENT 'Path foto produk',
   STATUS_PRODUK        VARCHAR(20) NOT NULL DEFAULT 'aktif' COMMENT 'aktif / nonaktif',
   DESKRIPSI_PRODUK     VARCHAR(255) COMMENT 'Deskripsi produk',
   PRIMARY KEY (ID_PRODUK),
   CONSTRAINT FK_PRODUK_KATEGORI FOREIGN KEY (ID_KATEGORI)
      REFERENCES KATEGORI (ID_KATEGORI) ON DELETE SET NULL ON UPDATE CASCADE,
   CONSTRAINT FK_PRODUK_ADMIN FOREIGN KEY (ID_AKUN)
      REFERENCES ADMIN (ID_AKUN) ON DELETE SET NULL ON UPDATE CASCADE
);

/*==============================================================*/
/* Table: KERANJANG                                             */
/*==============================================================*/
CREATE TABLE KERANJANG
(
   ID_KERANJANG         INT NOT NULL AUTO_INCREMENT COMMENT 'Primary key keranjang',
   ID_AKUN              INT COMMENT 'FK ke PELANGGAN',
   TANGGAL_DIBUAT       DATE NOT NULL COMMENT 'Tanggal keranjang dibuat',
   STATUS_KERANJANG     VARCHAR(20) NOT NULL DEFAULT 'aktif' COMMENT 'aktif / checkout',
   PRIMARY KEY (ID_KERANJANG),
   CONSTRAINT FK_KERANJANG_PELANGGAN FOREIGN KEY (ID_AKUN)
      REFERENCES PELANGGAN (ID_AKUN) ON DELETE CASCADE ON UPDATE CASCADE
);

/*==============================================================*/
/* Table: KERANJANG_ITEM                                        */
/*==============================================================*/
CREATE TABLE KERANJANG_ITEM
(
   ID_KERANJANG_ITEM    INT NOT NULL AUTO_INCREMENT COMMENT 'Primary key item keranjang',
   ID_KERANJANG         INT COMMENT 'FK ke KERANJANG',
   ID_PRODUK            INT COMMENT 'FK ke PRODUK',
   JUMLAH_KERANJANG     INT NOT NULL DEFAULT 1 COMMENT 'Jumlah produk di keranjang',
   HARGA_SATUAN_KERANJANG DECIMAL(12,2) NOT NULL COMMENT 'Harga satuan saat ditambah',
   SUBTOTAL_KERANJANG   DECIMAL(12,2) NOT NULL COMMENT 'Subtotal item keranjang',
   PRIMARY KEY (ID_KERANJANG_ITEM),
   CONSTRAINT FK_KERANJANG_ITEM_KERANJANG FOREIGN KEY (ID_KERANJANG)
      REFERENCES KERANJANG (ID_KERANJANG) ON DELETE CASCADE ON UPDATE CASCADE,
   CONSTRAINT FK_KERANJANG_ITEM_PRODUK FOREIGN KEY (ID_PRODUK)
      REFERENCES PRODUK (ID_PRODUK) ON DELETE SET NULL ON UPDATE CASCADE
);

/*==============================================================*/
/* Table: PESANAN                                               */
/*==============================================================*/
CREATE TABLE PESANAN
(
   ID_PESANAN           INT NOT NULL AUTO_INCREMENT COMMENT 'Primary key pesanan',
   ID_AKUN              INT COMMENT 'FK ke PELANGGAN',
   TANGGAL_PESAN        DATE NOT NULL COMMENT 'Tanggal pesanan dibuat',
   TOTAL_HARGA          DECIMAL(12,2) NOT NULL COMMENT 'Total harga pesanan',
   STATUS_PESANAN       VARCHAR(20) NOT NULL DEFAULT 'pending' COMMENT 'pending / diproses / dikirim / selesai / dibatalkan',
   PRIMARY KEY (ID_PESANAN),
   CONSTRAINT FK_PESANAN_PELANGGAN FOREIGN KEY (ID_AKUN)
      REFERENCES PELANGGAN (ID_AKUN) ON DELETE SET NULL ON UPDATE CASCADE
);

/*==============================================================*/
/* Table: PESANAN_ITEM                                          */
/*==============================================================*/
CREATE TABLE PESANAN_ITEM
(
   ID_PESANAN_ITEM      INT NOT NULL AUTO_INCREMENT COMMENT 'Primary key item pesanan',
   ID_PESANAN           INT COMMENT 'FK ke PESANAN',
   ID_PRODUK            INT COMMENT 'FK ke PRODUK',
   JUMLAH_PESANAN       INT NOT NULL COMMENT 'Jumlah produk dipesan',
   HARGA_SATUAN_PESANAN DECIMAL(12,2) NOT NULL COMMENT 'Harga satuan saat pesan',
   SUBTOTAL_PESANAN     DECIMAL(12,2) NOT NULL COMMENT 'Subtotal item pesanan',
   PRIMARY KEY (ID_PESANAN_ITEM),
   CONSTRAINT FK_PESANAN_ITEM_PESANAN FOREIGN KEY (ID_PESANAN)
      REFERENCES PESANAN (ID_PESANAN) ON DELETE CASCADE ON UPDATE CASCADE,
   CONSTRAINT FK_PESANAN_ITEM_PRODUK FOREIGN KEY (ID_PRODUK)
      REFERENCES PRODUK (ID_PRODUK) ON DELETE SET NULL ON UPDATE CASCADE
);

/*==============================================================*/
/* Table: PEMBAYARAN                                            */
/*==============================================================*/
CREATE TABLE PEMBAYARAN
(
   ID_PEMBAYARAN        INT NOT NULL AUTO_INCREMENT COMMENT 'Primary key pembayaran',
   ID_PESANAN           INT COMMENT 'FK ke PESANAN',
   METODE_PEMBAYARAN    VARCHAR(50) NOT NULL COMMENT 'transfer / cod / ewallet',
   STATUS_PEMBAYARAN    VARCHAR(20) NOT NULL DEFAULT 'menunggu' COMMENT 'menunggu / lunas / gagal',
   TANGGAL_BAYAR        DATE NOT NULL COMMENT 'Tanggal pembayaran',
   JUMLAH_BAYAR         DECIMAL(12,2) NOT NULL COMMENT 'Jumlah yang dibayar',
   PRIMARY KEY (ID_PEMBAYARAN),
   CONSTRAINT FK_PEMBAYARAN_PESANAN FOREIGN KEY (ID_PESANAN)
      REFERENCES PESANAN (ID_PESANAN) ON DELETE CASCADE ON UPDATE CASCADE
);

/*==============================================================*/
/* Table: TRACKING_STATUS                                       */
/*==============================================================*/
CREATE TABLE TRACKING_STATUS
(
   ID_TRACKING          INT NOT NULL AUTO_INCREMENT COMMENT 'Primary key tracking',
   ID_PESANAN           INT COMMENT 'FK ke PESANAN',
   STATUS               VARCHAR(50) NOT NULL COMMENT 'Status pengiriman',
   WAKTU_UPDATE         DATETIME NOT NULL COMMENT 'Waktu update status',
   KETERANGAN           VARCHAR(255) NOT NULL COMMENT 'Keterangan detail status',
   PRIMARY KEY (ID_TRACKING),
   CONSTRAINT FK_TRACKING_PESANAN FOREIGN KEY (ID_PESANAN)
      REFERENCES PESANAN (ID_PESANAN) ON DELETE CASCADE ON UPDATE CASCADE
);

/*==============================================================*/
/* Table: NOTIFIKASI                                            */
/*==============================================================*/
CREATE TABLE NOTIFIKASI
(
   ID_NOTIFIKASI        INT NOT NULL AUTO_INCREMENT COMMENT 'Primary key notifikasi',
   ID_AKUN              INT COMMENT 'FK ke AKUN (bisa admin atau pelanggan)',
   JUDUL                VARCHAR(100) NOT NULL COMMENT 'Judul notifikasi',
   PESAN                VARCHAR(255) NOT NULL COMMENT 'Isi pesan notifikasi',
   WAKTU_KIRIM          DATETIME NOT NULL COMMENT 'Waktu notifikasi dikirim',
   STATUS_BACA          VARCHAR(20) NOT NULL DEFAULT 'belum' COMMENT 'belum / sudah',
   PRIMARY KEY (ID_NOTIFIKASI),
   CONSTRAINT FK_NOTIFIKASI_AKUN FOREIGN KEY (ID_AKUN)
      REFERENCES AKUN (ID_AKUN) ON DELETE CASCADE ON UPDATE CASCADE
);
