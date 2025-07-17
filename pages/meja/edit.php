<?php
require '../../config/koneksi.php';

$no_meja = $_GET['no'];
$result = mysqli_query($koneksi, "SELECT * FROM meja WHERE no_meja = '$no_meja'");
$data = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $kapasitas = $_POST['kapasitas'];
    $status = isset($_POST['status']) ? 1 : 0;

    mysqli_query($koneksi, "UPDATE meja SET kapasitas='$kapasitas', status='$status' WHERE no_meja='$no_meja'");
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Edit Meja</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="bg-gradient-to-br from-yellow-50 via-white to-rose-50 min-h-screen flex items-center justify-center px-4">

    <div class="w-full max-w-xl bg-white/80 backdrop-blur-lg border border-gray-200 rounded-3xl shadow-xl p-8">
        <div class="mb-6 text-center">
            <h2 class="text-3xl font-bold text-yellow-600">🪑 Edit Meja No. <?= $data['no_meja'] ?></h2>
            <p class="text-gray-600 text-sm mt-1">Perbarui data kapasitas dan status meja</p>
        </div>

        <form method="POST" class="space-y-5">
            <!-- Kapasitas -->
            <div>
                <label for="kapasitas" class="block text-sm font-medium text-gray-700 mb-1">Kapasitas</label>
                <input type="number" id="kapasitas" name="kapasitas" required value="<?= $data['kapasitas'] ?>"
                    class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-yellow-400 transition shadow-sm">
            </div>

            <!-- Status -->
            <div class="flex items-center space-x-3">
                <input type="checkbox" id="status" name="status" value="1"
                    <?= $data['status'] ? 'checked' : '' ?>
                    class="h-4 w-4 text-yellow-500 border-gray-300 rounded focus:ring-yellow-400">
                <label for="status" class="text-gray-700 text-sm">Tersedia</label>
            </div>

            <!-- Tombol Aksi -->
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