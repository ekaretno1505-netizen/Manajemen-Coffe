<?php
include '../koneksi.php';
session_start();
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Coffe Etam</title>

  <!-- Bootstrap Offline -->
  <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
   <link rel="stylesheet" href="../bootstrap/css/style.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

</head>
<body>

<div class="container-fluid">
  <div class="row">

    <!-- SIDEBAR -->
    <div class="col-lg-1 sidebar d-flex flex-lg-column flex-row justify-content-between align-items-center py-3">

      <div class="logo">
        ☕
      </div>

      <div class="d-flex flex-lg-column gap-4 align-items-center">
        <a href="../admin/index.php"><i class="fa-solid fa-house active"></i></a>
        <a href="../admin/menu.php"><i class="fa-regular fa-star"></i></a>
        <a href="../admin/pengeluaran.php"><i class="fa-solid fa-wallet"></i></a>
        <i class="fa-solid fa-bars"><a href=""></a></i>
        <i class="fa-regular fa-user"><a href=""></a></i>
      </div>

      <i class="fa-solid fa-right-from-bracket"></i>

    </div>

    <!-- CONTENT -->
    <div class="col-lg-11 p-4 text-white">

      <!-- HEADER -->
      <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">

        <div>
          <small>Selamat datang di Coffe Etam Dashboard!</small>
          <h1 class="fw-bold">Always give the best service</h1>
        </div>

        <div class="search-box d-flex align-items-center col-lg-4">
          <input type="text" placeholder="cari menu">
          <i class="fa-solid fa-magnifying-glass"></i>
        </div>

        <div class="d-flex align-items-center gap-3">
          <i class="fa-regular fa-bell fs-4"></i>

          <img src="https://ar.pinterest.com/pin/334040497374439268/"
          width="50"
          height="50"
          class="rounded-circle">

          <div>
            <small>admin</small>
            <h6>Diego</h6>
          </div>
</div>
</div>
<hr>

<!-- CATEGORY -->
<div class="d-flex flex-wrap gap-3 mb-4">
  <?php include '../temp/kategori.php'; ?>
</div>

<?php
$totalHarga = 0;
$totalItem  = 0;

$keranjang = mysqli_query($koneksi, "
    SELECT tb_keranjang.*, tb_menu.menu_nama 
    FROM tb_keranjang 
    JOIN tb_menu ON tb_keranjang.menu_id = tb_menu.menu_id 
    ORDER BY keranjang_id DESC
");

$isEmpty = (mysqli_num_rows($keranjang) == 0);
?>

<div class="row">

<!-- MENU -->
<div class="col-lg-8">
    <h1 class="mb-4">Menu <?= $kategori ?></h1>

    <div class="row g-4">
        <?php while($d = mysqli_fetch_array($data)){ ?>
        <div class="col-md-6">
            <div class="menu-card" data-id="<?= $d['menu_id'] ?>">

                <div class="d-flex gap-3">
                    <img src="https://images.unsplash.com/photo-1509042239860-f550ce710b93" width="80" class="rounded-4">

                    <div>
                        <h5><?= $d['menu_nama'] ?></h5>
                        <p class="small text-muted"><?= $d['menu_desk'] ?></p>
                    </div>
                </div>

                <hr>

                <!-- SIZE -->
                <div class="d-flex gap-2 mb-3">
                    <?php if($d['menu_hargaM'] > 0){ ?>
                    <button type="button" class="size-btn"
                        data-size="M"
                        data-price="<?= $d['menu_hargaM'] ?>">
                        M
                    </button>
                    <?php } ?>

                    <?php if($d['menu_hargaL'] > 0){ ?>
                    <button type="button" class="size-btn"
                        data-size="L"
                        data-price="<?= $d['menu_hargaL'] ?>">
                        L
                    </button>
                    <?php } ?>
                </div>

                <!-- BUTTON -->
                <button type="button"
                        class="btn-order add-order"
                        data-name="<?= $d['menu_nama'] ?>">
                    Tambahkan ke Pesanan
                </button>

            </div>
        </div>
        <?php } ?>
    </div>
</div>


<!-- ORDER -->
<div class="col-lg-4 mt-4 mt-lg-0">
    <div class="order-box">
        <div class="d-flex justify-content-between mb-4">
            <h2>Pesanan</h2>
        </div>
    </div>
</div>

</div>
</div>
</div>


<!-- BOOTSTRAP -->
 <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>