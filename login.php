<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login - Resto App</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-br from-blue-100 to-purple-200 min-h-screen flex items-center justify-center">

    <div class="w-full max-w-4xl bg-white rounded-xl shadow-lg flex overflow-hidden">
        <!-- Bagian Gambar -->
        <div class="w-1/2 hidden md:block">
            <img src="uploads/resto2.jpg" alt="Menu Makanan" class="h-full w-full object-cover">
        </div>

        <!-- Bagian Form Login -->
        <div class="w-full md:w-1/2 p-8">
            <h2 class="text-3xl font-bold text-center text-indigo-700 mb-6">🍽️ Resto App Login</h2>

            <?php if (isset($_GET['error'])): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 text-sm">
                    <?php
                    switch ($_GET['error']) {
                        case 'username_tidak_ditemukan':
                            echo '❌ Username tidak ditemukan.';
                            break;
                        case 'password_salah':
                            echo '❌ Password salah.';
                            break;
                        case 'metode_tidak_valid':
                            echo '❌ Metode tidak valid.';
                            break;
                        default:
                            echo '❌ Terjadi kesalahan.';
                    }
                    ?>
                </div>
            <?php endif; ?>

            <form action="auth/proses_login.php" method="POST">
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm mb-1" for="username">Username</label>
                    <input id="username" name="username" type="text" required placeholder="Masukkan username"
                        class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring focus:border-blue-400">
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 text-sm mb-1" for="password">Password</label>
                    <input id="password" name="password" type="password" required placeholder="••••••••"
                        class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring focus:border-blue-400">
                </div>

                <button type="submit"
                    class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded">
                    Masuk
                </button>
            </form>

            <p class="text-center text-sm text-gray-600 mt-5">
                Belum punya akun?
                <a href="register.php" class="text-indigo-600 hover:underline font-medium">Daftar sebagai pelayan</a>
            </p>
        </div>
    </div>

</body>

</html>