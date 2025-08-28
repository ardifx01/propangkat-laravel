# ProPangkat - Proses Kenaikan Pangkat Terintegrasi

## 📄 Dokumen Proyek

Lihat dokumen [PRD & PSD (Project Requirement & Specification Document)](./PRD.md) untuk detail kebutuhan, spesifikasi, dan arsitektur proyek.

### Ringkasan PRD/PSD

- Digitalisasi proses kenaikan pangkat pegawai secara terintegrasi
- Multi-role login: Admin, Operator, Operator Sekolah, Pegawai
- Validasi NIP, captcha custom, dan keamanan berlapis
- Dashboard, manajemen data pegawai, upload & validasi dokumen
- Laporan, rekap, dan notifikasi status
- UI minimalis, modern, responsif (TailwindCSS, Alpine.js)
- Backend Laravel 12.x, database SQLite/MySQL
- Lihat PRD.md untuk detail lengkap

[![wakatime](https://wakatime.com/badge/user/cc62a71b-688a-408a-96de-c02f19b880ec/project/2ac163b6-3716-45a8-b1ae-95256de24150.svg)](https://wakatime.com/badge/user/cc62a71b-688a-408a-96de-c02f19b880ec/project/2ac163b6-3716-45a8-b1ae-95256de24150)
[![Laravel](https://img.shields.io/badge/Laravel-12.x-FF2D20?logo=laravel)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?logo=php)](https://php.net)
[![TailwindCSS](https://img.shields.io/badge/TailwindCSS-3.x-38B2AC?logo=tailwind-css)](https://tailwindcss.com)
[![AlpineJS](https://img.shields.io/badge/Alpine.js-3.x-8BC0D0?logo=alpine.js)](https://alpinejs.dev)
[![License](https://img.shields.io/badge/License-Proprietary-red.svg)](#-lisensi)

<p align="center">
  <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" alt="Laravel Logo" width="300">
</p>

Sistem terintegrasi untuk memudahkan proses kenaikan pangkat pegawai di lingkungan Dinas Pendidikan dan Kebudayaan Provinsi Kalimantan Timur. ProPangkat menghadirkan solusi digital yang memudahkan pengajuan, verifikasi, dan monitoring proses kenaikan pangkat.

## 🌟 Fitur

- 🔐 **Multi-level Authentication**: Sistem login untuk Pegawai, Operator Sekolah, Operator, dan Admin
- 📑 **Manajemen Dokumen**: Unggah, verifikasi, dan kelola dokumen persyaratan kenaikan pangkat
- 📊 **Dashboard Interaktif**: Pantau status pengajuan dan proses kenaikan pangkat secara real-time
- 🔔 **Notifikasi**: Dapatkan notifikasi untuk setiap perubahan status atau tindakan yang diperlukan
- 📱 **Responsive Design**: Akses sistem dari perangkat mana saja dengan tampilan yang responsif
- 🌓 **Dark/Light Mode**: Pilih tema tampilan sesuai preferensi pengguna
- 🔍 **Pencarian & Filter**: Temukan data dengan cepat menggunakan fitur pencarian dan filter
- 📝 **Form Validation**: Validasi data input untuk memastikan keakuratan data

## 🛠️ Teknologi

Aplikasi ini dibangun dengan:

- **[Laravel](https://laravel.com)**: Framework PHP untuk backend dan routing
- **[TailwindCSS](https://tailwindcss.com)**: Utility-first CSS framework untuk styling
- **[Alpine.js](https://alpinejs.dev)**: Framework JavaScript ringan untuk interaktivitas
- **[Lucide Icons](https://lucide.dev)**: Kumpulan ikon modern dan minimalis
- **[SQLite/MySQL](https://www.mysql.com)**: Database untuk penyimpanan data
- **[Vite](https://vitejs.dev)**: Build tool untuk asset compilation

## 🚀 Instalasi dan Setup

### Prasyarat

Pastikan Anda telah menginstal:

- PHP >= 8.2
- [Composer](https://getcomposer.org)
- [Node.js](https://nodejs.org) (>= 18.x) dan NPM
- [Git](https://git-scm.com)

### Langkah-langkah Instalasi

1. **Clone repository**

   ```bash
   git clone https://github.com/fk0u/propangkat-laravel.git
   cd propangkat-laravel
   ```

2. **Instal dependensi PHP**

   ```bash
   composer install
   ```

3. **Setup environment**

   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Konfigurasi database**

   Edit file `.env` dan sesuaikan konfigurasi database:

   ```env
   DB_CONNECTION=sqlite
   # Atau gunakan MySQL:
   # DB_CONNECTION=mysql
   # DB_HOST=127.0.0.1
   # DB_PORT=3306
   # DB_DATABASE=propangkat
   # DB_USERNAME=root
   # DB_PASSWORD=
   ```

   Jika menggunakan SQLite, buat file database:

   ```bash
   touch database/database.sqlite
   ```

5. **Jalankan migrasi dan seeder**

   ```bash
   php artisan migrate --seed
   ```

6. **Instal dependensi JavaScript**

   ```bash
   npm install
   ```

7. **Compile assets**

   ```bash
   npm run build
   ```

   Untuk development mode dengan hot reload:

   ```bash
   npm run dev
   ```

8. **Jalankan server development**

   ```bash
   php artisan serve
   ```

   Aplikasi sekarang berjalan di [http://localhost:8000](http://localhost:8000)

## 🧪 Kredensial untuk Testing

Setelah menjalankan seeder, Anda dapat menggunakan kredensial berikut untuk testing:

### Admin
- **NIP**: 198001012001121001
- **Password**: admin123

### Operator
- **NIP**: 198001012001121002
- **Password**: operator123

### Operator Sekolah
- **NIP**: 198001012001121003
- **Password**: opsekolah123

### Pegawai
- **NIP**: 198901012020011001
- **Password**: pegawai123

## 🏗️ Struktur Aplikasi

Berikut adalah penjelasan singkat tentang struktur aplikasi:

- `app/` - Kode utama aplikasi
  - `Http/Controllers/` - Controller untuk menangani request
  - `Models/` - Model Eloquent untuk interaksi database
  - `Providers/` - Service provider aplikasi
- `database/` - Migrasi, seeder, dan factory database
- `public/` - File yang diakses publik
- `resources/` - View, assets, dan file yang perlu dikompilasi
  - `views/` - File template Blade
  - `css/` - Style dengan TailwindCSS
  - `js/` - JavaScript dengan Alpine.js
- `routes/` - Definisi route aplikasi
- `storage/` - File yang dibuat aplikasi (log, cache, dll)

## 🧩 Pengembangan Aplikasi

### Menambahkan Fitur Baru

1. Buat migration jika diperlukan perubahan database:

   ```bash
   php artisan make:migration create_feature_table
   ```

2. Buat model:

   ```bash
   php artisan make:model Feature
   ```

3. Buat controller:

   ```bash
   php artisan make:controller FeatureController --resource
   ```

4. Tambahkan route di `routes/web.php`:

   ```php
   Route::resource('features', FeatureController::class);
   ```

5. Buat view di `resources/views/features/`:

   ```bash
   mkdir -p resources/views/features
   touch resources/views/features/index.blade.php
   touch resources/views/features/show.blade.php
   touch resources/views/features/create.blade.php
   touch resources/views/features/edit.blade.php
   ```

### Menjalankan Test

```bash
php artisan test
```

## 🔄 Deployment

### Persiapan Deployment

1. Optimize aplikasi:

   ```bash
   php artisan optimize
   ```

2. Compile assets untuk production:

   ```bash
   npm run build
   ```

### Server Requirements

- PHP >= 8.2 dengan ekstensi berikut:
  - BCMath
  - Ctype
  - Fileinfo
  - JSON
  - Mbstring
  - OpenSSL
  - PDO
  - Tokenizer
  - XML
- Composer
- Web server (Apache/Nginx)
- Database server (MySQL/MariaDB/PostgreSQL)

## 📝 Lisensi

```
This software is proprietary and confidential.
Unauthorized copying, modification, use, or distribution of this software,
via any medium, is strictly prohibited without the express permission of the author.

Copyright © 2025 KOU & Dinas Pendidikan dan Kebudayaan Provinsi Kalimantan Timur
All rights reserved.
```

## 🤝 Kontribusi

Kontribusi hanya dapat dilakukan dengan izin tertulis dari pemilik hak cipta. Silakan hubungi tim pengembang untuk informasi lebih lanjut.

## 🌐 Link Terkait

- [Versi Next.js](https://github.com/fk0u/propangkat-next) - [![wakatime](https://wakatime.com/badge/user/cc62a71b-688a-408a-96de-c02f19b880ec/project/c20c4481-58fd-4844-b486-29c21c43fdbf.svg)](https://wakatime.com/badge/user/cc62a71b-688a-408a-96de-c02f19b880ec/project/c20c4481-58fd-4844-b486-29c21c43fdbf)
- [Website Resmi Dinas Pendidikan dan Kebudayaan Prov. Kaltim](https://disdik.kaltimprov.go.id)

---

<p align="center">
  Dibuat dengan ❤️ oleh Tim VanDevs untuk Dinas Pendidikan dan Kebudayaan Provinsi Kalimantan Timur.
</p>
