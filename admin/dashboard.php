<?php
require_once '../config.php';
require_once 'auth.php';

// Hitung jumlah data untuk dashboard
$stmt = $pdo->query("SELECT COUNT(*) as total FROM proyek");
$total_proyek = $stmt->fetch()['total'];

$stmt = $pdo->query("SELECT COUNT(*) as total FROM skills");
$total_skills = $stmt->fetch()['total'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin | Siapaku</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Poppins', sans-serif; background: #f5f5f5; }
        .sidebar {
            position: fixed; top: 0; left: 0; width: 250px; height: 100vh;
            background: linear-gradient(180deg, #B22222 0%, #8B0000 100%);
            padding: 20px; color: white;
        }
        .logo { display: flex; align-items: center; gap: 10px; margin-bottom: 30px; }
        .logo img { width: 40px; }
        .logo h2 { font-size: 1.2rem; }
        .nav-item {
            display: flex; align-items: center; gap: 12px; padding: 12px 15px;
            color: rgba(255,255,255,0.8); text-decoration: none;
            border-radius: 10px; margin-bottom: 8px; transition: 0.3s;
        }
        .nav-item:hover, .nav-item.active { background: rgba(255,255,255,0.15); color: white; }
        .nav-item i { width: 20px; }
        .main-content { margin-left: 250px; padding: 30px; }
        .header {
            display: flex; justify-content: space-between; align-items: center;
            margin-bottom: 30px;
        }
        .header h1 { color: #222; font-size: 1.8rem; }
        .logout-btn {
            background: #B22222; color: white; padding: 10px 20px;
            border-radius: 10px; text-decoration: none; display: inline-flex; align-items: center; gap: 8px;
        }
        .logout-btn:hover { background: #8B0000; }
        .stats-grid {
            display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px; margin-bottom: 30px;
        }
        .stat-card {
            background: white; padding: 25px; border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.08);
        }
        .stat-card h3 { color: #666; font-size: 0.9rem; font-weight: 500; margin-bottom: 10px; }
        .stat-card .number { font-size: 2.5rem; font-weight: 700; color: #B22222; }
        .quick-actions { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; }
        .action-btn {
            background: white; border: 2px solid #E0E0E0; padding: 20px; border-radius: 12px;
            text-align: center; text-decoration: none; color: #222;
            transition: 0.3s;
        }
        .action-btn:hover { border-color: #B22222; transform: translateY(-3px); }
        .action-btn i { font-size: 2rem; color: #B22222; margin-bottom: 10px; }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="logo">
            <img src="../img/br.png" alt="Logo">
            <h2>Blackrose Admin</h2>
        </div>
        <a href="dashboard.php" class="nav-item active">
            <i class="fas fa-home"></i> Dashboard
        </a>
        <a href="proyek.php" class="nav-item">
            <i class="fas fa-folder-open"></i> Proyek
        </a>
        <a href="tentang.php" class="nav-item">
            <i class="fas fa-user"></i> Tentang Saya
        </a>
        <a href="skills.php" class="nav-item">
            <i class="fas fa-code"></i> Skills
        </a>
        <a href="kontak.php" class="nav-item">
            <i class="fas fa-envelope"></i> Kontak
        </a>
    </div>
    <div class="main-content">
        <div class="header">
            <h1>Halo, <?php echo $_SESSION['admin_username']; ?>!</h1>
            <a href="logout.php" class="logout-btn">
                <i class="fas fa-sign-out-alt"></i> Keluar
            </a>
        </div>
        <div class="stats-grid">
            <div class="stat-card">
                <h3>Total Proyek</h3>
                <div class="number"><?php echo $total_proyek; ?></div>
            </div>
            <div class="stat-card">
                <h3>Total Skills</h3>
                <div class="number"><?php echo $total_skills; ?></div>
            </div>
        </div>
        <h2 style="margin-bottom: 20px; color: #333;">Aksi Cepat</h2>
        <div class="quick-actions">
            <a href="proyek.php?action=tambah" class="action-btn">
                <i class="fas fa-plus"></i>
                <div>Tambah Proyek</div>
            </a>
            <a href="skills.php?action=tambah" class="action-btn">
                <i class="fas fa-star"></i>
                <div>Tambah Skill</div>
            </a>
            <a href="../index.php" class="action-btn" target="_blank">
                <i class="fas fa-external-link-alt"></i>
                <div>Lihat Website</div>
            </a>
        </div>
    </div>
</body>
</html>