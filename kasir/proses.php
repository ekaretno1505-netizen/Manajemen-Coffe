<?php
session_start();
include '../koneksi.php';

date_default_timezone_set('Asia/Jakarta');

$namap = $_POST['namap'];
$id = $_POST['id'];
$uang_bayar = $_POST['uang_bayar'];
$kembalian  = $_POST['kembalian'];

/* =========================
   BUAT ID PESANAN
=========================

FORMAT:
20260524-001
20260524-002

Besok reset lagi:
20260525-001

========================= */

$tanggal = date('Ymd');

/* ambil id terakhir hari ini */
$cek = mysqli_query($koneksi, "SELECT pesanan_id FROM tb_pesanan WHERE pesanan_id LIKE '$tanggal-%'ORDER BY pesanan_id DESC LIMIT 1");

if(mysqli_num_rows($cek) > 0){
    $data = mysqli_fetch_assoc($cek);
    // pecah id
    $pecah = explode('-', $data['pesanan_id']);
    // ambil nomor belakang
    $lastNumber = (int)$pecah[1];
    $urutan = $lastNumber + 1;
}else{
    $urutan = 1;
}

/* buat format 001 */
$nomor = str_pad($urutan, 3, '0', STR_PAD_LEFT);
/* gabungkan */
$pesanan_id = $tanggal . '-' . $nomor;

$qty = 0;
$total = 0;

$data_total = mysqli_query($koneksi, "
    SELECT * FROM tb_keranjang
");

while($t = mysqli_fetch_array($data_total)){

    $total += $t['subtotal'];
    $qty += $t['qty'];

}

mysqli_query($koneksi, "INSERT INTO tb_pesanan VALUES ('$pesanan_id', '$namap', '$qty', '$total', '$uang_bayar', '$id', NOW())");

$data = mysqli_query($koneksi, "SELECT tb_keranjang.*, tb_menu.menu_nama FROM tb_keranjang JOIN tb_menu ON tb_keranjang.menu_id = tb_menu.menu_id");

while($d = mysqli_fetch_array($data)){

    mysqli_query($koneksi, "INSERT INTO tb_detail_pesanan VALUES (NULL,'$pesanan_id', '".$d['menu_nama']."', '".$d['menu_size']."', '".$d['qty']."', '".$d['subtotal']."',NOW())");
}

mysqli_query($koneksi, "DELETE FROM tb_keranjang");

header("location:/apk_coffe/kasir/cetak_struk?id=$pesanan_id");
exit;

?>