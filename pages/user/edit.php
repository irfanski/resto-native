<?php
require '../../config/koneksi.php';

$id = $_GET['id'];
$result = mysqli_query($koneksi, "SELECT * FROM user WHERE id_user = '$id'");
$data = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama'];
    $username = $_POST['username'];
    $role = $_POST['role'];

    if (!empty($_POST['password'])) {
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        mysqli_query($koneksi, "UPDATE user SET nama='$nama', username='$username', password='$password', role='$role' WHERE id_user='$id'");
    } else {
        mysqli_query($koneksi, "UPDATE user SET nama='$nama', username='$username', role='$role' WHERE id_user='$id'");
    }

    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Edit User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #f5f7fa, #c3cfe2);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .card {
            border: none;
            border-radius: 1rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background: #6c5ce7;
            color: white;
            font-size: 1.25rem;
            font-weight: 600;
            border-top-left-radius: 1rem;
            border-top-right-radius: 1rem;
        }

        .form-label {
            font-weight: 500;
        }

        .btn-primary {
            background-color: #6c5ce7;
            border: none;
        }

        .btn-primary:hover {
            background-color: #5a4bd1;
        }

        .btn-secondary {
            background-color: #dfe6e9;
            color: #2d3436;
            border: none;
        }

        .btn-secondary:hover {
            background-color: #b2bec3;
        }
    </style>
</head>

<body>
    <div class="container py-5 d-flex justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card">
                <div class="card-header text-center">
                    ✏️ Edit User
                </div>
                <div class="card-body p-4">
                    <form method="POST">
                        <div class="mb-3">
                            <label class="form-label">Nama</label>
                            <input type="text" name="nama" class="form-control" value="<?= $data['nama'] ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Username</label>
                            <input type="text" name="username" class="form-control" value="<?= $data['username'] ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password (Kosongkan jika tidak diubah)</label>
                            <input type="password" name="password" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Role</label>
                            <select name="role" class="form-select" required>
                                <option value="admin" <?= $data['role'] == 'admin' ? 'selected' : '' ?>>Admin</option>
                                <option value="pelayan" <?= $data['role'] == 'pelayan' ? 'selected' : '' ?>>Pelayan</option>
                                <option value="koki" <?= $data['role'] == 'koki' ? 'selected' : '' ?>>Koki</option>
                                <option value="kasir" <?= $data['role'] == 'kasir' ? 'selected' : '' ?>>Kasir</option>
                            </select>
                        </div>
                        <div class="d-flex justify-content-between">
                            <a href="index.php" class="btn btn-secondary">← Batal</a>
                            <button type="submit" class="btn btn-primary">💾 Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>