<?php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/functions.php';

require_login();

// Ambil semua metrik
$metrics = $pdo->query("SELECT * FROM performance_metrics ORDER BY sort_order")->fetchAll();

// Proses tambah
if (isset($_POST['add_metric'])) {
    $category = clean_input($_POST['category']);
    $target   = clean_input($_POST['target']);
    $achieved = clean_input($_POST['achieved']);
    $status   = clean_input($_POST['status']);
    $sort     = (int)$_POST['sort_order'];

    $stmt = $pdo->prepare("
        INSERT INTO performance_metrics 
        (category, target, achieved, status, sort_order) 
        VALUES (?, ?, ?, ?, ?)
    ");
    $stmt->execute([$category, $target, $achieved, $status, $sort]);
    set_flash_message('success', 'Metrik baru berhasil ditambahkan!');
    header('Location: metrics.php');
    exit;
}

// Proses update & delete (tambahkan logika serupa seperti edit_pages.php)
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Manajemen Metrik Kinerja</title>
    <link rel="stylesheet" href="../assets/css/new.css">
</head>
<body>

<div style="max-width:1200px; margin:30px auto; padding:0 20px;">
    <h1>Manajemen Metrik Kinerja</h1>
    
    <?php display_flash_message(); ?>

    <!-- Form Tambah Baru -->
    <h3>Tambah Metrik Baru</h3>
    <form method="POST">
        <input type="text" name="category" placeholder="Kategori" required style="width:30%; padding:8px;">
        <input type="text" name="target" placeholder="Target" required style="width:20%; padding:8px;">
        <input type="text" name="achieved" placeholder="Tercapai" required style="width:20%; padding:8px;">
        <input type="text" name="status" placeholder="Status" required style="width:20%; padding:8px;">
        <input type="number" name="sort_order" placeholder="Urutan" value="0" style="width:10%; padding:8px;">
        <button type="submit" name="add_metric">Tambah</button>
    </form>

    <hr>

    <!-- Daftar Metrik -->
    <table style="width:100%; border-collapse:collapse; margin-top:20px;">
        <thead>
            <tr style="background:#0072ff; color:white;">
                <th>Kategori</th>
                <th>Target</th>
                <th>Tercapai</th>
                <th>Status</th>
                <th>Urutan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($metrics as $m): ?>
            <tr style="border-bottom:1px solid #ddd;">
                <td><?= htmlspecialchars($m['category']) ?></td>
                <td><?= htmlspecialchars($m['target']) ?></td>
                <td><?= htmlspecialchars($m['achieved']) ?></td>
                <td><?= htmlspecialchars($m['status']) ?></td>
                <td><?= $m['sort_order'] ?></td>
                <td>
                    <a href="#" style="color:#0072ff;">Edit</a> | 
                    <a href="#" style="color:#dc3545;">Hapus</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

</body>
</html>