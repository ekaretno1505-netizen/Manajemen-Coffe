<?php 
include '../koneksi.php';
session_start();
$id  = $_POST['id'];
$nama  = $_POST['nama'];
$desk  = $_POST['desk'];
$kat  = $_POST['kat'];
$hargaM  = $_POST['hargaM'];
$hargaL  = $_POST['hargaL'];
$stok = $_POST['stok'];


$rand = rand();
$allowed =  array('jpg','jpeg','pdf');
$filename = $_FILES['trnfoto']['name'];
$ext = pathinfo($filename, PATHINFO_EXTENSION);

if($filename == ""){
	mysqli_query($koneksi, "update tb_menu set menu_nama='$nama', menu_desk='$desk', menu_kategori='$kat', menu_hargaM='$hargaM', menu_hargaL='$hargaL', menu_stok='$stok' where menu_id='$id'") or die(mysqli_error($koneksi));
	$_SESSION['success'] = "Data menu berhasil diupdate";
	header("location:/apk_coffe/admin/menu?alert=berhasilupdate");
	exit;
}else{
	$ext = pathinfo($filename, PATHINFO_EXTENSION);

	if(!in_array($ext,$allowed) ) {
		header("location:/apk_coffe/admin/menu?alert=gagal");
		exit;
	}else{
		move_uploaded_file($_FILES['trnfoto']['tmp_name'], '../gambar/menu/'.$rand.'_'.$filename);
		$xgambar = $rand.'_'.$filename;
		mysqli_query($koneksi, "update tb_menu set menu_nama='$nama', menu_desk='$desk', menu_kategori='$kat', menu_hargaM='$hargaM', menu_hargaL='$hargaL', menu_stok='$stok', menu_gambar='$xgambar' where menu_id='$id'")or die(mysqli_error($koneksi));
		$_SESSION['success'] = "Data menu berhasil diupdate";
		header("location:/apk_coffe/admin/menu?alert=berhasilupdate");
		exit;
	}
}