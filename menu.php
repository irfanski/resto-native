<?php
require 'config/koneksi.php';
$result = mysqli_query($koneksi, "SELECT * FROM menu ORDER BY nama_menu");
$menus = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Menu Restoran</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Georgia', serif;
        }
    </style>
</head>

<body class="bg-gradient-to-br from-gray-900 to-gray-800 min-h-screen flex items-center justify-center px-4 py-10 text-white">

    <div class="bg-gray-950 rounded-2xl shadow-xl flex w-full max-w-5xl overflow-hidden border border-gray-700">

        <!-- KIRI: List Menu -->
        <div class="w-2/3 p-8">
            <h1 class="text-4xl font-bold text-amber-400 mb-4">📜 Daftar Menu</h1>
            <p class="text-gray-300 mb-8 text-lg">Restoran Pak Resto UNIKOM</p>

            <ul class="space-y-4 divide-y divide-gray-700">
                <?php foreach ($menus as $menu): ?>
                    <li class="flex justify-between pt-2 text-gray-100">
                        <span><?= htmlspecialchars($menu['nama_menu']) ?></span>
                        <span class="font-semibold text-amber-400">Rp <?= number_format($menu['harga'], 0, ',', '.') ?></span>
                    </li>
                <?php endforeach; ?>
            </ul>

            <p class="text-sm text-gray-500 mt-8">📍 UNIKOM</p>
        </div>

        <!-- KANAN: Gambar -->
        <div class="w-1/3">
            <img src="uploads/RESTO.jpg" alt="Menu Makanan" class="h-full w-full object-cover brightness-90">
        </div>
    </div>

</body>

</html>