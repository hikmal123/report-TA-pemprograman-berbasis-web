<?php
// includes/header.php
// Header dengan tombol Dark Mode dan Login Admin berdekatan di pojok kanan atas
?>

<header style="background: linear-gradient(to right, #00c6ff, #0072ff); color: white; padding: 40px 20px; text-align: center; position: relative;">
    <h1 style="margin: 0;">Website Pribadi Dinamis</h1>
    <p style="margin: 10px 0 0; font-size: 1.1em;">Eksperimen Web Development</p>

    <!-- Container untuk tombol Dark Mode dan Login Admin (berdekatan) -->
    <div class="admin-controls" style="position: absolute; top: 20px; right: 20px; display: flex; align-items: center; gap: 12px; z-index: 1000;">
        
        <!-- Tombol Dark Mode Toggle -->
        <button id="toggleSwitch" aria-label="Toggle Dark Mode" 
                style="background: rgba(255,255,255,0.2); border: 1px solid rgba(255,255,255,0.4); 
                       border-radius: 50px; padding: 8px 16px; color: white; cursor: pointer; 
                       font-size: 18px; transition: all 0.3s ease; backdrop-filter: blur(5px); 
                       display: flex; align-items: center; gap: 8px;">
            <span class="sun-icon">☀️</span>
            <span class="moon-icon" style="display: none;">🌙</span>
        </button>

        <!-- Tombol Login Admin (di sebelah kanan Dark Mode) -->
        <a href="admin/login.php" 
           style="background: rgba(255,255,255,0.3); color: white; 
                  padding: 8px 20px; border-radius: 30px; text-decoration: none; 
                  font-weight: 600; transition: all 0.3s ease; 
                  backdrop-filter: blur(5px); border: 1px solid rgba(255,255,255,0.4);">
            Login Admin
        </a>
    </div>
</header>