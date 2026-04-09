<nav style="background: #0072ff; padding: 15px 0; text-align: center;">
    <a href="index.php" <?= $active_page === 'home' ? 'style="background:#00c6ff; padding:10px 20px; border-radius:30px;"' : '' ?>>Home</a>
    <a href="index.php?page=about" <?= $active_page === 'about' ? 'style="background:#00c6ff; padding:10px 20px; border-radius:30px;"' : '' ?>>About</a>
    <a href="index.php?page=skills" <?= $active_page === 'skills' ? 'style="background:#00c6ff; padding:10px 20px; border-radius:30px;"' : '' ?>>Skills</a>
    <a href="index.php?page=contact" <?= $active_page === 'contact' ? 'style="background:#00c6ff; padding:10px 20px; border-radius:30px;"' : '' ?>>Contact</a>
</nav>