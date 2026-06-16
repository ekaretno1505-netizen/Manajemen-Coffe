<?php
session_start();
include '../koneksi.php';
$nama  = $_POST['nama'];
$keterangan  = $_POST['keterangan'];
$kategori  = $_POST['kategori'];
$total  = $_POST['total'];

$rand = rand();
$allowed =  array('jpg','jpeg','pdf');
$filename = $_FILES['trnfoto']['name'];

if($filename == ""){
	mysqli_query($koneksi, "INSERT INTO tb_pengeluaran VALUES (NULL,'$nama','$kategori','$total','$keterangan','', NOW())")or die(mysqli_error($koneksi));
	$_SESSION['success'] = "Data berhasil ditambahkan";
    header("location:/apk_coffe/admin/pengeluaran?success");
	exit;
}else{
	$ext = pathinfo($filename, PATHINFO_EXTENSION);

	if(!in_array($ext,$allowed) ) {
        $_SESSION['error'] = "Data tidak bisa disimpan";
		header("location:/apk_coffe/admin/pengeluaran?alert=gagal");
		exit;
	}else{
		move_uploaded_file($_FILES['trnfoto']['tmp_name'], '../gambar/bukti/'.$rand.'_'.$filename);
		$file_gambar = $rand.'_'.$filename;
		mysqli_query($koneksi, "INSERT INTO tb_pengeluaran VALUES (NULL,'$nama','$kategori','$total','$keterangan', '$file_gambar', NOW())")or die(mysqli_error($koneksi));
		$_SESSION['success'] = "Data berhasil ditambahkan";
        header("location:/apk_coffe/admin/pengeluaran?alert=success");
		exit;
	}
}