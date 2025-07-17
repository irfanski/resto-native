<?php
require '../includes/header.php';

if (!isset($_SESSION['user_role']) || !isset($_SESSION['username']) || !isset($_SESSION['user_nama'])) {
    header("Location: ../login.php");
    exit();
}

$role = $_SESSION['user_role'];
$user_nama = $_SESSION['user_nama'];
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Dashboard Resto</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="min-h-screen bg-gradient-to-br from-purple-100 via-indigo-100 to-pink-100 p-6">

    <div class="max-w-7xl mx-auto">
        <div class="bg-white/70 backdrop-blur-xl border border-white shadow-2xl rounded-3xl p-10 transition-all">

            <!-- Header -->
            <div class="mb-10 text-center">
                <h1 class="text-4xl font-extrabold text-gray-800">
                    Hai, <span class="text-indigo-600"><?= htmlspecialchars($user_nama) ?></span> 👋
                </h1>
                <p class="mt-2 text-gray-500 text-lg">Kamu login sebagai <span class="capitalize text-indigo-700 font-medium"><?= htmlspecialchars($role) ?></span></p>
            </div>

            <!-- Grid Menu -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">

                <?php if (in_array($role, ['admin', 'pelayan'])): ?>
                    <a href="meja/index.php" class="transition transform hover:-translate-y-1 hover:shadow-xl bg-white rounded-2xl p-6 border border-indigo-200 group">
                        <div class="flex justify-between items-center">
                            <div>
                                <h2 class="text-xl font-bold text-indigo-700">Kelola Meja</h2>
                                <p class="text-sm text-gray-500 mt-1">Atur daftar & status meja</p>
                            </div>
                            <div class="text-5xl group-hover:scale-110 transition">🪑</div>
                        </div>
                    </a>
                <?php endif; ?>

                <?php if (in_array($role, ['admin', 'koki'])): ?>
                    <a href="menu/index.php" class="transition transform hover:-translate-y-1 hover:shadow-xl bg-white rounded-2xl p-6 border border-green-200 group">
                        <div class="flex justify-between items-center">
                            <div>
                                <h2 class="text-xl font-bold text-green-700">Kelola Menu</h2>
                                <p class="text-sm text-gray-500 mt-1">Kelola makanan & minuman</p>
                            </div>
                            <div class="text-5xl group-hover:scale-110 transition">🍽️</div>
                        </div>
                    </a>
                <?php endif; ?>

                <?php if ($role === 'admin'): ?>
                    <a href="user/index.php" class="transition transform hover:-translate-y-1 hover:shadow-xl bg-white rounded-2xl p-6 border border-yellow-200 group">
                        <div class="flex justify-between items-center">
                            <div>
                                <h2 class="text-xl font-bold text-yellow-600">Kelola User</h2>
                                <p class="text-sm text-gray-500 mt-1">Manajemen akun pengguna</p>
                            </div>
                            <div class="text-5xl group-hover:scale-110 transition">👥</div>
                        </div>
                    </a>
                <?php endif; ?>

                <?php if (in_array($role, ['admin', 'pelayan', 'koki'])): ?>
                    <a href="pesanan/index.php" class="transition transform hover:-translate-y-1 hover:shadow-xl bg-white rounded-2xl p-6 border border-pink-200 group">
                        <div class="flex justify-between items-center">
                            <div>
                                <h2 class="text-xl font-bold text-pink-600">Kelola Pesanan</h2>
                                <p class="text-sm text-gray-500 mt-1">Lihat & kelola daftar pesanan</p>
                            </div>
                            <div class="text-5xl group-hover:scale-110 transition">📝</div>
                        </div>
                    </a>
                <?php endif; ?>

                <?php if (in_array($role, ['admin', 'kasir'])): ?>
                    <a href="transaksi/index.php" class="transition transform hover:-translate-y-1 hover:shadow-xl bg-white rounded-2xl p-6 border border-red-200 group">
                        <div class="flex justify-between items-center">
                            <div>
                                <h2 class="text-xl font-bold text-red-600">Transaksi</h2>
                                <p class="text-sm text-gray-500 mt-1">Riwayat pembayaran & struk</p>
                            </div>
                            <div class="text-5xl group-hover:scale-110 transition">💳</div>
                        </div>
                    </a>
                <?php endif; ?>

            </div>
        </div>
    </div>

</body>

</html>

<?php require '../includes/footer.php'; ?>