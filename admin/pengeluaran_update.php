<?php 
session_start();
include '../koneksi.php';
$id  = $_POST['id'];
$nama  = $_POST['nama'];
$keterangan  = $_POST['keterangan'];
$kategori  = $_POST['kategori'];
$total  = $_POST['total'];

$rand = rand();
$allowed =  array('jpg','jpeg','pdf');
$filename = $_FILES['trnfoto']['name'];
$ext = pathinfo($filename, PATHINFO_EXTENSION);

if($filename == ""){
	mysqli_query($koneksi,"UPDATE tb_pengeluaran SET nama_pengeluaran='$nama', kategori_pengeluaran='$kategori', total_pengeluaran='$total', keterangan='$keterangan', created_at = NOW() WHERE pengeluaran_id='$id'") or die(mysqli_error($koneksi));
    $_SESSION['success'] = "Data menu berhasil dihapus";
	header("location:/apk_coffe/admin/pengeluaran?alert=berhasilupdate");
	exit;
}else{
	if(!in_array($ext,$allowed) ) {
		$_SESSION['success'] = "Data menu berhasil diupdate";
		header("location:/apk_coffe/admin/pengeluaran?alert=gagal");
		exit;
		exit;
	}else{
		move_uploaded_file($_FILES['trnfoto']['tmp_name'], '../gambar/bukti/'.$rand.'_'.$filename);
		$xgambar = $rand.'_'.$filename;
		mysqli_query($koneksi,"UPDATE tb_pengeluaran SET nama_pengeluaran='$nama', kategori_pengeluaran='$kategori', total_pengeluaran='$total', keterangan='$keterangan', bukti_foto='$xgambar', created_at = NOW() WHERE pengeluaran_id='$id'") or die(mysqli_error($koneksi));
		header("location:/apk_coffe/admin/pengeluaran?alert=berhasilupdate");
		exit;
	}
}
?>