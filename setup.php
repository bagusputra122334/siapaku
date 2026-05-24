<?php
// File setup otomatis database Siapaku
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Koneksi ke MySQL tanpa database terlebih dahulu
try {
    $pdo_temp = new PDO(
        "mysql:host=localhost;charset=utf8mb4",
        "root",
        "",
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
        ]
    );
} catch(PDOException $e) {
    die("Gagal koneksi ke MySQL: " . $e->getMessage());
}

echo "<h1>Setup Database Siapaku</h1>";

// 1. Buat database
echo "<p>1. Membuat database 'siapaku_db'...</p>";
$pdo_temp->exec("CREATE DATABASE IF NOT EXISTS siapaku_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
$pdo_temp->exec("USE siapaku_db");
echo "<p style='color:green;'>✓ Database siap!</p>";

// 2. Buat tabel admin
echo "<p>2. Membuat tabel 'admin'...</p>";
$pdo_temp->exec("CREATE TABLE IF NOT EXISTS admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)");
echo "<p style='color:green;'>✓ Tabel admin siap!</p>";

// 3. Buat tabel tentang
echo "<p>3. Membuat tabel 'tentang'...</p>";
$pdo_temp->exec("CREATE TABLE IF NOT EXISTS tentang (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    deskripsi TEXT NOT NULL,
    foto_path VARCHAR(255) DEFAULT 'img/datadiri.png',
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)");
echo "<p style='color:green;'>✓ Tabel tentang siap!</p>";

// 4. Buat tabel proyek
echo "<p>4. Membuat tabel 'proyek'...</p>";
$pdo_temp->exec("CREATE TABLE IF NOT EXISTS proyek (
    id INT AUTO_INCREMENT PRIMARY KEY,
    judul VARCHAR(100) NOT NULL,
    deskripsi TEXT NOT NULL,
    kategori VARCHAR(50) NOT NULL,
    gambar_path VARCHAR(255) NOT NULL,
    link_page VARCHAR(255) DEFAULT NULL,
    urutan INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)");
echo "<p style='color:green;'>✓ Tabel proyek siap!</p>";

// 5. Buat tabel kontak
echo "<p>5. Membuat tabel 'kontak'...</p>";
$pdo_temp->exec("CREATE TABLE IF NOT EXISTS kontak (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(100) NOT NULL,
    whatsapp VARCHAR(20) NOT NULL,
    instagram VARCHAR(100) NOT NULL,
    linkedin VARCHAR(100) NOT NULL,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)");
echo "<p style='color:green;'>✓ Tabel kontak siap!</p>";

// 6. Buat tabel skills
echo "<p>6. Membuat tabel 'skills'...</p>";
$pdo_temp->exec("CREATE TABLE IF NOT EXISTS skills (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_skill VARCHAR(50) NOT NULL,
    level INT NOT NULL COMMENT '0-100',
    icon VARCHAR(50) DEFAULT NULL,
    urutan INT DEFAULT 0
)");
echo "<p style='color:green;'>✓ Tabel skills siap!</p>";

// 7. Insert data default admin
echo "<p>7. Insert data admin default...</p>";
$username = 'admin';
$password = 'admin123';
$hashed_password = password_hash($password, PASSWORD_DEFAULT);
// Hapus admin lama
$pdo_temp->exec("DELETE FROM admin");
$stmt = $pdo_temp->prepare("INSERT INTO admin (username, password) VALUES (?, ?)");
$stmt->execute([$username, $hashed_password]);
echo "<p style='color:green;'>✓ Admin siap!</p>";

// 8. Insert data default tentang
echo "<p>8. Insert data tentang default...</p>";
$pdo_temp->exec("DELETE FROM tentang");
$stmt = $pdo_temp->prepare("INSERT INTO tentang (nama, deskripsi) VALUES (?, ?)");
$stmt->execute(['Bagus Arya Wijaya', 'Saya adalah seorang mahasiswa yang memiliki passion di dunia teknologi, khususnya dalam pengembangan aplikasi dan desain. Saya suka belajar hal baru dan mengimplementasikannya dalam proyek nyata.']);
echo "<p style='color:green;'>✓ Data tentang siap!</p>";

// 9. Insert data default kontak
echo "<p>9. Insert data kontak default...</p>";
$pdo_temp->exec("DELETE FROM kontak");
$stmt = $pdo_temp->prepare("INSERT INTO kontak (email, whatsapp, instagram, linkedin) VALUES (?, ?, ?, ?)");
$stmt->execute(['bagus@email.com', '+6281234567890', '@bagusarya', 'linkedin.com/in/bagus']);
echo "<p style='color:green;'>✓ Data kontak siap!</p>";

// 10. Insert data default skills
echo "<p>10. Insert data skills default...</p>";
$pdo_temp->exec("DELETE FROM skills");
$skills_default = [
    ['HTML & CSS', 90, 'fa-code', 1],
    ['JavaScript', 85, 'fa-js', 2],
    ['Java', 80, 'fa-coffee', 3],
    ['Python', 75, 'fa-python', 4],
    ['UI/UX Design', 70, 'fa-palette', 5],
    ['Database', 80, 'fa-database', 6]
];
$stmt = $pdo_temp->prepare("INSERT INTO skills (nama_skill, level, icon, urutan) VALUES (?, ?, ?, ?)");
foreach ($skills_default as $skill) {
    $stmt->execute($skill);
}
echo "<p style='color:green;'>✓ Data skills siap!</p>";

// 11. Insert data default proyek
echo "<p>11. Insert data proyek default...</p>";
$pdo_temp->exec("DELETE FROM proyek");
$proyek_default = [
    ['Inovasi Smart Farming', 'Sistem pengendalian hama padi berbasis energi surya', 'proyek', 'img/Smartpest.png', 'Smartpest.html', 1],
    ['Pembuatan aplikasi marketplace berbasis java', 'Aplikasi marketplace untuk memudahkan transaksi', 'proyek', 'img/bam teknik bg.png', 'Bam.html', 2],
    ['Aplikasi Obatin - Mobile', 'Aplikasi mobile untuk manajemen obat', 'proyek', 'img/mobile.png', 'Mobile.html', 3],
    ['Visualisasi 3D Gedung Rektorat', 'Visualisasi grafika komputer gedung rektorat UNESA', 'proyek', 'img/rektorat.png', 'VisualisasiRektorat.html', 4],
    ['Sistem Manajemen Kelas', 'Sistem untuk manajemen kelas berbasis web', 'proyek', 'img/manajemen.png', 'ClassManagement.html', 5],
    ['Laporan Statistika', 'Analisis dan laporan statistika', 'proyek', 'img/hki.png', 'Hki.html', 6]
];
$stmt = $pdo_temp->prepare("INSERT INTO proyek (judul, deskripsi, kategori, gambar_path, link_page, urutan) VALUES (?, ?, ?, ?, ?, ?)");
foreach ($proyek_default as $proyek) {
    $stmt->execute($proyek);
}
echo "<p style='color:green;'>✓ Data proyek siap!</p>";

echo "<hr>";
echo "<h2 style='color: #2E7D32;'>✓ SEMUA BERHASIL!</h2>";
echo "<p><strong>Login Admin:</strong></p>";
echo "<p>Username: <b>admin</b></p>";
echo "<p>Password: <b>admin123</b></p>";
echo "<br>";
echo "<a href='index.php' style='background: #B22222; color: white; padding: 10px 20px; text-decoration: none; border-radius: 8px;'>← Ke Halaman Utama</a> ";
echo "<a href='admin/login.php' style='background: #2E7D32; color: white; padding: 10px 20px; text-decoration: none; border-radius: 8px; margin-left: 10px;'>Login Admin →</a>";
?>