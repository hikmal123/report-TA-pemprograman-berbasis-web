<?php
require_once __DIR__ . '/../../includes/config.php';
require_once __DIR__ . '/../../includes/functions.php';

require_login(); // Proteksi

// Ambil semua halaman
$stmt = $pdo->query("SELECT id, slug, title, content FROM pages ORDER BY slug");
$pages = $stmt->fetchAll();

// Proses update ketika form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_page'])) {
    $id      = (int)$_POST['id'];
    $title   = clean_input($_POST['title']);
    $content = $_POST['content']; // Tidak di-clean karena ini HTML yang diizinkan admin

    try {
        $stmt = $pdo->prepare("
            UPDATE pages 
            SET title = ?, content = ?, last_updated = NOW()
            WHERE id = ?
        ");
        $stmt->execute([$title, $content, $id]);

        set_flash_message('success', 'Konten halaman berhasil diperbarui!');
        header('Location: edit_pages.php');
        exit;
    } catch (PDOException $e) {
        set_flash_message('danger', 'Gagal memperbarui konten: ' . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Konten Halaman - Admin</title>
    <link rel="stylesheet" href="../../assets/css/new.css">
    <style>
        .page-card { 
            background: #f8f9fa; 
            padding: 20px; 
            margin-bottom: 20px; 
            border-radius: 8px; 
            border-left: 5px solid #0072ff; 
        }
        textarea { 
            width: 100%; 
            min-height: 300px; 
            font-family: monospace; 
            padding: 12px; 
            border: 1px solid #ddd; 
            border-radius: 4px; 
        }
    </style>
</head>
<body>

<div style="max-width:1200px; margin:30px auto; padding:0 20px;">
    <h1 style="color:#0072ff;">Kelola Konten Halaman</h1>
    
    <?php display_flash_message(); ?>

    <?php foreach ($pages as $page): ?>
        <div class="page-card">
            <h3><?= htmlspecialchars($page['title']) ?> (slug: <?= $page['slug'] ?>)</h3>
            
            <form method="POST">
                <input type="hidden" name="id" value="<?= $page['id'] ?>">
                
                <div style="margin:15px 0;">
                    <label><strong>Judul Halaman</strong></label>
                    <input type="text" name="title" value="<?= htmlspecialchars($page['title']) ?>" 
                           style="width:100%; padding:10px; margin-top:5px;" required>
                </div>
                
                <div style="margin:15px 0;">
                    <label><strong>Isi Konten (HTML diizinkan)</strong></label>
                    <textarea name="content"><?= htmlspecialchars($page['content']) ?></textarea>
                </div>
                
                <button type="submit" name="update_page" class="btn" 
                        style="background:#0072ff; color:white; padding:12px 30px; border:none; border-radius:6px; cursor:pointer;">
                    Simpan Perubahan
                </button>
            </form>
        </div>
    <?php endforeach; ?>
</div>

</body>
</html>