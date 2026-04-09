<?php
/**
 * Halaman Kontak Publik (contact.php)
 * Lokasi: root folder
 * Form ini akan menyimpan data ke tabel contact_messages
 */

require_once 'includes/config.php';
require_once 'includes/functions.php';

// Konten pengantar statis (karena tabel pages dihapus)
$title = 'Hubungi Saya';
$content = '<p>Jika Anda ingin berkolaborasi atau bertanya, silakan isi form di bawah ini.</p>';

// Variabel untuk pesan feedback
$success_message = '';
$error_message = '';

// Proses form
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['kirim_pesan'])) {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $subject = trim($_POST['subject'] ?? '');
    $message = trim($_POST['message'] ?? '');

    $errors = [];
    if (empty($name)) $errors[] = "Nama Lengkap wajib diisi.";
    if (empty($email)) $errors[] = "Alamat Email wajib diisi.";
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Format email tidak valid.";
    if (empty($subject)) $errors[] = "Subjek wajib diisi.";
    if (empty($message)) $errors[] = "Pesan wajib diisi.";

    if (empty($errors)) {
        try {
            $stmt = $pdo->prepare("
                INSERT INTO contact_messages 
                (name, email, subject, message, created_at, is_read, reply_status)
                VALUES (?, ?, ?, ?, NOW(), 0, 'pending')
            ");

            $stmt->execute([
                htmlspecialchars($name),
                htmlspecialchars($email),
                htmlspecialchars($subject),
                $message
            ]);

            $success_message = "Pesan berhasil dikirim!";
        } catch (PDOException $e) {
            $error_message = "Gagal menyimpan pesan.";
        }
    } else {
        $error_message = implode("<br>", $errors);
    }
}
?>

<section id="contact">
    <h2><?= $title ?></h2>
    <?= $content ?>

    <!-- Form Kontak -->
    <form method="POST">
        <label for="name">Nama Lengkap</label>
        <input type="text" id="name" name="name" required>

        <label for="email">Email</label>
        <input type="email" id="email" name="email" required>

        <label for="subject">Subjek</label>
        <input type="text" id="subject" name="subject" required>

        <label for="message">Pesan</label>
        <textarea id="message" name="message" required></textarea>

        <button type="submit" name="kirim_pesan">Kirim Pesan</button>
    </form>

    <?php if ($success_message): ?>
        <p><?= $success_message ?></p>
    <?php endif; ?>

    <?php if ($error_message): ?>
        <p><?= $error_message ?></p>
    <?php endif; ?>
</section>