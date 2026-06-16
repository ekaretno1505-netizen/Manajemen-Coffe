<?php
include '../koneksi.php';
session_start();
$id = $_GET['id'];

$query = mysqli_query($koneksi, "SELECT menu_gambar FROM tb_menu WHERE menu_id='$id'");
$data = mysqli_fetch_array($query);

$foto = $data['menu_gambar'];

if($foto != "" && file_exists("../gambar/menu".$foto)){
    unlink("../gambar/".$foto);
}

$hapus = mysqli_query($koneksi, "DELETE FROM tb_menu WHERE menu_id='$id'");

if($hapus){
  $_SESSION['success'] = "Data menu berhasil dihapus";
  header("location:/apk_coffe/admin/menu?alert=success");
  exit;
}else{
  $_SESSION['error'] = "Data tidak bisa disimpan";
	header("location:/apk_coffe/admin/menu?alert=gagal");
  exit;
}
?>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


