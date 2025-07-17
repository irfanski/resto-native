<?php
require '../../config/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];

    mysqli_query($koneksi, "INSERT INTO user (nama, username, password, role)
        VALUES ('$nama', '$username', '$password', '$role')");
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Tambah User</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        * {
            font-family: 'Inter', sans-serif;
        }

        body {
            background: linear-gradient(135deg, #e0f7fa, #fce4ec);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 40px 20px;
        }

        .glass-card {
            backdrop-filter: blur(20px);
            background: rgba(255, 255, 255, 0.6);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 20px;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.08);
            padding: 40px;
            width: 100%;
            max-width: 500px;
            animation: fadeIn 0.6s ease;
        }

        .form-title {
            font-weight: 700;
            font-size: 1.8rem;
            text-align: center;
            color: #1976d2;
            margin-bottom: 30px;
        }

        label {
            font-weight: 600;
            color: #444;
        }

        .form-control,
        .form-select {
            border-radius: 10px;
            padding: 10px 15px;
            transition: all 0.3s;
        }

        .form-control:focus,
        .form-select:focus {
            box-shadow: 0 0 0 3px rgba(25, 118, 210, 0.2);
            border-color: #1976d2;
        }

        .btn-success {
            background: #1976d2;
            border: none;
            border-radius: 10px;
            font-weight: 600;
        }

        .btn-success:hover {
            background: #1565c0;
        }

        .btn-secondary {
            background: #e0e0e0;
            color: #333;
            border-radius: 10px;
            font-weight: 600;
        }

        .btn-secondary:hover {
            background: #cfd8dc;
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

<body>
    <div class="glass-card">
        <div class="form-title">🧑‍💼 Tambah User Baru</div>
        <form method="POST" autocomplete="off">
            <div class="mb-3">
                <label for="nama" class="form-label">Nama Lengkap</label>
                <input type="text" name="nama" id="nama" class="form-control" placeholder="Masukkan nama lengkap" required>
            </div>
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" name="username" id="username" class="form-control" placeholder="Buat username unik" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" id="password" class="form-control" placeholder="Buat password" required>
            </div>
            <div class="mb-4">
                <label for="role" class="form-label">Peran (Role)</label>
                <select name="role" id="role" class="form-select" required>
                    <option value="" disabled selected>Pilih role</option>
                    <option value="admin">Admin</option>
                    <option value="pelayan">Pelayan</option>
                    <option value="koki">Koki</option>
                    <option value="kasir">Kasir</option>
                </select>
            </div>
            <div class="d-flex justify-content-between">
                <a href="index.php" class="btn btn-secondary px-4">Batal</a>
                <button type="submit" class="btn btn-success px-4">Simpan</button>
            </div>
        </form>
    </div>
</body>

</html>