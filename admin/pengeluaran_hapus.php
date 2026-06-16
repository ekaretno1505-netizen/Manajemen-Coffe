<?php
session_start();
include '../koneksi.php';

$id = $_GET['id'];

$query = mysqli_query($koneksi, "SELECT bukti_foto FROM tb_pengeluaran WHERE pengeluaran_id='$id'");
$data = mysqli_fetch_array($query);

$foto = $data['bukti_foto'];

if($foto != "" && file_exists("../gambar/bukti/".$foto)){
    unlink("../gambar/bukti".$foto);
}

$hapus = mysqli_query($koneksi, "DELETE FROM tb_pengeluaran WHERE pengeluaran_id='$id'");

if($hapus){
  $_SESSION['success'] = "Data menu berhasil dihapus";
  header("location:/apk_coffe/admin/pengeluaran?alert=success");
  exit;
}else{
  $_SESSION['error'] = "Data tidak bisa disimpan";
	header("location:/apk_coffe/admin/pengeluaran?alert=gagal");
  exit;
}
?>
