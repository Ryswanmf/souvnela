<?php

// File ini hanya untuk sementara. Segera hapus setelah digunakan.

// 1. Ganti tulisan 'password_anda_disini' dengan password yang Anda inginkan.
$passwordPolos = '123';

// 2. Jangan ubah bagian di bawah ini.
if ($passwordPolos === 'password_anda_disini' || empty($passwordPolos)) {
    echo "<h1>Harap edit file ini terlebih dahulu.</h1>";
    echo "<p>Buka file <code>public/buat_hash.php</code> dan ganti <code>'password_anda_disini'</code> dengan password baru Anda.</p>";
    die();
}

$hash = password_hash($passwordPolos, PASSWORD_DEFAULT);

// 3. Akses file ini dari browser, lalu copy-paste hash di bawah ini ke database Anda.
echo "<h1>Password Hash Anda:</h1>";
echo "<p>Silakan salin teks di bawah ini dan tempelkan ke kolom 'password' di tabel 'users' pada baris admin Anda.</p>";
echo "<hr>";
echo '<pre style="background-color:#f1f1f1; padding:10px; border:1px solid #ccc; word-wrap:break-word;">';
echo htmlspecialchars($hash);
echo "</pre>";
echo "<hr>";
echo '<h3 style="color:red;">PENTING: Segera hapus file ini (buat_hash.php) setelah selesai!</h3>';

?>