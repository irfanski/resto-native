<?php
require '../../config/koneksi.php';

$no_meja = $_GET['no'];
mysqli_query($koneksi, "DELETE FROM meja WHERE no_meja = '$no_meja'");

header("Location: index.php");
exit();
