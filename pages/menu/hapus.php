<?php
require '../../config/koneksi.php';

$id = $_GET['id'];
mysqli_query($koneksi, "DELETE FROM menu WHERE id_menu = '$id'");
header("Location: index.php");
exit();
