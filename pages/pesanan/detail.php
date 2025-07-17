<?php
require '../../config/koneksi.php';

$id = $_GET['id'];

$pesanan = mysqli_query($koneksi, "
    SELECT p.*, m.kapasitas, u.nama AS nama_user 
    FROM pesanan p 
    JOIN meja m ON p.no_meja = m.no_meja 
    JOIN user u ON p.id_user = u.id_user 
    WHERE p.id_pesanan = '$id'
");
$data = mysqli_fetch_assoc($pesanan);

$detail = mysqli_query($koneksi, "
    SELECT d.*, mn.nama_menu, mn.harga 
    FROM detail_pesanan d 
    JOIN menu mn ON d.id_menu = mn.id_menu 
    WHERE d.id_pesanan = '$id'
");
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>🧾 Detail Pesanan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="bg-gradient-to-br from-yellow-50 via-rose-50 to-orange-100 min-h-screen py-10 px-4">

    <div class="max-w-5xl mx-auto bg-white/80 backdrop-blur-md border border-gray-200 rounded-3xl shadow-xl p-10">

        <!-- Judul -->
        <div class="mb-6 text-center">
            <h1 class="text-4xl font-extrabold text-orange-600">🧾 Detail Pesanan #<?= $data['id_pesanan'] ?></h1>
            <p class="text-gray-600 mt-1 text-sm">Ringkasan informasi lengkap pesanan</p>
        </div>

        <!-- Info Umum -->
        <div class="grid md:grid-cols-2 gap-6 mb-8 text-sm text-gray-700">
            <div class="bg-white border border-gray-100 p-4 rounded-xl shadow-sm">
                <p><strong>👤 Nama User:</strong> <?= htmlspecialchars($data['nama_user']) ?></p>
                <p><strong>🪑 Meja:</strong> No. <?= $data['no_meja'] ?> (Kapasitas: <?= $data['kapasitas'] ?> orang)</p>
            </div>
            <div class="bg-white border border-gray-100 p-4 rounded-xl shadow-sm">
                <p><strong>⏰ Waktu Pesan:</strong> <?= $data['waktu_pesanan'] ?></p>
                <p><strong>📦 Status:</strong>
                    <span class="inline-block px-3 py-1 rounded-full text-xs font-medium 
                        <?= $data['status'] ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700' ?>">
                        <?= $data['status'] ? 'Selesai' : 'Belum' ?>
                    </span>
                </p>
            </div>
        </div>

        <!-- Daftar Menu -->
        <div class="mb-4">
            <h2 class="text-2xl font-bold text-orange-500 mb-3">🍽️ Menu yang Dipesan</h2>
            <div class="overflow-x-auto rounded-xl border border-gray-200 shadow-sm">
                <table class="min-w-full divide-y divide-gray-200 text-sm text-gray-700">
                    <thead class="bg-orange-500 text-white text-xs uppercase">
                        <tr>
                            <th class="px-6 py-3 text-left">Nama Menu</th>
                            <th class="px-6 py-3 text-left">Harga</th>
                            <th class="px-6 py-3 text-left">Jumlah</th>
                            <th class="px-6 py-3 text-left">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        <?php
                        $total = 0;
                        while ($d = mysqli_fetch_assoc($detail)) :
                            $total += $d['subtotal'];
                        ?>
                            <tr class="hover:bg-orange-50 transition">
                                <td class="px-6 py-4 font-medium"><?= htmlspecialchars($d['nama_menu']) ?></td>
                                <td class="px-6 py-4">Rp<?= number_format($d['harga'], 0, ',', '.') ?></td>
                                <td class="px-6 py-4"><?= $d['jumlah'] ?></td>
                                <td class="px-6 py-4">Rp<?= number_format($d['subtotal'], 0, ',', '.') ?></td>
                            </tr>
                        <?php endwhile; ?>
                        <tr class="bg-orange-100 text-orange-800 font-bold">
                            <td colspan="3" class="px-6 py-4 text-right">Total</td>
                            <td class="px-6 py-4">Rp<?= number_format($total, 0, ',', '.') ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Tombol -->
        <div class="mt-6 text-end">
            <a href="index.php"
                class="inline-block px-6 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 text-sm font-semibold rounded-full shadow transition">
                ← Kembali ke Pesanan
            </a>
        </div>

    </div>

</body>

</html>