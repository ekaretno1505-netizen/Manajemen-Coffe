<?php
session_start();
include '../koneksi.php';

$id = $_GET['id'];

mysqli_query($koneksi, "DELETE FROM tb_keranjang");
header("location:/apk_coffe/kasir/pesanan?berhasildihapus");
$_SESSION['success'] = "Data berhasil dihapus";
exit;

?>