<?php

// Tulis password yang Anda inginkan di sini
$password_untuk_dihash = 'admin123';

// Proses pembuatan hash
$hash = password_hash($password_untuk_dihash, PASSWORD_DEFAULT);

// Tampilkan hasilnya
echo "<h1>Alat Pembuat Hash Password</h1>";
echo "<p>Gunakan hash di bawah ini untuk disimpan di database.</p>";
echo "<hr>";
echo "<p><b>Password:</b> " . htmlspecialchars($password_untuk_dihash) . "</p>";
echo "<p><b>Hash Baru:</b></p>";
echo "<textarea rows='3' cols='70' readonly>" . htmlspecialchars($hash) . "</textarea>";

?>