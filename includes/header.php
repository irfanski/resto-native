<?php
require __DIR__ . '/../auth/cek_login.php';
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $judul_halaman ?? 'Sistem Restoran' ?></title>

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Modern -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="bg-gradient-to-br from-purple-50 to-pink-50 min-h-screen">

    <!-- 🌟 Navbar Estetik -->
    <nav class="bg-white/70 backdrop-blur-md shadow-lg border-b border-gray-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">

                <!-- 🧾 Logo -->
                <div class="flex-shrink-0 flex items-center gap-2">
                    <div class="text-5xl group-hover:scale-110 transition">🍴</div>
                    <a href="/resto-native/index.php" class="text-2xl font-extrabold text-indigo-700 tracking-tight hover:opacity-80 transition">
                        RestoApp
                    </a>
                </div>

                <!-- 👤 Info Pengguna -->
                <div class="flex items-center gap-4">
                    <span class="text-sm text-gray-700">Halo, <span class="font-semibold text-gray-900"><?= htmlspecialchars($_SESSION['user_nama']) ?></span>!</span>
                    <a href="/resto-native/auth/logout.php"
                        class="inline-block bg-red-500 hover:bg-red-600 text-white font-semibold text-sm px-4 py-2 rounded-lg shadow transition duration-300">
                        Logout
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Konten Utama -->
    <main class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">