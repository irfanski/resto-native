<?php
require '../../config/koneksi.php';
$query = mysqli_query($koneksi, "SELECT * FROM meja");
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Data Meja</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="bg-gradient-to-br from-yellow-50 via-white to-rose-50 min-h-screen py-10 px-4">

    <div class="max-w-6xl mx-auto bg-white/80 backdrop-blur-lg border border-gray-200 rounded-3xl shadow-xl p-10">

        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8 gap-4">
            <div>
                <h2 class="text-4xl font-extrabold text-yellow-600">🪑 Daftar Meja</h2>
                <p class="text-gray-600 mt-1 text-sm">Kelola nomor meja, kapasitas, dan status ketersediaannya</p>
            </div>
            <div class="flex gap-3">
                <a href="../dashboard.php" class="inline-block px-5 py-2 rounded-lg bg-gray-200 hover:bg-gray-300 text-gray-800 text-sm font-semibold transition">
                    ← Dashboard
                </a>
                <a href="tambah.php" class="inline-block px-5 py-2 rounded-lg bg-yellow-500 hover:bg-yellow-600 text-white text-sm font-semibold shadow transition">
                    + Tambah Meja
                </a>
            </div>
        </div>

        <!-- Tabel -->
        <div class="overflow-x-auto rounded-xl border border-gray-200 shadow-sm">
            <table class="min-w-full divide-y divide-gray-200 text-sm text-gray-800">
                <thead class="bg-yellow-500 text-white uppercase text-xs tracking-wider">
                    <tr>
                        <th class="px-6 py-3 text-left">No Meja</th>
                        <th class="px-6 py-3 text-left">Kapasitas</th>
                        <th class="px-6 py-3 text-left">Status</th>
                        <th class="px-6 py-3 text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    <?php while ($data = mysqli_fetch_assoc($query)) : ?>
                        <tr class="hover:bg-yellow-50 transition">
                            <td class="px-6 py-4 font-semibold"><?= htmlspecialchars($data['no_meja']) ?></td>
                            <td class="px-6 py-4"><?= htmlspecialchars($data['kapasitas']) ?> orang</td>
                            <td class="px-6 py-4">
                                <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold 
                                    <?= $data['status'] ? 'bg-green-100 text-green-700' : 'bg-gray-200 text-gray-600' ?>">
                                    <?= $data['status'] ? 'Tersedia' : 'Tidak Tersedia' ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 flex gap-2">
                                <a href="edit.php?no=<?= $data['no_meja'] ?>" class="inline-block bg-yellow-400 hover:bg-yellow-500 text-white text-xs font-bold px-4 py-2 rounded-lg shadow transition">
                                    ✏️ Edit
                                </a>
                                <a href="hapus.php?no=<?= $data['no_meja'] ?>" onclick="return confirm('Yakin hapus?')" class="inline-block bg-red-500 hover:bg-red-600 text-white text-xs font-bold px-4 py-2 rounded-lg shadow transition">
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