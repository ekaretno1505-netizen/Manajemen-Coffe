<?php

include '../koneksi.php';

$menu_id    = $_POST['menu_id'];
$menu_size  = $_POST['menu_size'];
$qty        = $_POST['qty'];
$subtotal   = $_POST['subtotal'];

mysqli_query($koneksi, "UPDATE tb_keranjang SET qty = '$qty', subtotal = '$subtotal' WHERE menu_id = '$menu_id' AND menu_size = '$menu_size'");

?>