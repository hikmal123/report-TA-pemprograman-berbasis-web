<?php
/**
 * Halaman Skills (Keahlian & Layanan) - Publik
 * Lokasi: root folder (skills.php)
 */

require_once 'includes/config.php';
require_once 'includes/functions.php';

// Konten statis (karena tabel pages dihapus)
$title = 'Keahlian & Layanan';
$content = '<p>Daftar keahlian belum tersedia.</p>';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?> - Website Pribadi Dinamis</title>
    <link rel="stylesheet" href="assets/css/new.css">
</head>
<body>

    <main>
        <section id="skills">
            <h2><?= $title ?></h2>
            <?= $content ?>
            <?php include 'includes/skills_content.php'; ?>  <!-- Sambungkan daftar keahlian -->
        </section>
    </main>

</body>
</html>