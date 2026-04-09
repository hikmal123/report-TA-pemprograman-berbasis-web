<?php
/**
 * File: includes/functions.php
 * Kumpulan fungsi bantu umum untuk seluruh aplikasi
 */

// ==============================================
//    1. Sanitasi Input Pengguna (Keamanan Dasar)
// ==============================================
function clean_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    return $data;
}

function clean_array($array) {
    return array_map('clean_input', $array);
}

// ==============================================
//    2. Alert Bootstrap Sederhana
// ==============================================
function set_flash_message($type, $message) {
    $_SESSION['flash'] = [
        'type'    => $type,          // success, danger, warning, info
        'message' => $message
    ];
}

function display_flash_message() {
    if (isset($_SESSION['flash'])) {
        $flash = $_SESSION['flash'];
        echo "<div class='alert alert-{$flash['type']} alert-dismissible fade show' role='alert' style='margin:20px 0;'>
                {$flash['message']}
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
              </div>";
        unset($_SESSION['flash']);
    }
}

// ==============================================
//    3. Cek apakah user sudah login sebagai admin
// ==============================================
function is_logged_in() {
    return isset($_SESSION['admin_id']) && !empty($_SESSION['admin_id']);
}

function require_login() {
    if (!is_logged_in()) {
        set_flash_message('danger', 'Anda harus login terlebih dahulu sebagai administrator.');
        header('Location: ' . BASE_URL . 'admin/login.php');
        exit;
    }
}

// ==============================================
//    4. Fungsi debug sederhana (hanya untuk development)
// ==============================================
function dd($var) {
    echo '<pre style="background:#000;color:#0f0;padding:15px;border-radius:8px;">';
    var_dump($var);
    echo '</pre>';
    exit;
}

// ==============================================
//    5. Fungsi redirect dengan flash message
// ==============================================
function redirect_with_message($url, $type, $message) {
    set_flash_message($type, $message);
    header("Location: $url");
    exit;
}
?>