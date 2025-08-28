# Project Requirement Document (PRD)

## Project Name
ProPangkat - Sistem Kenaikan Pangkat Terintegrasi

## Purpose
Menyediakan platform digital yang memudahkan proses kenaikan pangkat pegawai secara terintegrasi, efisien, dan transparan di lingkungan Dinas Pendidikan dan Kebudayaan Provinsi Kaltim.

## Goals
- Digitalisasi proses kenaikan pangkat pegawai
- Otomatisasi validasi data dan dokumen
- Pengelolaan multi-role (Admin, Operator, Operator Sekolah, Pegawai)
- Keamanan data dan autentikasi berlapis
- User Interface yang modern, minimalis, dan mudah digunakan

## Target Users
- Admin Dinas Pendidikan
- Operator Dinas
- Operator Sekolah
- Pegawai Negeri Sipil (PNS)

## Key Features
- Login multi-role dengan validasi NIP dan captcha
- Dashboard peran (role-based dashboard)
- Manajemen data pegawai dan riwayat pangkat
- Upload dan validasi dokumen
- Notifikasi status pengajuan
- Laporan dan rekapitulasi
- Keamanan: Captcha, validasi form, session management

## Non-Functional Requirements
- Responsive dan mobile-friendly
- Performa cepat (<2 detik load utama)
- Kompatibel dengan browser modern
- Aksesibilitas dasar (kontras, navigasi keyboard)
- Dokumentasi dan maintainability

## Success Metrics
- 100% proses pengajuan pangkat dilakukan secara digital
- Waktu proses pengajuan turun >50%
- Error rate <2% pada validasi data
- User satisfaction >80% (survey internal)

---

# Project Specification Document (PSD)

## 1. Arsitektur Teknologi
- **Backend:** Laravel 12.x (PHP 8.4+)
- **Frontend:** Blade, TailwindCSS, Alpine.js
- **Database:** SQLite (dev), MySQL/PostgreSQL (prod)
- **Authentication:** Laravel Auth, custom captcha
- **Deployment:** Linux/Windows server, Docker optional

## 2. Struktur Folder
- `app/` - Logic aplikasi (Controllers, Models, Requests)
- `resources/views/` - Blade templates (UI)
- `routes/` - Routing aplikasi
- `public/` - Static files & entry point
- `database/` - Migrations, seeders, factories
- `config/` - Konfigurasi aplikasi
- `tests/` - Unit & feature tests

## 3. Fitur Utama
### a. Login Multi-Role
- Pilihan role: Admin, Operator, Operator Sekolah, Pegawai
- Validasi NIP (18 digit, angka)
- Captcha custom (huruf besar, kecil, angka, 6 karakter)
- Validasi form real-time (Alpine.js)

### b. Dashboard
- Statistik pengajuan, status, dan notifikasi
- Akses fitur sesuai role

### c. Manajemen Data
- CRUD data pegawai
- Riwayat pangkat
- Upload dokumen (PDF, max 2MB)
- Validasi dokumen

### d. Laporan
- Rekap pengajuan per periode
- Export (PDF/Excel)

### e. Keamanan
- Captcha custom
- Session timeout
- CSRF protection
- Validasi input & output

## 4. UI/UX
- Minimalis, clean, modern (TailwindCSS)
- Komponen reusable (Blade Components)
- Dark mode support
- Responsive grid

## 5. Testing
- Unit test (PHPUnit, Pest)
- Feature test (login, pengajuan, upload)

## 6. Deployment
- .env untuk konfigurasi
- Artisan migration & seeder
- Build assets: `npm run build`

---

# Integrasi dengan README.md

Lihat [README.md](./README.md) untuk instruksi instalasi, setup, dan penggunaan.

---

**Dokumen ini wajib diperbarui jika ada perubahan requirement atau spesifikasi.**
