<?php
/**
 * Proses Logout Administrator
 * Lokasi: admin/logout.php
 */

require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/functions.php';

// Hapus semua data session
$_SESSION = array();

// Hapus cookie session jika ada
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Hancurkan session sepenuhnya
session_destroy();

// Redirect ke halaman login dengan pesan sukses
set_flash_message('success', 'Anda telah berhasil logout.');
header('Location: login.php');
exit;
?>