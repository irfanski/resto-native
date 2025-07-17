<?php
require '../../config/koneksi.php';

$id = $_GET['id'];
$result = mysqli_query($koneksi, "SELECT * FROM pesanan WHERE id_pesanan = '$id'");
$data = mysqli_fetch_assoc($result);

$meja = mysqli_query($koneksi, "SELECT * FROM meja");
$user = mysqli_query($koneksi, "SELECT * FROM user");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $no_meja = $_POST['no_meja'];
    $id_user = $_POST['id_user'];
    $status = isset($_POST['status']) ? 1 : 0;

    mysqli_query($koneksi, "UPDATE pesanan SET 
        no_meja='$no_meja', 
        id_user='$id_user',
        status='$status'
        WHERE id_pesanan = '$id'");
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Edit Pesanan</title>

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

<body class="bg-gradient-to-br from-yellow-50 via-white to-rose-50 min-h-screen flex items-center justify-center px-4">

    <div class="w-full max-w-xl bg-white/80 backdrop-blur-lg border border-gray-200 rounded-3xl shadow-xl p-8">
        <div class="mb-6 text-center">
            <h2 class="text-3xl font-bold text-yellow-600">🧾 Edit Pesanan #<?= $data['id_pesanan'] ?></h2>
            <p class="text-gray-600 text-sm mt-1">Perbarui meja, user, dan status pesanan</p>
        </div>

        <form method="POST" class="space-y-5">
            <!-- Pilih Meja -->
            <div>
                <label for="no_meja" class="block text-sm font-medium text-gray-700 mb-1">Pilih Meja</label>
                <select name="no_meja" id="no_meja" required
                    class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-yellow-400 transition shadow-sm">
                    <?php while ($m = mysqli_fetch_assoc($meja)) : ?>
                        <option value="<?= $m['no_meja'] ?>" <?= $data['no_meja'] == $m['no_meja'] ? 'selected' : '' ?>>
                            Meja <?= $m['no_meja'] ?> (Kapasitas: <?= $m['kapasitas'] ?>)
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <!-- Pilih User -->
            <div>
                <label for="id_user" class="block text-sm font-medium text-gray-700 mb-1">Pilih User</label>
                <select name="id_user" id="id_user" required
                    class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-yellow-400 transition shadow-sm">
                    <?php while ($u = mysqli_fetch_assoc($user)) : ?>
                        <option value="<?= $u['id_user'] ?>" <?= $data['id_user'] == $u['id_user'] ? 'selected' : '' ?>>
                            <?= $u['nama'] ?> (<?= $u['role'] ?>)
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <!-- Status Pesanan -->
            <div class="flex items-center space-x-3">
                <input type="checkbox" id="status" name="status" value="1"
                    <?= $data['status'] ? 'checked' : '' ?>
                    class="h-4 w-4 text-yellow-500 border-gray-300 rounded focus:ring-yellow-400">
                <label for="status" class="text-gray-700 text-sm">✅ Selesai</label>
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