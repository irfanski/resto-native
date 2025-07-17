<?php
session_start();
// Jika tidak ada session user_id, artinya belum login
if (!isset($_SESSION['user_id'])) {
    header("Location: /resto-native/login.php"); // Sesuai dengan nama folder kamu
    exit();
}
