<?php
/**
 * Halaman Kontak Publik (contact.php)
 * Lokasi: root folder
 * Form ini akan menyimpan data ke tabel contact_messages
 */

require_once '/config.php';
require_once '/functions.php';

// Ambil konten halaman Contact dari database (jika ada)
$stmt = $pdo->prepare("
    SELECT title, content 
    FROM pages 
    WHERE slug = 'contact' AND is_active = 1 
    LIMIT 1
");
$stmt->execute();
$page = $stmt->fetch();

$title   = $page ? htmlspecialchars($page['title']) : 'Hubungi Saya';
$content = $page ? $page['content'] : '<p>Jika Anda ingin berkolaborasi atau bertanya, silakan isi form di bawah ini.</p>';

// Variabel untuk pesan feedback
$success_message = '';
$error_message = '';

// Proses ketika form dikirim
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['kirim_pesan'])) {
    // Ambil dan sanitasi input
    $name    = trim($_POST['name'] ?? '');
    $email   = trim($_POST['email'] ?? '');
    $subject = trim($_POST['subject'] ?? '');
    $message = trim($_POST['message'] ?? '');

    // Validasi server-side
    $errors = [];
    if (empty($name))     $errors[] = "Nama Lengkap wajib diisi.";
    if (empty($email))    $errors[] = "Alamat Email wajib diisi.";
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Format email tidak valid.";
    if (empty($subject))  $errors[] = "Subjek wajib diisi.";
    if (empty($message))  $errors[] = "Pesan wajib diisi.";

    if (empty($errors)) {
        try {
            // Query INSERT dengan prepared statement (aman dari SQL Injection)
            $stmt_insert = $pdo->prepare("
                INSERT INTO contact_messages 
                (name, email, subject, message, created_at, is_read, reply_status)
                VALUES (?, ?, ?, ?, NOW(), 0, 'pending')
            ");

            $stmt_insert->execute([
                htmlspecialchars($name),     // sanitasi untuk mencegah XSS
                htmlspecialchars($email),
                htmlspecialchars($subject),
                $message                     // pesan boleh mengandung teks biasa/HTML sederhana
            ]);

            $success_message = "Pesan Anda berhasil terkirim! Terima kasih atas masukannya. Kami akan segera membalas.";
        } catch (PDOException $e) {
            $error_message = "Maaf, terjadi kesalahan sistem saat menyimpan pesan. Silakan coba lagi nanti.";
            // Untuk debugging lokal (hapus/comment di produksi): error_log($e->getMessage());
        }
    } else {
        $error_message = implode("<br>", $errors);
    }
}
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

    <main style="max-width: 900px; margin: 40px auto; padding: 0 20px;">
        <section id="contact">
            <h2><?= $title ?></h2>
            <?= $content ?>

            <!-- Tampilkan pesan feedback -->
            <?php if ($success_message): ?>
                <div style="background:#d4edda; color:#155724; padding:15px; border-radius:6px; margin:20px 0;">
                    <strong>Berhasil!</strong> <?= htmlspecialchars($success_message) ?>
                </div>
            <?php endif; ?>

            <?php if ($error_message): ?>
                <div style="background:#f8d7da; color:#721c24; padding:15px; border-radius:6px; margin:20px 0;">
                    <strong>Perhatian!</strong><br><?= htmlspecialchars($error_message) ?>
                </div>
            <?php endif; ?>

            <!-- Form Kontak -->
            <form method="POST" style="background:#f8f9fa; padding:30px; border-radius:12px; box-shadow:0 4px 15px rgba(0,0,0,0.08);">
                <div style="margin-bottom:20px;">
                    <label for="name"><strong>Nama Lengkap</strong> <span style="color:#dc3545;">*</span></label>
                    <input type="text" id="name" name="name" required 
                           value="<?= htmlspecialchars($_POST['name'] ?? '') ?>" 
                           placeholder="Masukkan nama lengkap Anda"
                           style="width:100%; padding:12px; margin-top:8px; border:1px solid #ced4da; border-radius:6px;">
                </div>

                <div style="margin-bottom:20px;">
                    <label for="email"><strong>Alamat Email</strong> <span style="color:#dc3545;">*</span></label>
                    <input type="email" id="email" name="email" required 
                           value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" 
                           placeholder="contoh@email.com"
                           style="width:100%; padding:12px; margin-top:8px; border:1px solid #ced4da; border-radius:6px;">
                </div>

                <div style="margin-bottom:20px;">
                    <label for="subject"><strong>Subjek</strong> <span style="color:#dc3545;">*</span></label>
                    <input type="text" id="subject" name="subject" required 
                           value="<?= htmlspecialchars($_POST['subject'] ?? '') ?>" 
                           placeholder="Topik yang ingin dibahas"
                           style="width:100%; padding:12px; margin-top:8px; border:1px solid #ced4da; border-radius:6px;">
                </div>

                <div style="margin-bottom:20px;">
                    <label for="message"><strong>Pesan Anda</strong> <span style="color:#dc3545;">*</span></label>
                    <textarea id="message" name="message" rows="7" required 
                              placeholder="Tuliskan pesan Anda di sini..."
                              style="width:100%; padding:12px; margin-top:8px; border:1px solid #ced4da; border-radius:6px; resize:vertical;">
                        <?= htmlspecialchars($_POST['message'] ?? '') ?>
                    </textarea>
                </div>

                <button type="submit" name="kirim_pesan" 
                        style="background:#0072ff; color:white; padding:14px 32px; border:none; border-radius:6px; cursor:pointer; font-size:16px; font-weight:600;">
                    Kirim Pesan
                </button>
            </form>
        </section>
    </main>

</body>
</html>