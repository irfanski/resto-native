<?php
session_start();
require '../config/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $username_escaped = mysqli_real_escape_string($koneksi, $username);

    $sql = "SELECT * FROM user WHERE username = '$username_escaped'";
    $result = mysqli_query($koneksi, $sql);

    if ($result && mysqli_num_rows($result) === 1) {
        $user = mysqli_fetch_assoc($result);

        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id_user'];
            $_SESSION['user_nama'] = $user['nama'];
            $_SESSION['user_role'] = $user['role'];
            $_SESSION['username'] = $user['username'];

            header("Location: ../index.php");
            exit();
        } else {
            header("Location: ../login.php?error=password_salah");
            exit();
        }
    } else {
        header("Location: ../login.php?error=username_tidak_ditemukan");
        exit();
    }
} else {
    header("Location: ../login.php?error=metode_tidak_valid");
    exit();
}
