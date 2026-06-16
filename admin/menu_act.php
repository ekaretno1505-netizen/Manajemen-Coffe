<?php
include '../koneksi.php';
session_start();

$nama  = $_POST['nama'];
$desk  = $_POST['desk'];
$kat  = $_POST['kat'];
$hargaM  = $_POST['hargaM'];
$hargaL  = $_POST['hargaL'];
$stok = $_POST['stok'];

$rand = rand();
$allowed =  array('jpg','jpeg','pdf');
$filename = $_FILES['trnfoto']['name'];

if($filename == ""){
	mysqli_query($koneksi, "INSERT INTO tb_menu VALUES (NULL,'$nama','$desk','$kat','$hargaM','$hargaL', '$stok', '', NOW())")or die(mysqli_error($koneksi));
    $_SESSION['success'] = "Data menu berhasil ditambahkan";
	header("location:/apk_coffe/admin/menu?alert=success");
	exit;
}else{
	$ext = pathinfo($filename, PATHINFO_EXTENSION);
	$_SESSION['error'] = "Format file tidak didukung";
	if(!in_array($ext,$allowed) ) {
        $_SESSION['error'] = "Data menu gagal ditambahkan";
		header("location:/apk_coffe/admin/menu?alert=gagal");
		exit;
	}else{
		move_uploaded_file($_FILES['trnfoto']['tmp_name'], '../gambar/menu/'.$rand.'_'.$filename);
		$file_gambar = $rand.'_'.$filename;
		mysqli_query($koneksi, "INSERT INTO tb_menu VALUES (NULL,'$nama','$desk','$kat','$hargaM','$hargaL', '$stok', '$file_gambar', NOW())")or die(mysqli_error($koneksi));
		$_SESSION['success'] = "Data menu berhasil ditambahkan";
        header("/apk_coffe/admin/menu?alert=success");
		exit;
	}
}