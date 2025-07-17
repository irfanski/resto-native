<?php
require '../../config/koneksi.php';
$query = mysqli_query($koneksi, "SELECT * FROM user");
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Daftar Pengguna</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .fade-in {
            animation: fadeIn 0.5s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body class="bg-gradient-to-br from-yellow-50 via-white to-rose-50 min-h-screen px-4 py-8">

    <div class="max-w-5xl mx-auto bg-white/80 backdrop-blur-lg border border-gray-200 rounded-3xl shadow-xl p-8 fade-in">
        <div class="flex flex-col sm:flex-row justify-between items-center mb-6">
            <div>
                <h1 class="text-3xl font-bold text-yellow-600">👥 Daftar Pengguna</h1>
                <p class="text-gray-600 text-sm mt-1">Manajemen data user sistem</p>
            </div>
            <div class="flex gap-3 mt-4 sm:mt-0">
                <a href="../dashboard.php"
                    class="px-4 py-2 rounded-lg bg-gray-200 hover:bg-gray-300 text-gray-800 text-sm font-semibold transition">
                    ← Kembali
                </a>
                <a href="tambah.php"
                    class="px-4 py-2 rounded-lg bg-yellow-500 hover:bg-yellow-600 text-white text-sm font-semibold transition shadow">
                    + Tambah User
                </a>
            </div>
        </div>

        <div class="overflow-x-auto rounded-xl shadow-sm">
            <table class="min-w-full text-sm text-gray-700 bg-white rounded-xl overflow-hidden">
                <thead class="bg-yellow-500 text-white text-left text-sm uppercase tracking-wider">
                    <tr>
                        <th class="px-6 py-3">Nama</th>
                        <th class="px-6 py-3">Username</th>
                        <th class="px-6 py-3">Role</th>
                        <th class="px-6 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <?php while ($data = mysqli_fetch_assoc($query)) : ?>
                        <tr class="hover:bg-yellow-50 transition">
                            <td class="px-6 py-3"><?= htmlspecialchars($data['nama']) ?></td>
                            <td class="px-6 py-3"><?= htmlspecialchars($data['username']) ?></td>
                            <td class="px-6 py-3 capitalize"><?= $data['role'] ?></td>
                            <td class="px-6 py-3 text-center space-x-2">
                                <a href="edit.php?id=<?= $data['id_user'] ?>"
                                    class="inline-block px-3 py-1 bg-yellow-400 hover:bg-yellow-500 text-white rounded-md text-xs font-semibold shadow transition">
                                    ✏️ Edit
                                </a>
                                <a href="hapus.php?id=<?= $data['id_user'] ?>"
                                    onclick="return confirm('Yakin ingin menghapus?')"
                                    class="inline-block px-3 py-1 bg-red-500 hover:bg-red-600 text-white rounded-md text-xs font-semibold shadow transition">
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