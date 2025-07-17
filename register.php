<?php
require 'config/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = trim($_POST['nama']);
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $role = 'pelayan';

    if ($nama && $username && $password) {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $query = "INSERT INTO user (nama, username, password, role) VALUES ('$nama', '$username', '$hash', '$role')";
        if (mysqli_query($koneksi, $query)) {
            header("Location: register.php?pesan=register_sukses");
            exit();
        } else {
            header("Location: register.php?pesan=register_gagal");
            exit();
        }
    } else {
        header("Location: register.php?pesan=form_kosong");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Register - Resto App</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-br from-blue-100 to-purple-200 min-h-screen flex items-center justify-center">

    <div class="w-full max-w-sm bg-white rounded-xl shadow-lg p-8">
        <h2 class="text-3xl font-bold text-center text-indigo-700 mb-6">👨‍🍳 Daftar Pelayan</h2>

        <?php if (isset($_GET['pesan'])): ?>
            <div class="mb-4 text-sm px-4 py-3 rounded
                <?php if ($_GET['pesan'] === 'register_sukses') echo 'bg-green-100 border border-green-400 text-green-700';
                elseif ($_GET['pesan'] === 'register_gagal') echo 'bg-red-100 border border-red-400 text-red-700';
                elseif ($_GET['pesan'] === 'form_kosong') echo 'bg-yellow-100 border border-yellow-400 text-yellow-800'; ?>">
                <?php
                if ($_GET['pesan'] === 'register_sukses') echo '✅ Registrasi berhasil! Mengalihkan ke login...';
                elseif ($_GET['pesan'] === 'register_gagal') echo '❌ Registrasi gagal. Coba lagi.';
                elseif ($_GET['pesan'] === 'form_kosong') echo '⚠️ Semua kolom wajib diisi.';
                ?>
            </div>
            <?php if ($_GET['pesan'] === 'register_sukses'): ?>
                <script>
                    setTimeout(() => {
                        window.location.href = 'login.php';
                    }, 2000);
                </script>
            <?php endif; ?>
        <?php endif; ?>

        <form action="register.php" method="POST" onsubmit="return validateForm();">
            <div class="mb-4">
                <label class="block text-gray-700 text-sm mb-1" for="nama">Nama Lengkap</label>
                <input id="nama" name="nama" type="text" required
                    class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring focus:border-blue-400"
                    placeholder="Masukkan nama">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm mb-1" for="username">Username</label>
                <input id="username" name="username" type="text" required
                    class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring focus:border-blue-400"
                    placeholder="Buat username">
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 text-sm mb-1" for="password">Password</label>
                <input id="password" name="password" type="password" required
                    class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring focus:border-blue-400"
                    placeholder="Buat password">
            </div>

            <button type="submit"
                class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded">
                Daftar Sekarang
            </button>
        </form>

        <p class="text-center text-sm text-gray-600 mt-5">
            Sudah punya akun?
            <a href="login.php" class="text-indigo-600 hover:underline font-medium">Login di sini</a>
        </p>
    </div>

    <script>
        function validateForm() {
            const nama = document.getElementById('nama').value.trim();
            const username = document.getElementById('username').value.trim();
            const password = document.getElementById('password').value.trim();

            if (!nama || !username || !password) {
                alert('Semua kolom wajib diisi!');
                return false;
            }
            return true;
        }
    </script>

</body>

</html>