# Mini Project 3 - Aplikasi Inventory Management

Aplikasi manajemen inventaris toko pakaian ini dibangun menggunakan PHP Native dengan ekstensi PDO untuk memastikan keamanan dan konsistensi data.

## Penjelasan Business Rule (Aturan Bisnis)

Berikut adalah aturan logika bisnis utama yang berjalan di dalam aplikasi ini:

1. **Otorisasi Hak Akses (Role-Based Access):**
   - **Admin / Admin Toko:** Memiliki hak akses penuh terhadap semua fitur, termasuk mengedit dan menghapus data master pakaian.
   - **Staff / Kasir:** Dapat melihat katalog, memproses barang masuk, dan memproses barang keluar, namun **dibatasi** dan tidak diizinkan untuk mengedit atau menghapus data master pakaian.

2. **Keamanan Transaksi (Database Transaction):**
   - Setiap proses *Barang Masuk* dan *Barang Keluar* menggunakan mekanisme PDO Transaction (`beginTransaction`, `commit`, `rollBack`). 
   - Hal ini menjamin bahwa proses pembaruan total stok pakaian dan pencatatan riwayat pergerakan barang (histori) terjadi secara sinkron. Jika salah satu proses gagal, seluruh data akan dikembalikan ke keadaan semula (Rollback).

3. **Integritas Stok:**
   - Sistem secara otomatis memvalidasi bahwa stok barang tidak boleh bernilai negatif (minus). Transaksi barang keluar akan ditolak jika jumlah yang ditarik melebihi ketersediaan stok saat ini.

4. **Standar Keamanan:**
   - Seluruh kueri basis data menggunakan **PDO Prepared Statements** untuk mencegah serangan SQL Injection (tidak menggunakan metode *query concatenation*).
   - Seluruh data yang ditampilkan ke antarmuka pengguna telah melewati proses *HTML Escaping* untuk menghindari celah keamanan XSS.

---
**Deliverables:**
Source code, file `schema.sql`, dan folder berisi gambar *screenshot* pengujian (fitur, validation error, dan role akses) telah disertakan di dalam repositori ini.