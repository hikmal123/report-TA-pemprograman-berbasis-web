<?php
/**
 * File: includes/config.php
 * Deskripsi: Konfigurasi koneksi database dan pengaturan global aplikasi
 * Author: [Nama Anda]
 * Tanggal: Januari 2026
 */

// ==============================================
//    KONFIGURASI DATABASE - UBAH SESUAI KONDISI
// ==============================================
define('DB_HOST',     'localhost');          // biasanya 'localhost' atau IP server
define('DB_USER',     'root');               // username MySQL (default: root di XAMPP)
define('DB_PASS',     '');                   // password MySQL (kosong di XAMPP lokal)
define('DB_NAME',     'uas'); // nama database yang akan dibuat
define('DB_CHARSET',  'utf8mb4');            // encoding terbaik untuk emoji & karakter spesial

// ==============================================
//    PENGATURAN APLIKASI
// ==============================================
define('BASE_URL',    'http://localhost/uas/'); // Ganti sesuai lokasi folder Anda
define('APP_NAME',    'Website Pribadi Dinamis');
define('APP_VERSION', '1.0.0');

// ==============================================
//    KONEKSI DATABASE DENGAN PDO (METODE TERBAIK)
// ==============================================
try {
    $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
    
    $pdo = new PDO(
        $dsn,
        DB_USER,
        DB_PASS,
        [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ]
    );
    
    // Set timezone agar tanggal sesuai WIB
    $pdo->exec("SET time_zone = '+07:00'");
    
} catch (PDOException $e) {
    // Jika koneksi gagal → tampilkan pesan ramah (jangan tampilkan detail error di production!)
    die("<div style='padding:30px; background:#fee; border:2px solid #c00; border-radius:8px; margin:40px auto; max-width:600px; font-family:sans-serif;'>
        <h2 style='color:#c00;'>Koneksi Database Gagal</h2>
        <p>Mohon maaf, sistem tidak dapat terhubung ke database.<br>
        Silakan hubungi administrator.</p>
        <small>(Error internal hanya ditampilkan di mode development)</small>
    </div>");
    // Untuk development, boleh uncomment baris ini:
    // throw $e;
}

// ==============================================
//    FUNGSI START SESSION DENGAN KEAMANAN DASAR
// ==============================================
if (session_status() === PHP_SESSION_NONE) {
    session_start([
        'cookie_httponly' => true,     // mencegah javascript mengakses cookie session
        'cookie_secure'   => false,    // ubah jadi true jika sudah pakai HTTPS
        'cookie_samesite' => 'Strict'
    ]);
}

// ==============================================
//    VARIABEL WAKTU
// ==============================================
date_default_timezone_set('Asia/Jakarta');
?>