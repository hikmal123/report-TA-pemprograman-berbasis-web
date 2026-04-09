<?php
/**
 * Halaman Login Administrator
 * Lokasi: admin/login.php
 */

require_once '../includes/config.php';
require_once '../includes/functions.php';

// Jika sudah login, langsung redirect ke dashboard
if (is_logged_in()) {
    header('Location: index.php');
    exit;
}

// Variabel untuk pesan error
$error = '';

// Proses form login ketika disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = clean_input($_POST['username'] ?? '');
    $password = $_POST['password'] ?? ''; // Jangan di-clean karena untuk verifikasi hash

    if (empty($username) || empty($password)) {
        $error = 'Username dan password harus diisi.';
    } else {
        try {
            // Ambil data user berdasarkan username
            $stmt = $pdo->prepare("
                SELECT id, username, password, full_name, role, is_active 
                FROM users 
                WHERE username = ? AND is_active = 1
                LIMIT 1
            ");
            $stmt->execute([$username]);
            $user = $stmt->fetch();

            // Verifikasi password dan status akun
            if ($user && password_verify($password, $user['password'])) {
                // Login berhasil - simpan informasi ke session
                $_SESSION['admin_id']       = $user['id'];
                $_SESSION['admin_username'] = $user['username'];
                $_SESSION['admin_name']     = $user['full_name'];
                $_SESSION['admin_role']     = $user['role'];

                // Regenerasi session ID untuk keamanan tambahan
                session_regenerate_id(true);

                // Catat waktu login terakhir
                $update = $pdo->prepare("UPDATE users SET last_login = NOW() WHERE id = ?");
                $update->execute([$user['id']]);

                set_flash_message('success', 'Selamat datang kembali, ' . htmlspecialchars($user['full_name']) . '!');
                header('Location: index.php');
                exit;
            } else {
                $error = 'Username atau password salah.';
            }
        } catch (PDOException $e) {
            $error = 'Terjadi kesalahan sistem. Silakan coba lagi nanti.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Administrator - <?= APP_NAME ?></title>
    <link rel="stylesheet" href="../assets/css/new.css">
    <style>
        .login-container {
            max-width: 420px;
            margin: 80px auto;
            padding: 40px 30px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            position: relative;
        }
        .back-btn {
            position: absolute;
            top: 20px;
            left: 20px;
            background: #f8f9fa;
            color: #333;
            padding: 8px 16px;
            border-radius: 30px;
            text-decoration: none;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
        }
        .back-btn:hover {
            background: #e9ecef;
            transform: translateX(-5px);
        }
        .login-header {
            text-align: center;
            margin-bottom: 30px;
        }
        .login-header h1 {
            color: #0072ff;
            font-size: 28px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #333;
        }
        .form-group input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 16px;
        }
        .btn-login {
            width: 100%;
            padding: 14px;
            background: #0072ff;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s;
        }
        .btn-login:hover {
            background: #0056cc;
        }
        .error-message {
            color: #dc3545;
            margin-bottom: 15px;
            text-align: center;
        }
    </style>
</head>
<body style="background:#f0f2f5;">

    <div class="login-container">
        <!-- Tombol Kembali ke Beranda -->
        <a href="../index.php" class="back-btn">
            ← Kembali ke Beranda
        </a>

        <div class="login-header">
            <h1>Login Administrator</h1>
            <p>Akses panel pengelolaan website</p>
        </div>

        <?php if ($error): ?>
            <div class="error-message"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" 
                       value="<?= htmlspecialchars($username ?? '') ?>" 
                       autocomplete="username" required autofocus>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" 
                       autocomplete="current-password" required>
            </div>

            <button type="submit" class="btn-login">Masuk</button>
        </form>
    </div>

</body>
</html>