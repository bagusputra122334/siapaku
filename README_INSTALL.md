# Panduan Instalasi Sistem Admin Siapaku

## Langkah 1: Import Database
1. Buka phpMyAdmin (biasanya di http://localhost/phpmyadmin)
2. Klik tab "Import"
3. Pilih file `database.sql` dari folder proyek
4. Klik "Go" untuk mengimpor

## Langkah 2: Jalankan Aplikasi
1. Pastikan XAMPP (Apache + MySQL) berjalan
2. Akses website di: http://localhost/Siapaku/
3. Akses panel admin di: http://localhost/Siapaku/admin/login.php

## Login Admin Default
- Username: `admin`
- Password: `admin123`

## Catatan Penting
- File `index.php` adalah halaman utama baru yang menarik data dari database
- File `index.html` masih ada sebagai backup
- Semua konten bisa diubah melalui panel admin tanpa perlu edit kode

## Struktur File
```
Siapaku/
├── config.php          # Konfigurasi database
├── database.sql        # Skema database
├── index.php           # Halaman utama (dengan database)
├── admin/
│   ├── login.php       # Halaman login admin
│   ├── dashboard.php   # Dashboard utama
│   ├── proyek.php      # Manajemen proyek
│   ├── tentang.php     # Manajemen tentang saya
│   ├── skills.php      # Manajemen skills
│   ├── kontak.php      # Manajemen kontak
│   ├── auth.php        # Cek autentikasi
│   └── logout.php      # Logout
└── ... (file lain tetap ada)
```