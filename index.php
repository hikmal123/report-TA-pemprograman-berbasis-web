<?php
/**
 * File utama website (index.php) - Penghubung semua halaman
 * Menangani parameter ?page= untuk menghubungkan ke konten yang sesuai
 * Lokasi: root/index.php
 */

require_once 'includes/config.php';
require_once 'includes/functions.php';

// Tentukan halaman default jika tidak ada parameter ?page=
$page_slug = isset($_GET['page']) ? trim($_GET['page']) : 'home';

// Daftar halaman yang diperbolehkan (keamanan: hindari akses file sembarangan)
$allowed_pages = ['home', 'about', 'skills', 'contact'];

// Validasi halaman (fallback ke home jika tidak valid)
if (!in_array($page_slug, $allowed_pages)) {
    $page_slug = 'home';
}

// Tentukan file konten yang akan diinclude berdasarkan page_slug
$content_file = $page_slug . '.php';

// Fallback jika file tidak ada
if (!file_exists($content_file)) {
    $content_file = 'home.php'; // atau buat fallback_content.php jika diperlukan
}

// Tentukan title sederhana (statis, karena tabel pages dihapus)
$title = ucfirst($page_slug) . ' - Website Pribadi Dinamis';

// Variabel untuk navbar aktif
$active_page = $page_slug;
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <link rel="stylesheet" href="assets/css/new.css">
</head>
<body>
    <!-- Hubungkan header -->
    <?php include 'includes/header.php'; ?>

    <!-- Hubungkan navbar -->
    <?php include 'includes/navbar.php'; ?>

    <main style="padding: 40px 20px; max-width: 1200px; margin: 0 auto;">
        <!-- Hubungkan konten halaman utama -->
        <?php include $content_file; ?>
    </main>

    <!-- Hubungkan footer -->
    <?php include 'includes/footer.php'; ?>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const toggleSwitch = document.getElementById('toggleSwitch');
        const sunIcon = document.querySelector('.sun-icon');
        const moonIcon = document.querySelector('.moon-icon');
        const body = document.body;

        // Cek preferensi dark mode dari localStorage
        if (localStorage.getItem('darkMode') === 'enabled') {
            body.classList.add('dark-mode');
            sunIcon.style.display = 'none';
            moonIcon.style.display = 'inline';
        } else {
            sunIcon.style.display = 'inline';
            moonIcon.style.display = 'none';
        }

        // Fungsi toggle dark mode
        function toggleDarkMode() {
            if (body.classList.contains('dark-mode')) {
                body.classList.remove('dark-mode');
                localStorage.setItem('darkMode', 'disabled');
                sunIcon.style.display = 'inline';
                moonIcon.style.display = 'none';
            } else {
                body.classList.add('dark-mode');
                localStorage.setItem('darkMode', 'enabled');
                sunIcon.style.display = 'none';
                moonIcon.style.display = 'inline';
            }
        }

        // Event listener pada tombol
        if (toggleSwitch) {
            toggleSwitch.addEventListener('click', toggleDarkMode);
        }
    });
</script>
</body>
    <!-- Tombol Dark Mode Toggle - Pojok kanan atas -->
    <div class="dark-mode-toggle" style="position: fixed; top: 20px; right: 20px; z-index: 1000;">
        <button id="toggleSwitch" aria-label="Toggle Dark Mode" 
                style="background: rgba(255,255,255,0.2); border: 1px solid rgba(255,255,255,0.4); 
                    border-radius: 50px; padding: 10px 20px; color: white; cursor: pointer; 
                    font-size: 18px; transition: all 0.3s ease; backdrop-filter: blur(5px);">
            <span class="sun-icon">☀️</span>
            <span class="moon-icon" style="display: none;">🌙</span>
        </button>
    </div>
</html>