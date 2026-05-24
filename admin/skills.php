<?php
require_once '../config.php';
require_once 'auth.php';

$message = '';
$action = $_GET['action'] ?? '';
$id = $_GET['id'] ?? '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_skill = clean_input($_POST['nama_skill']);
    $level = intval($_POST['level']);
    $icon = clean_input($_POST['icon']);
    $urutan = intval($_POST['urutan']);

    if ($action == 'tambah') {
        $stmt = $pdo->prepare("INSERT INTO skills (nama_skill, level, icon, urutan) VALUES (?, ?, ?, ?)");
        $stmt->execute([$nama_skill, $level, $icon, $urutan]);
        $message = 'Skill berhasil ditambahkan!';
    } elseif ($action == 'edit' && $id) {
        $stmt = $pdo->prepare("UPDATE skills SET nama_skill=?, level=?, icon=?, urutan=? WHERE id=?");
        $stmt->execute([$nama_skill, $level, $icon, $urutan, $id]);
        $message = 'Skill berhasil diperbarui!';
    }
}

if ($action == 'hapus' && $id) {
    $stmt = $pdo->prepare("DELETE FROM skills WHERE id=?");
    $stmt->execute([$id]);
    $message = 'Skill berhasil dihapus!';
}

$skill_edit = null;
if ($action == 'edit' && $id) {
    $stmt = $pdo->prepare("SELECT * FROM skills WHERE id=?");
    $stmt->execute([$id]);
    $skill_edit = $stmt->fetch();
}

$stmt = $pdo->query("SELECT * FROM skills ORDER BY urutan ASC, id DESC");
$skills_list = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Skills | Admin</title>
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
        .btn-primary { background: #B22222; color: white; padding: 10px 20px; border: none; border-radius: 10px; cursor: pointer; text-decoration: none; display: inline-block; }
        .btn-primary:hover { background: #8B0000; }
        .card { background: white; border-radius: 15px; padding: 25px; box-shadow: 0 5px 20px rgba(0,0,0,0.08); margin-bottom: 25px; }
        .message { background: #E8F5E9; color: #2E7D32; padding: 15px; border-radius: 10px; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 15px; text-align: left; border-bottom: 1px solid #eee; }
        th { background: #fafafa; color: #666; font-weight: 600; }
        .btn-sm { padding: 6px 12px; border-radius: 6px; text-decoration: none; font-size: 0.85rem; }
        .btn-edit { background: #FFF3E0; color: #E65100; }
        .btn-hapus { background: #FFEBEE; color: #C62828; }
        .form-group { margin-bottom: 20px; }
        label { display: block; margin-bottom: 8px; color: #555; font-weight: 500; }
        input, select { width: 100%; padding: 12px; border: 2px solid #E0E0E0; border-radius: 10px; font-family: 'Poppins', sans-serif; }
        input:focus, select:focus { outline: none; border-color: #B22222; }
        .back-link { display: inline-block; margin-bottom: 20px; color: #B22222; text-decoration: none; }
        .progress-bar { height: 8px; background: #eee; border-radius: 4px; overflow: hidden; }
        .progress-fill { height: 100%; background: linear-gradient(90deg, #B22222, #8B0000); border-radius: 4px; }
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
        <a href="tentang.php" class="nav-item"><i class="fas fa-user"></i> Tentang Saya</a>
        <a href="skills.php" class="nav-item active"><i class="fas fa-code"></i> Skills</a>
        <a href="kontak.php" class="nav-item"><i class="fas fa-envelope"></i> Kontak</a>
    </div>
    <div class="main-content">
        <div class="header">
            <h1><?php echo $action == 'tambah' ? 'Tambah Skill' : ($action == 'edit' ? 'Edit Skill' : 'Skills'); ?></h1>
            <?php if (!$action): ?>
                <a href="?action=tambah" class="btn-primary"><i class="fas fa-plus"></i> Tambah Skill</a>
            <?php endif; ?>
        </div>
        <?php if ($message): ?>
            <div class="message"><?php echo $message; ?></div>
        <?php endif; ?>
        <?php if ($action == 'tambah' || $action == 'edit'): ?>
            <div class="card">
                <a href="skills.php" class="back-link"><i class="fas fa-arrow-left"></i> Kembali</a>
                <form method="POST">
                    <div class="form-group">
                        <label>Nama Skill</label>
                        <input type="text" name="nama_skill" required value="<?php echo $skill_edit['nama_skill'] ?? ''; ?>">
                    </div>
                    <div class="form-group">
                        <label>Level (0-100)</label>
                        <input type="number" name="level" min="0" max="100" required value="<?php echo $skill_edit['level'] ?? 0; ?>">
                    </div>
                    <div class="form-group">
                        <label>Icon (Font Awesome, contoh: fa-code)</label>
                        <input type="text" name="icon" value="<?php echo $skill_edit['icon'] ?? ''; ?>">
                    </div>
                    <div class="form-group">
                        <label>Urutan</label>
                        <input type="number" name="urutan" value="<?php echo $skill_edit['urutan'] ?? 0; ?>">
                    </div>
                    <button type="submit" class="btn-primary">Simpan</button>
                </form>
            </div>
        <?php else: ?>
            <div class="card">
                <table>
                    <thead>
                        <tr>
                            <th>Icon</th>
                            <th>Nama Skill</th>
                            <th>Level</th>
                            <th>Urutan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($skills_list as $skill): ?>
                            <tr>
                                <td><i class="fas <?php echo $skill['icon']; ?>" style="color: #B22222; font-size: 1.5rem;"></i></td>
                                <td><?php echo htmlspecialchars($skill['nama_skill']); ?></td>
                                <td>
                                    <div style="margin-bottom: 5px; font-weight: 600;"><?php echo $skill['level']; ?>%</div>
                                    <div class="progress-bar"><div class="progress-fill" style="width: <?php echo $skill['level']; ?>%;"></div></div>
                                </td>
                                <td><?php echo $skill['urutan']; ?></td>
                                <td>
                                    <a href="?action=edit&id=<?php echo $skill['id']; ?>" class="btn-sm btn-edit"><i class="fas fa-edit"></i> Edit</a>
                                    <a href="?action=hapus&id=<?php echo $skill['id']; ?>" class="btn-sm btn-hapus" onclick="return confirm('Yakin?')"><i class="fas fa-trash"></i> Hapus</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>