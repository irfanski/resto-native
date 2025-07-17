<?php
$host = 'localhost';
$user = 'root';
$pass = ''; 
$db   = 'resto_native_db';
$port = 3307; // kalo pake port 3306 ga perlu ini

$koneksi = mysqli_connect($host, $user, $pass, $db, $port);


if (!$koneksi) {
    die('Koneksi gagal: ' . mysqli_connect_error());
}
