<?php
require '../../config/koneksi.php';

$id = $_GET['id'];
mysqli_query($koneksi, "DELETE FROM user WHERE id_user = '$id'");
header("Location: index.php");
exit();
