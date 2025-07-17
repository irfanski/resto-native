<?php
require '../../config/koneksi.php';

$id_menu = $_GET['id'];
$result = mysqli_query($koneksi, "SELECT * FROM menu WHERE id_menu = '$id_menu'");
$data = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama_menu'];
    $deskripsi = $_POST['deskripsi'];
    $harga = $_POST['harga'];
    $jenis = $_POST['jenis'];
    $ketersediaan = isset($_POST['ketersediaan']) ? 1 : 0;

    mysqli_query($koneksi, "UPDATE menu SET 
        nama_menu = '$nama',
        deskripsi = '$deskripsi',
        harga = '$harga',
        jenis = '$jenis',
        ketersediaan = '$ketersediaan'
        WHERE id_menu = '$id_menu'");

    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Edit Menu</title>

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

<body class="bg-gradient-to-br from-yellow-50 via-white to-rose-100 min-h-screen flex items-center justify-center px-4">

    <div class="w-full max-w-2xl bg-white/80 backdrop-blur-md border border-gray-200 rounded-3xl shadow-xl p-8">
        <div class="mb-6 text-center">
            <h2 class="text-3xl font-bold text-yellow-600">✏️ Edit Menu</h2>
            <p class="text-gray-600 text-sm mt-1">Perbarui informasi menu yang tersedia</p>
        </div>

        <form method="POST" class="space-y-5">
            <!-- Nama Menu -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Menu</label>
                <input type="text" name="nama_menu" required
                    value="<?= htmlspecialchars($data['nama_menu']) ?>"
                    class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-yellow-400 shadow-sm transition">
            </div>

            <!-- Deskripsi -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                <textarea name="deskripsi" rows="3" required
                    class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-yellow-400 shadow-sm transition"><?= htmlspecialchars($data['deskripsi']) ?></textarea>
            </div>

            <!-- Jenis -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Jenis</label>
                <select name="jenis" required
                    class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-yellow-400 shadow-sm transition">
                    <option value="1" <?= $data['jenis'] == 1 ? 'selected' : '' ?>>🍛 Makanan</option>
                    <option value="2" <?= $data['jenis'] == 2 ? 'selected' : '' ?>>🥤 Minuman</option>
                </select>
            </div>

            <!-- Harga -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Harga</label>
                <input type="number" name="harga" required
                    value="<?= htmlspecialchars($data['harga']) ?>"
                    class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-yellow-400 shadow-sm transition">
            </div>

            <!-- Ketersediaan -->
            <div class="flex items-center space-x-3">
                <input type="checkbox" id="tersedia" name="ketersediaan" value="1"
                    <?= $data['ketersediaan'] ? 'checked' : '' ?>
                    class="h-4 w-4 text-yellow-500 border-gray-300 rounded focus:ring-yellow-400">
                <label for="tersedia" class="text-gray-700 text-sm">Tersedia</label>
            </div>

            <!-- Tombol -->
            <div class="flex justify-end gap-3 pt-4">
                <a href="index.php"
                    class="inline-block px-5 py-2 rounded-lg bg-gray-200 hover:bg-gray-300 text-gray-800 text-sm font-semibold transition">
                    Batal
                </a>
                <button type="submit"
                    class="px-6 py-2 rounded-lg bg-yellow-500 hover:bg-yellow-600 text-white text-sm font-semibold shadow transition">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>

</body>

</html>