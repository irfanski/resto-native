<?php
require '../../config/koneksi.php';

$meja = mysqli_query($koneksi, "SELECT * FROM meja WHERE status = 1");
$user = mysqli_query($koneksi, "SELECT * FROM user");
$menu = mysqli_query($koneksi, "SELECT * FROM menu WHERE ketersediaan = 1");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $no_meja = $_POST['no_meja'];
    $id_user = $_POST['id_user'];
    $status = isset($_POST['status']) ? 1 : 0;
    $waktu = date('Y-m-d H:i:s');

    mysqli_query($koneksi, "INSERT INTO pesanan (no_meja, id_user, waktu_pesanan, status) VALUES ('$no_meja', '$id_user', '$waktu', '$status')");
    $id_pesanan = mysqli_insert_id($koneksi);

    foreach ($_POST['menu'] as $index => $id_menu) {
        $jumlah = $_POST['jumlah'][$index];
        if ($jumlah > 0) {
            $getHarga = mysqli_query($koneksi, "SELECT harga FROM menu WHERE id_menu = '$id_menu'");
            $harga = mysqli_fetch_assoc($getHarga)['harga'];
            $subtotal = $harga * $jumlah;

            mysqli_query($koneksi, "INSERT INTO detail_pesanan (id_pesanan, id_menu, jumlah, subtotal)
                VALUES ('$id_pesanan', '$id_menu', '$jumlah', '$subtotal')");
        }
    }

    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>🗒 Tambah Pesanan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="bg-gradient-to-br from-orange-50 via-yellow-50 to-pink-100 min-h-screen py-10 px-4">

    <div class="max-w-4xl mx-auto bg-white/80 backdrop-blur-md border border-gray-200 rounded-3xl shadow-xl p-10">

        <!-- Header -->
        <div class="mb-8 text-center">
            <h1 class="text-3xl font-extrabold text-orange-500">🗒 Tambah Pesanan</h1>
            <p class="text-sm text-gray-600 mt-1">Isi data pesanan lengkap beserta menu pilihan</p>
        </div>

        <form method="POST" class="space-y-6">

            <!-- Meja -->
            <div>
                <label class="block mb-1 text-sm font-medium text-gray-700">🪑 Pilih Meja</label>
                <select name="no_meja" required class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-orange-300 focus:outline-none">
                    <?php while ($m = mysqli_fetch_assoc($meja)) : ?>
                        <option value="<?= $m['no_meja'] ?>">Meja <?= $m['no_meja'] ?> (Kapasitas <?= $m['kapasitas'] ?>)</option>
                    <?php endwhile; ?>
                </select>
            </div>

            <!-- User -->
            <div>
                <label class="block mb-1 text-sm font-medium text-gray-700">👤 Pilih User</label>
                <select name="id_user" required class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-orange-300 focus:outline-none">
                    <?php while ($u = mysqli_fetch_assoc($user)) : ?>
                        <option value="<?= $u['id_user'] ?>"><?= $u['nama'] ?> (<?= $u['role'] ?>)</option>
                    <?php endwhile; ?>
                </select>
            </div>

            <!-- Status -->
            <div class="flex items-center gap-2">
                <input type="checkbox" name="status" value="1" id="selesai"
                    class="h-4 w-4 text-orange-500 border-gray-300 rounded focus:ring-orange-400">
                <label for="selesai" class="text-gray-700 text-sm">Selesaikan langsung?</label>
            </div>

            <hr class="my-6 border-gray-200">

            <!-- Menu -->
            <div>
                <h2 class="text-xl font-bold text-orange-600 mb-3">🍽️ Menu yang Dipesan</h2>

                <?php if (mysqli_num_rows($menu) === 0) : ?>
                    <div class="bg-yellow-100 text-yellow-800 px-4 py-3 rounded-lg shadow-sm text-sm">
                        Tidak ada menu tersedia saat ini.
                    </div>
                <?php else : ?>
                    <div class="grid gap-4">
                        <?php while ($m = mysqli_fetch_assoc($menu)) : ?>
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 p-4 bg-white border border-gray-100 rounded-xl shadow-sm">
                                <div class="flex-1">
                                    <input type="hidden" name="menu[]" value="<?= $m['id_menu'] ?>">
                                    <p class="font-semibold text-gray-800"><?= $m['nama_menu'] ?></p>
                                    <p class="text-sm text-gray-500">Rp<?= number_format($m['harga'], 0, ',', '.') ?></p>
                                </div>
                                <div class="w-full sm:w-32">
                                    <input type="number" name="jumlah[]" min="0" placeholder="Jumlah"
                                        class="w-full px-3 py-2 rounded-lg border border-gray-300 focus:ring-orange-300 focus:outline-none">
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Tombol -->
            <div class="pt-4 text-end">
                <a href="index.php"
                    class="inline-block px-5 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 text-sm font-medium rounded-lg shadow-sm transition">
                    Batal
                </a>
                <button type="submit"
                    class="ml-2 px-6 py-2 bg-orange-500 hover:bg-orange-600 text-white text-sm font-semibold rounded-lg shadow transition">
                    Simpan Pesanan
                </button>
            </div>

        </form>
    </div>

</body>

</html>