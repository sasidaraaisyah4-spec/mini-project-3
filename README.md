# Mini Project 3 - Inventory Management Pakaian

Aplikasi sistem manajemen inventaris berbasis web untuk toko pakaian. Proyek ini dibangun untuk memenuhi kriteria evaluasi mata kuliah Pemrograman Web, berfokus pada implementasi Relational Database, Database Transactions, dan praktik keamanan PHP tingkat lanjut (PDO Prepared Statements, XSS Escaping, Password Hashing).

## Fitur Utama

* **Authentication & Authorization:** Sistem login aman dengan `password_verify` dan pembatasan hak akses berbasis Role (Admin & Staff).
* **Dashboard Agregat:** Menampilkan total model pakaian, total aset (dalam Rupiah), dan peringatan otomatis untuk stok pakaian yang hampir habis.
* **Katalog Pakaian (Listing):** Dilengkapi dengan fitur Search (berdasarkan Nama/SKU), Sorting yang aman (Allowlist), dan Pagination.
* **Transaksi Terintegrasi (Commit/Rollback):** Proses barang keluar (penjualan) dijamin konsistensinya. Menggunakan fitur `FOR UPDATE` dan *Database Transactions* untuk mencegah stok minus dan memastikan histori selalu tersimpan.
* **Integritas Data:** Validasi Server-side, SKU Unik, dan Foreign Key (ON DELETE RESTRICT/CASCADE) untuk mencegah data yatim (orphan data).

## Teknologi yang Digunakan
* **Backend:** PHP (Native / PDO)
* **Database:** MySQL
* **Frontend:** HTML5 & CSS3 (Custom Dark Theme)
* **Keamanan:** Prepared Statements (SQL Injection Prevention), XSS Output Encoding

## Cara Menjalankan Aplikasi
1. Import file `database/schema.sql` ke dalam MySQL / phpMyAdmin (buat database dengan nama: `db_toko_pakaian`).
2. Pastikan konfigurasi database di file `config/database.php` sudah sesuai.
3. Akses aplikasi melalui browser: `http://localhost/inventory-app/public/login.php`
4. Gunakan kredensial berikut untuk login:
   - **Admin:** `admin_toko` | Password: `password`
   - **Staff:** `kasir_staff` | Password: `password`