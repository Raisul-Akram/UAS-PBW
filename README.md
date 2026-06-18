# Aplikasi Web Manajemen Bengkel Servis (UAS PBW)

Aplikasi Web Manajemen Bengkel Servis adalah platform berbasis web yang dibangun menggunakan framework **Laravel** untuk mempermudah pengelolaan antrean perbaikan perangkat di bengkel servis, penugasan teknisi, serta transparansi status dan biaya perbaikan kepada pelanggan secara real-time.

## Fitur Utama

### 🛠️ Portal Administrator
- **Dashboard Statistik**: Memantau total servis, antrean aktif, perangkat diproses, perbaikan selesai, jumlah pelanggan, dan teknisi aktif.
- **Manajemen Antrean Servis**: 
  - Mendaftarkan servis baru untuk pelanggan secara langsung.
  - Mengubah status perbaikan secara dinamis (**Antri**, **Diproses**, **Selesai**, **Diambil**).
  - Menugaskan teknisi penanggungjawab untuk tiap perangkat.
  - Memasukkan nominal **Estimasi Biaya Awal** dan **Biaya Final** dengan fitur auto-formatting (ribuan pemisah titik) secara real-time.
  - Menulis catatan diagnosis teknisi/tindakan perbaikan.
- **Manajemen Pelanggan**: Melihat detail informasi pelanggan terdaftar.
- **Manajemen Teknisi**: Mengelola data teknisi beserta status keaktifannya.

### 👤 Portal Pelanggan (User)
- **Dashboard Pelanggan**: Melihat ringkasan pengajuan servis dan histori terbaru.
- **Pengajuan Servis Mandiri (Online)**: Mengajukan formulir perbaikan perangkat dengan mendeskripsikan tipe perangkat dan gejala kerusakan.
- **Pelacakan Real-time (Tracking Timeline)**:
  - Memantau perjalanan status perbaikan secara transparan.
  - Melihat detail teknisi yang menangani perangkat mereka.
  - Melihat nominal **Estimasi Biaya Awal** dan **Biaya Final** secara langsung (status "Menunggu Diagnosa" jika harga belum ditentukan admin).
  - Membaca catatan teknisi/hasil perbaikan perangkat.

---

## Teknologi yang Digunakan
- **Backend Framework**: Laravel 11.x (PHP 8.2+)
- **Frontend Assets**: Tailwind CSS, Vanilla JavaScript
- **Database**: SQLite (Dump file SQL tersedia sebagai `database.sql`)
- **Testing**: PHPUnit (Feature & Unit Tests)

---

## Panduan Instalasi dan Konfigurasi

### Prasyarat
Pastikan komputer Anda sudah terinstal:
- PHP >= 8.2
- Composer
- Node.js & NPM
- SQLite3 (Opsional, untuk membuka DB langsung)

### Langkah-langkah Setup
1. **Clone Repository**:
   ```bash
   git clone <url-repository-anda>
   cd <nama-folder-project>
   ```

2. **Jalankan Setup Otomatis**:
   Project ini menyediakan script setup bawaan di `composer.json` yang akan menginstal dependencies, menyalin file `.env`, generate app key, menjalankan migrasi database, dan membangun file assets. Cukup jalankan perintah berikut:
   ```bash
   composer run setup
   ```

3. **Jalankan Seeder Database (Opsional)**:
   Untuk mengisi data awal (pelanggan, teknisi, admin, dan riwayat servis) untuk uji coba, jalankan:
   ```bash
   php artisan db:seed
   ```

4. **Jalankan Server Lokal**:
   Untuk menjalankan server Laravel beserta asset build watcher (Vite), jalankan:
   ```bash
   composer run dev
   ```
   Aplikasi akan berjalan dan dapat diakses melalui browser pada alamat [http://127.0.0.1:8000](http://127.0.0.1:8000).

5. **Jalankan Unit/Feature Tests**:
   Untuk memastikan seluruh fitur dan proteksi keamanan (seperti pencegahan IDOR dan validasi biaya) berjalan normal:
   ```bash
   composer run test
   ```

---

## Akun Demo Pengujian (Seed Data)
Setelah melakukan seeder database, Anda dapat login menggunakan akun pengujian berikut:

- **Akun Administrator**:
  - **Email**: `admin@bengkel.com`
  - **Password**: `password`
- **Akun Pelanggan**:
  - **Email**: `pelanggan@bengkel.com`
  - **Password**: `password`

---

## File Dump Database
Sesuai dengan kriteria tugas, dump database SQL lengkap dengan struktur tabel dan data awal telah disertakan pada file **`database.sql`** di root folder project ini.
