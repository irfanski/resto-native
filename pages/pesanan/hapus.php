<?php
require '../../config/koneksi.php';

$id = $_GET['id'];
mysqli_query($koneksi, "DELETE FROM pesanan WHERE id_pesanan = '$id'");
header("Location: index.php");
exit();
