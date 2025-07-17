<?php
require '../../config/koneksi.php';

$query = mysqli_query($koneksi, "SELECT * FROM menu");

function getJenis($kode)
{
    return $kode == 1 ? 'Makanan' : ($kode == 2 ? 'Minuman' : 'Lainnya');
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>🍽️ Menu Restoran</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Google Fonts: Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="bg-gradient-to-br from-pink-50 via-white to-yellow-100 min-h-screen py-10 px-4">

    <div class="max-w-7xl mx-auto bg-white/80 backdrop-blur-md border border-gray-200 rounded-3xl shadow-2xl p-10">

        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8 gap-4">
            <div>
                <h1 class="text-4xl font-extrabold text-pink-600">🍜 Menu Restoran</h1>
                <p class="text-sm text-gray-600 mt-1">Lihat dan kelola daftar menu makanan & minuman</p>
            </div>
            <div class="flex gap-3">
                <a href="../dashboard.php"
                    class="px-5 py-2 rounded-lg bg-gray-200 hover:bg-gray-300 text-gray-800 text-sm font-medium transition shadow">
                    ← Kembali
                </a>
                <a href="tambah.php"
                    class="px-5 py-2 rounded-lg bg-pink-500 hover:bg-pink-600 text-white text-sm font-medium transition shadow">
                    + Tambah Menu
                </a>
            </div>
        </div>

        <!-- Tabel Menu -->
        <div class="overflow-x-auto rounded-xl shadow-xl border border-gray-200">
            <table class="min-w-full divide-y divide-gray-200 text-sm text-gray-700">
                <thead class="bg-pink-500 text-white uppercase text-xs">
                    <tr>
                        <th class="px-6 py-3 text-left">Nama</th>
                        <th class="px-6 py-3 text-left">Deskripsi</th>
                        <th class="px-6 py-3 text-left">Jenis</th>
                        <th class="px-6 py-3 text-left">Harga</th>
                        <th class="px-6 py-3 text-left">Status</th>
                        <th class="px-6 py-3 text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    <?php while ($data = mysqli_fetch_assoc($query)) : ?>
                        <tr class="hover:bg-pink-50 transition">
                            <td class="px-6 py-4 font-semibold"><?= htmlspecialchars($data['nama_menu']) ?></td>
                            <td class="px-6 py-4"><?= htmlspecialchars($data['deskripsi']) ?></td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 rounded-full text-xs font-semibold 
                                    <?= $data['jenis'] == 1 ? 'bg-yellow-100 text-yellow-700' : ($data['jenis'] == 2 ? 'bg-blue-100 text-blue-700' : 'bg-gray-200 text-gray-600') ?>">
                                    <?= getJenis($data['jenis']) ?>
                                </span>
                            </td>
                            <td class="px-6 py-4">Rp<?= number_format($data['harga'], 0, ',', '.') ?></td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 rounded-full text-xs font-medium
                                    <?= $data['ketersediaan'] ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-600' ?>">
                                    <?= $data['ketersediaan'] ? 'Tersedia' : 'Habis' ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 flex gap-2">
                                <a href="edit.php?id=<?= $data['id_menu'] ?>"
                                    class="px-4 py-1.5 rounded-full bg-yellow-400 hover:bg-yellow-500 text-white text-xs font-semibold transition shadow">
                                    ✏️ Edit
                                </a>
                                <a href="hapus.php?id=<?= $data['id_menu'] ?>"
                                    onclick="return confirm('Yakin hapus menu ini?')"
                                    class="px-4 py-1.5 rounded-full bg-red-500 hover:bg-red-600 text-white text-xs font-semibold transition shadow">
                                    🗑️ Hapus
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

    </div>

</body>

</html>