# ProPangkat - Setup Instructions

Berikut adalah instruksi untuk mengatur aplikasi ProPangkat setelah melakukan clone dari repository:

## Setup Database

1. Pastikan konfigurasi database sudah benar di file `.env`
2. Jalankan migrasi untuk membuat tabel database:

```bash
php artisan migrate:fresh
```

3. Jalankan seeder untuk membuat data pengguna:

```bash
php artisan db:seed
```

## Akun Default

Berikut adalah akun default yang dibuat oleh seeder:

| Tipe Pengguna | Username/Email | Password |
|---------------|---------------|----------|
| Administrator | admin@propangkat.com / admin | admin123 |
| Verifikator | verifikator@propangkat.com / verifikator | verifikator123 |
| Operator | operator@propangkat.com / operator | operator123 |
| Pegawai | pegawai@propangkat.com / 198901012020011001 | pegawai123 |

## Menjalankan Aplikasi

Jalankan server development dengan perintah:

```bash
php artisan serve
```

Untuk menjalankan Vite untuk asset bundling:

```bash
npm run dev
```

## Fitur Utama

1. **Halaman Welcome** - Landing page dengan tampilan modern dan responsif
2. **Unified Login** - Sistem login terpadu untuk semua jenis pengguna
3. **Dashboard Khusus** - Dashboard yang berbeda berdasarkan peran pengguna

## Pengembangan Selanjutnya

- Halaman manajemen pengguna
- Modul pengajuan kenaikan pangkat
- Sistem verifikasi dokumen
- Modul pelacakan status pengajuan
- Notifikasi email dan sistem

Terima kasih telah menggunakan ProPangkat!
