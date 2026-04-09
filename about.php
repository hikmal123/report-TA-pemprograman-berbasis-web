<?php
/**
 * Halaman About (Tentang Saya) - Publik
 * Lokasi: root folder (about.php)
 */

require_once 'includes/config.php';
require_once 'includes/functions.php';

// Konten statis (karena tabel pages dihapus)
$title = 'Tentang Saya';
$content = '<p>Saya seorang mahasiswa informatika yang sangat antusias dengan segala hal di dunia teknologi...</p>';
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
        <section id="about">
    <h2>Bagian Tentang</h2>
    <p>
        Saya seorang mahasiswa informatika yang sangat antusias dengan segala hal di dunia teknologi. 
        Didorong oleh hobi bereksperimen, situs ini saya jadikan sebagai laboratorium pribadi untuk mendalami 
        <em>web development</em> secara praktis. Tampilan situs ini telah <u class="underline">dirancang agar tetap optimal</u> 
        dan mudah diakses di semua perangkat.
    </p>

    <article>
        <h3>Pengalaman & Keahlian</h3>
        <p>
            Dengan 1<sup>+</sup> tahun pengalaman, saya memberikan keunggulan dalam setiap proyek. 
            Saya berfokus untuk menjaga semuanya tetap sederhana.
        </p>
    </article>

    <h3>Apa yang saya Tawarkan</h3>
    <ol>
        <li><strong>Desain Web</strong> - Menciptakan antarmuka yang indah dan fungsional</li>
        <li><strong>Pengembangan</strong> - Membangun aplikasi yang tangguh dan terukur</li>
        <li><strong>Konsultasi</strong> - Membimbing bisnis melalui transformasi digital</li>
        <li><strong>Dukungan</strong> - Menyediakan pemeliharaan dan pembaruan berkelanjutan</li>
    </ol>

    <hr>

    <h3>Metrik Kinerja</h3>
    <table>
        <thead>
            <tr>
                <th>Kategori</th>
                <th>Target</th>
                <th>Tercapai</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>Kecepatan Halaman</strong></td>
                <td>Di bawah 2 dtk</td>
                <td>1.5 dtk</td>
                <td>✓ Sangat Baik</td>
            </tr>
            <tr>
                <td><strong>Kegunaan Seluler</strong></td>
                <td>95%+</td>
                <td>98%</td>
                <td>✓ Sangat Baik</td>
            </tr>
            <tr>
                <td><strong>Skor SEO</strong></td>
                <td>90+</td>
                <td>92</td>
                <td>✓ Sangat Baik</td>
            </tr>
            <tr>
                <td><strong>Kepuasan Pengguna</strong></td>
                <td>4.5/5</td>
                <td>4.8/5</td>
                <td>✓ Luar Biasa</td>
            </tr>
        </tbody>
    </table>
</section>
    </main>

</body>
</html>