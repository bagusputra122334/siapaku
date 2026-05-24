-- Buat database
CREATE DATABASE IF NOT EXISTS siapaku_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE siapaku_db;

-- Tabel admin
CREATE TABLE IF NOT EXISTS admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert admin default (username: admin, password: admin123)
INSERT INTO admin (username, password) VALUES ('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi')
ON DUPLICATE KEY UPDATE username=username;

-- Tabel tentang
CREATE TABLE IF NOT EXISTS tentang (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    deskripsi TEXT NOT NULL,
    foto_path VARCHAR(255) DEFAULT 'img/datadiri.png',
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Insert default tentang
INSERT INTO tentang (nama, deskripsi) VALUES 
('Bagus Arya Wijaya', 'Saya adalah seorang mahasiswa yang memiliki passion di dunia teknologi, khususnya dalam pengembangan aplikasi dan desain. Saya suka belajar hal baru dan mengimplementasikannya dalam proyek nyata.')
ON DUPLICATE KEY UPDATE nama=nama;

-- Tabel proyek
CREATE TABLE IF NOT EXISTS proyek (
    id INT AUTO_INCREMENT PRIMARY KEY,
    judul VARCHAR(100) NOT NULL,
    deskripsi TEXT NOT NULL,
    kategori VARCHAR(50) NOT NULL,
    gambar_path VARCHAR(255) NOT NULL,
    link_page VARCHAR(255) DEFAULT NULL,
    urutan INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Insert default proyek
INSERT INTO proyek (judul, deskripsi, kategori, gambar_path, link_page, urutan) VALUES 
('Inovasi Smart Farming', 'Sistem pengendalian hama padi berbasis energi surya', 'proyek', 'img/Smartpest.png', 'Smartpest.html', 1),
('Pembuatan aplikasi marketplace berbasis java', 'Aplikasi marketplace untuk memudahkan transaksi', 'proyek', 'img/bam teknik bg.png', 'Bam.html', 2),
('Aplikasi Obatin - Mobile', 'Aplikasi mobile untuk manajemen obat', 'proyek', 'img/mobile.png', 'Mobile.html', 3),
('Visualisasi 3D Gedung Rektorat', 'Visualisasi grafika komputer gedung rektorat UNESA', 'proyek', 'img/rektorat.png', 'VisualisasiRektorat.html', 4),
('Sistem Manajemen Kelas', 'Sistem untuk manajemen kelas berbasis web', 'proyek', 'img/manajemen.png', 'ClassManagement.html', 5),
('Laporan Statistika', 'Analisis dan laporan statistika', 'proyek', 'img/hki.png', 'Hki.html', 6)
ON DUPLICATE KEY UPDATE judul=judul;

-- Tabel kontak
CREATE TABLE IF NOT EXISTS kontak (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(100) NOT NULL,
    whatsapp VARCHAR(20) NOT NULL,
    instagram VARCHAR(100) NOT NULL,
    linkedin VARCHAR(100) NOT NULL,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Insert default kontak
INSERT INTO kontak (email, whatsapp, instagram, linkedin) VALUES 
('bagus@email.com', '+6281234567890', '@bagusarya', 'linkedin.com/in/bagus')
ON DUPLICATE KEY UPDATE email=email;

-- Tabel skills
CREATE TABLE IF NOT EXISTS skills (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_skill VARCHAR(50) NOT NULL,
    level INT NOT NULL COMMENT '0-100',
    icon VARCHAR(50) DEFAULT NULL,
    urutan INT DEFAULT 0
);

-- Insert default skills
INSERT INTO skills (nama_skill, level, icon, urutan) VALUES 
('HTML & CSS', 90, 'fa-code', 1),
('JavaScript', 85, 'fa-js', 2),
('Java', 80, 'fa-coffee', 3),
('Python', 75, 'fa-python', 4),
('UI/UX Design', 70, 'fa-palette', 5),
('Database', 80, 'fa-database', 6)
ON DUPLICATE KEY UPDATE nama_skill=nama_skill;