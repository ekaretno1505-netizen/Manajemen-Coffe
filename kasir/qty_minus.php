<?php

include '../koneksi.php';

$id = $_GET['id'];

$data = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM tb_keranjang WHERE keranjang_id = '$id'"));

$harga = $data['subtotal'] / $data['qty'];
$qty = $data['qty'] - 1;

if($qty <= 0){
    mysqli_query($koneksi, "DELETE FROM tb_keranjang WHERE keranjang_id = '$id'");
}else{
    $subtotal = $qty * $harga;
    mysqli_query($koneksi, "UPDATE tb_keranjang SET qty = '$qty', subtotal = '$subtotal' WHERE keranjang_id = '$id'");
}
header("location:/apk_coffe/kasir/pesanan?qty-");

?>