<?php
require_once '../config.php';
require_once 'auth.php';

$message = '';

// Get tentang data
$stmt = $pdo->query("SELECT * FROM tentang LIMIT 1");
$tentang = $stmt->fetch();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = clean_input($_POST['nama']);
    $deskripsi = clean_input($_POST['deskripsi']);
    $foto_path = clean_input($_POST['foto_path']);

    if ($tentang) {
        $stmt = $pdo->prepare("UPDATE tentang SET nama=?, deskripsi=?, foto_path=? WHERE id=?");
        $stmt->execute([$nama, $deskripsi, $foto_path, $tentang['id']]);
    } else {
        $stmt = $pdo->prepare("INSERT INTO tentang (nama, deskripsi, foto_path) VALUES (?, ?, ?)");
        $stmt->execute([$nama, $deskripsi, $foto_path]);
    }
    $message = 'Data tentang berhasil diperbarui!';
    $stmt = $pdo->query("SELECT * FROM tentang LIMIT 1");
    $tentang = $stmt->fetch();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tentang Saya | Admin</title>
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
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
        .header h1 { color: #222; }
        .card { background: white; border-radius: 15px; padding: 30px; box-shadow: 0 5px 20px rgba(0,0,0,0.08); }
        .message { background: #E8F5E9; color: #2E7D32; padding: 15px; border-radius: 10px; margin-bottom: 20px; }
        .form-group { margin-bottom: 20px; }
        label { display: block; margin-bottom: 8px; color: #555; font-weight: 500; }
        input, textarea { width: 100%; padding: 12px; border: 2px solid #E0E0E0; border-radius: 10px; font-family: 'Poppins', sans-serif; }
        textarea { min-height: 150px; resize: vertical; }
        input:focus, textarea:focus { outline: none; border-color: #B22222; }
        .btn-primary { background: #B22222; color: white; padding: 12px 25px; border: none; border-radius: 10px; cursor: pointer; font-size: 1rem; }
        .btn-primary:hover { background: #8B0000; }
        .preview { display: flex; align-items: center; gap: 20px; margin-bottom: 25px; }
        .preview img { width: 100px; height: 100px; object-fit: cover; border-radius: 50%; border: 3px solid #B22222; }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="logo">
            <img src="../img/br.png" alt="Logo">
            <h2>Blackrose Admin</h2>
        </div>
        <a href="dashboard.php" class="nav-item"><i class="fas fa-home"></i> Dashboard</a>
        <a href="proyek.php" class="nav-item"><i class="fas fa-folder-open"></i> Proyek</a>
        <a href="tentang.php" class="nav-item active"><i class="fas fa-user"></i> Tentang Saya</a>
        <a href="skills.php" class="nav-item"><i class="fas fa-code"></i> Skills</a>
        <a href="kontak.php" class="nav-item"><i class="fas fa-envelope"></i> Kontak</a>
    </div>
    <div class="main-content">
        <div class="header">
            <h1>Tentang Saya</h1>
        </div>
        <?php if ($message): ?>
            <div class="message"><?php echo $message; ?></div>
        <?php endif; ?>
        <div class="card">
            <?php if ($tentang): ?>
                <div class="preview">
                    <img src="../<?php echo $tentang['foto_path']; ?>" alt="Foto">
                </div>
            <?php endif; ?>
            <form method="POST">
                <div class="form-group">
                    <label>Nama</label>
                    <input type="text" name="nama" required value="<?php echo $tentang['nama'] ?? ''; ?>">
                </div>
                <div class="form-group">
                    <label>Deskripsi</label>
                    <textarea name="deskripsi" required><?php echo $tentang['deskripsi'] ?? ''; ?></textarea>
                </div>
                <div class="form-group">
                    <label>Path Foto (contoh: img/datadiri.png)</label>
                    <input type="text" name="foto_path" value="<?php echo $tentang['foto_path'] ?? 'img/datadiri.png'; ?>">
                </div>
                <button type="submit" class="btn-primary">Simpan Perubahan</button>
            </form>
        </div>
    </div>
</body>
</html>