<?php
include '../koneksi.php';

$id = $_GET['id'];

// ambil data pesanan
$pesanan = mysqli_query($koneksi, "SELECT * FROM tb_pesanan WHERE pesanan_id = '$id'");

$dataPesanan = mysqli_fetch_assoc($pesanan);

// ambil detail pesanan
$detail = mysqli_query($koneksi, "SELECT * FROM tb_detail_pesanan WHERE pesanan_id = '$id'");?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Cetak Struk</title>

<style>
body{
    font-family: monospace;
    background:#f5f5f5;
}

.struk{
    width:320px;
    background:white;
    padding:20px;
    margin:30px auto;
    border:1px solid #ddd;
}

.judul{
    text-align:center;
    margin-bottom:15px;
}

.judul h2{
    margin:0;
}

hr{
    border:0;
    border-top:1px dashed #999;
    margin:10px 0;
}

.item{
    margin-bottom:10px;
}

.flex{
    display:flex;
    justify-content:space-between;
}

.total{
    font-weight:bold;
    font-size:16px;
}

.center{
    text-align:center;
    margin-top:15px;
}
</style>
</head>
<body onload="window.print()">

<div class="struk">

    <div class="judul">
        <h2>Coffe Etam</h2>
        <small>Struk Pembayaran</small>
    </div>

    <hr>

    <div>
        <div class="flex">
            <span>ID Pesanan</span>
            <span>#<?= $dataPesanan['pesanan_id']; ?></span>
        </div>

        <div class="flex">
            <span>Nama</span>
            <span><?= $dataPesanan['pesanan_nama']; ?></span>
        </div>

        <div class="flex">
            <span>Total Item</span>
            <span><?= $dataPesanan['pesanan_totalitem']; ?></span>
        </div>
    </div>

    <hr>

    <?php while($d = mysqli_fetch_assoc($detail)) : ?>

        <div class="item">

            <strong><?= $d['detail_menu']; ?></strong>

            <div class="flex">
                <span>
                    <?= $d['detail_size']; ?> 
                    x<?= $d['detail_qty']; ?>
                </span>

                <span>
                    Rp <?= number_format($d['detail_harga']); ?>
                </span>
            </div>

        </div>

    <?php endwhile; ?>

    <hr>

    <div class="flex">
        <strong>Total</strong>
        <strong>
            Rp <?= number_format($dataPesanan['pesanan_totalharga']); ?>
        </strong>
    </div>
    <div class="flex">
        <strong>Total Bayar</strong>
        <strong>
            Rp <?= number_format($dataPesanan['pesanan_totbay']); ?>
        </strong>
    </div>
    <hr>
    <?php
    $kem = $dataPesanan['pesanan_totbay'] -  $dataPesanan['pesanan_totalharga'];
    ?>
    <div class="flex total">
        <span>Kembalian</span>
        <span>
            Rp <?= number_format($kem); ?>
        </span>
    </div>
    <div class="center">
        <p>Terima Kasih 🙏</p>
    </div>

</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
window.onafterprint = function(){

    Swal.fire({
        icon: 'success',
        title: 'Pembayaran Berhasil',
        text: 'Pesanan berhasil dicetak',
        confirmButtonText: 'OK'
    }).then(() => {

        window.location.href = '/apk_coffe/kasir/pesanan';

    });

}
</script>


</body>
</html>