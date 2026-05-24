<?php
require_once 'config.php';

// Reset password admin menjadi admin123
$username = 'admin';
$password = 'admin123';
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Hapus admin lama jika ada
$pdo->exec("DELETE FROM admin WHERE username = 'admin'");

// Insert admin baru
$stmt = $pdo->prepare("INSERT INTO admin (username, password) VALUES (?, ?)");
$stmt->execute([$username, $hashed_password]);

echo "Password admin berhasil direset!";
echo "<br><br>";
echo "Username: <b>admin</b>";
echo "<br>";
echo "Password: <b>admin123</b>";
echo "<br><br>";
echo "<a href='admin/login.php'>Login ke Admin Panel</a>";
?>