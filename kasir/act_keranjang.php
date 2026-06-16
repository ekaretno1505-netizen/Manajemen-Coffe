<?php
session_start();
include '../koneksi.php';

$menu_id = $_POST['menu_id'];
$size = $_POST['menu_size'];
$qty = $_POST['qty'];
$subtotal = $_POST['subtotal'];

if(!$menu_id || !$size || !$subtotal){
    die("Data tidak lengkap");
}

// CEK DUPLIKAT
$cek = mysqli_query($koneksi, "SELECT * FROM tb_keranjang WHERE menu_id='$menu_id' AND menu_size='$size'");

if(mysqli_num_rows($cek) > 0){

    mysqli_query($koneksi, "UPDATE tb_keranjang SET qty = qty + 1, subtotal = subtotal + $subtotal WHERE menu_id='$menu_id' AND menu_size='$size'
    ");

}else{

    mysqli_query($koneksi, "INSERT INTO tb_keranjang(menu_id, menu_size, qty, subtotal) VALUES('$menu_id','$size','$qty','$subtotal')");
}
$_SESSION['success'] = "Data berhasil ditambahkan";