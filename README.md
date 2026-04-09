# report-TA-pemprograman-berbasis-web
Tugas ini merupakan laporan proyek "Website Pribadi Dinamis" yang telah saya kembangkan. Website ini berfungsi sebagai laboratorium pribadi untuk mempraktikkan teori web development secara langsung.
Fitur utama yang diimplementasikan meliputi:

Sistem Konten Dinamis: Menggunakan parameter ?page= pada file utama (index.php) untuk memuat halaman secara modular (home, about, skills, dan contact).

Fitur Dark Mode: Menggunakan JavaScript dan local storage untuk menyimpan preferensi tampilan pengguna.

Form Kontak Terintegrasi: Memungkinkan pengunjung mengirim pesan yang langsung tersimpan ke basis data melalui tabel contact_messages.

Panel Admin (Backend): Tersedia area khusus (melalui includes/config.php dan functions.php) yang memungkinkan pengelola untuk memantau pesan masuk, memperbarui metrik kinerja, serta mengelola data keahlian secara dinamis tanpa perlu mengubah kode HTML secara manual.

Desain Responsif: Antarmuka dirancang menggunakan CSS modern agar tetap optimal di berbagai perangkat.

Teknologi yang Digunakan (Stack):

Bahasa Pemrograman: PHP (Server-side scripting) dan JavaScript (Client-side interactivity).

Basis Data: MySQL/MariaDB dengan ekstensi PDO untuk keamanan kueri (CRUD).

Frontend: HTML5 Semantik dan CSS3 (custom stylesheet new.css).

Alat Tambahan: NGROK untuk keperluan tunnelling saat demo dari localhost.

