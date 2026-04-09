<?php
/**
 * Dashboard Administrator
 * Lokasi: admin/index.php
 * Halaman utama setelah login berhasil
 */

require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/functions.php';

// **Proteksi: Hanya admin yang sudah login boleh akses halaman ini**
require_login();  // Fungsi ini sudah ada di functions.php

// Ambil informasi user dari session
$admin_name   = $_SESSION['admin_name']   ?? 'Administrator';
$admin_role   = $_SESSION['admin_role']   ?? 'admin';
$admin_id     = $_SESSION['admin_id']     ?? null;

// (Opsional) Ambil data tambahan dari database jika diperlukan
try {
    $stmt = $pdo->prepare("
        SELECT last_login 
        FROM users 
        WHERE id = ?
    ");
    $stmt->execute([$admin_id]);
    $user_data = $stmt->fetch();
    $last_login = $user_data['last_login'] ?? 'Belum ada data';
} catch (PDOException $e) {
    $last_login = 'Tidak dapat memuat data';
}

// Tambahan: Ambil daftar pesan masuk dari tabel contact_messages
try {
    $stmt_messages = $pdo->prepare("
        SELECT id, name, email, subject, message, created_at, is_read, reply_status 
        FROM contact_messages 
        ORDER BY created_at DESC 
        LIMIT 10  -- Batasi 10 pesan terbaru untuk performa
    ");
    $stmt_messages->execute();
    $messages = $stmt_messages->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $messages = [];
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - <?= APP_NAME ?></title>
    <link rel="stylesheet" href="../assets/css/new.css">
    <style>
        .dashboard-container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 20px;
        }
        .welcome-card {
            background: linear-gradient(to right, #0072ff, #00c6ff);
            color: white;
            padding: 40px 30px;
            border-radius: 12px;
            margin-bottom: 30px;
            box-shadow: 0 10px 30px rgba(0,114,255,0.2);
        }
        .welcome-card h1 {
            margin: 0;
            font-size: 32px;
        }
        .menu-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
        }
        .menu-card {
            background: white;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
            transition: transform 0.2s, box-shadow 0.2s;
            text-decoration: none;
            color: #333;
        }
        .menu-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.12);
        }
        .menu-card h3 {
            color: #0072ff;
            margin: 0 0 15px;
        }
        .logout-btn {
            display: inline-block;
            margin-top: 30px;
            padding: 12px 30px;
            background: #dc3545;
            color: white;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 600;
        }
        .logout-btn:hover {
            background: #c82333;
        }

        /* Tambahan untuk bagian pesan masuk */
        .messages-section {
            margin-top: 50px;
        }
        .messages-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        }
        .messages-table th, .messages-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        .messages-table th {
            background: #0072ff;
            color: white;
            font-weight: 600;
        }
        .messages-table tr:hover {
            background: #f8f9fa;
        }
        .status-pending {
            color: #ffc107;
            font-weight: bold;
        }
        .status-replied {
            color: #28a745;
            font-weight: bold;
        }
        .status-ignored {
            color: #dc3545;
            font-weight: bold;
        }
        .message-preview {
            max-width: 300px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
    </style>
</head>
<body>

    <div class="dashboard-container">
        <div class="welcome-card">
            <h1>Selamat Datang, <?= htmlspecialchars($admin_name) ?>!</h1>
            <p>Anda masuk sebagai <strong><?= htmlspecialchars($admin_role) ?></strong></p>
            <p><small>Terakhir login: <?= htmlspecialchars($last_login) ?></small></p>
        </div>

        <h2 style="margin: 30px 0 20px; color: #0072ff;">Menu Pengelolaan</h2>

        <div class="menu-grid">
            <a href="#" class="menu-card">
                <h3>Edit Konten Beranda</h3>
                <p>Kelola teks, gambar, dan bagian utama halaman depan.</p>
            </a>

            <a href="#" class="menu-card">
                <h3>Edit Bagian About</h3>
                <p>Ubah profil, pengalaman, dan informasi tentang Anda.</p>
            </a>

            <a href="#" class="menu-card">
                <h3>Manajemen Metrik Kinerja</h3>
                <p>Update data kecepatan halaman, skor SEO, dan metrik lainnya.</p>
            </a>

            <a href="#pesan-masuk" class="menu-card">
            <h3>Pesan Masuk</h3>
            <p>Lihat dan kelola pesan dari pengunjung melalui form kontak.</p>
            </a>
        </div>

        <!-- Tambahan baru: Bagian melihat pesan masuk -->
        <div class="messages-section" id= "pesan-masuk">
            <h2 style="margin: 30px 0 20px; color: #0072ff;">Pesan Masuk Terbaru</h2>

            <?php if (empty($messages)): ?>
                <p style="text-align: center; color: #6c757d; font-style: italic;">Tidak ada pesan masuk saat ini.</p>
            <?php else: ?>
                <table class="messages-table">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Subjek</th>
                            <th>Pesan (Preview)</th>
                            <th>Waktu</th>
                            <th>Dibaca</th>
                            <th>Status Balasan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($messages as $msg): ?>
                            <tr>
                                <td><?= htmlspecialchars($msg['name']) ?></td>
                                <td><?= htmlspecialchars($msg['email']) ?></td>
                                <td><?= htmlspecialchars($msg['subject']) ?></td>
                                <td class="message-preview"><?= htmlspecialchars(substr($msg['message'], 0, 100)) ?>...</td>
                                <td><?= htmlspecialchars(date('d M Y H:i', strtotime($msg['created_at']))) ?></td>
                                <td><?= $msg['is_read'] ? 'Ya' : 'Belum' ?></td>
                                <td class="status-<?= strtolower($msg['reply_status']) ?>"><?= htmlspecialchars(ucfirst($msg['reply_status'])) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>

        <a href="logout.php" class="logout-btn">Logout</a>
    </div>

</body>
</html>