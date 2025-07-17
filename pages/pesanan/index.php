<?php
require '../../config/koneksi.php';

$query = mysqli_query($koneksi, "
    SELECT p.*, m.kapasitas, u.nama AS nama_user 
    FROM pesanan p 
    JOIN meja m ON p.no_meja = m.no_meja 
    JOIN user u ON p.id_user = u.id_user 
    ORDER BY p.waktu_pesanan DESC
");
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>📦 Daftar Pesanan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="bg-gradient-to-br from-purple-50 via-white to-indigo-100 min-h-screen py-10 px-4">

    <div class="max-w-7xl mx-auto bg-white/90 backdrop-blur-md border border-gray-200 rounded-3xl shadow-xl p-10">

        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
            <div>
                <h1 class="text-4xl font-extrabold text-indigo-700">🗒 Daftar Pesanan</h1>
                <p class="text-gray-600 text-sm mt-1">Lihat semua transaksi dan status terbaru</p>
            </div>
            <div class="flex gap-3">
                <a href="../dashboard.php"
                    class="px-5 py-2 rounded-full bg-gray-100 hover:bg-gray-200 text-gray-800 text-sm font-semibold transition shadow">
                    ← Dashboard
                </a>
                <a href="tambah.php"
                    class="px-5 py-2 rounded-full bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold shadow transition">
                    + Tambah Pesanan
                </a>
            </div>
        </div>

        <!-- Tabel -->
        <div class="overflow-x-auto rounded-xl border border-gray-200 shadow-sm">
            <table class="min-w-full divide-y divide-gray-200 text-sm text-gray-700">
                <thead class="bg-indigo-600 text-white text-xs uppercase tracking-wider">
                    <tr>
                        <th class="px-6 py-3 text-left">ID</th>
                        <th class="px-6 py-3 text-left">No Meja</th>
                        <th class="px-6 py-3 text-left">Nama User</th>
                        <th class="px-6 py-3 text-left">Waktu</th>
                        <th class="px-6 py-3 text-left">Status</th>
                        <th class="px-6 py-3 text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    <?php while ($data = mysqli_fetch_assoc($query)) : ?>
                        <tr class="hover:bg-indigo-50 transition">
                            <td class="px-6 py-4 font-semibold"><?= htmlspecialchars($data['id_pesanan']) ?></td>
                            <td class="px-6 py-4"><?= htmlspecialchars($data['no_meja']) ?></td>
                            <td class="px-6 py-4"><?= htmlspecialchars($data['nama_user']) ?></td>
                            <td class="px-6 py-4"><?= htmlspecialchars($data['waktu_pesanan']) ?></td>
                            <td class="px-6 py-4">
                                <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold
                                    <?= $data['status'] ? 'bg-emerald-100 text-emerald-700' : 'bg-rose-100 text-rose-700' ?>">
                                    <?= $data['status'] ? 'Selesai' : 'Dibuat' ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 flex flex-wrap gap-2">
                                <a href="detail.php?id=<?= $data['id_pesanan'] ?>"
                                    class="px-4 py-1 bg-sky-500 hover:bg-sky-600 text-white text-xs font-medium rounded-full transition shadow">
                                    🔍 Detail
                                </a>
                                <a href="edit.php?id=<?= $data['id_pesanan'] ?>"
                                    class="px-4 py-1 bg-yellow-400 hover:bg-yellow-500 text-white text-xs font-medium rounded-full transition shadow">
                                    ✏️ Edit
                                </a>
                                <a href="hapus.php?id=<?= $data['id_pesanan'] ?>" onclick="return confirm('Yakin hapus?')"
                                    class="px-4 py-1 bg-red-500 hover:bg-red-600 text-white text-xs font-medium rounded-full transition shadow">
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