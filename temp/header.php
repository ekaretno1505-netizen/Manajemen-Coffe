<?php
include '../koneksi.php';
session_start();
if (!isset($_SESSION['id'])) {
    $_SESSION['error'] = 'Anda harus login!';
    header("location:/apk_coffe/login?gagallogin");
    exit;
}

elseif(time() - $_SESSION['timestamp'] > 1800) {

    unset($_SESSION['username'], $_SESSION['password'], $_SESSION['timestamp']);
    $_SESSION['logged_in'] = false;

    $_SESSION['error'] = '30 menit telah berakhir! Anda harus login kembali!';
    header("location:/apk_coffe/login?timeout");
    exit;

} else {
    $_SESSION['timestamp'] = time();
}
$url = $_SERVER['REQUEST_URI'];

 $id_user = $_SESSION['id'];
 $profil = mysqli_query($koneksi,"select * from tb_user where user_id='$id_user'");
 $profil = mysqli_fetch_assoc($profil);
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
  <link href="../boostrap/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <script type="text/javascript">
        window.onload = function() { jam(); }
       
        function jam() {
            var e = document.getElementById('jam'),
            d = new Date(), h, m, s;
            h = d.getHours();
            m = set(d.getMinutes());
            s = set(d.getSeconds());
       
            e.innerHTML = h +':'+ m +':'+ s;
       
            setTimeout('jam()', 1000);
        }
       
        function set(e) {
            e = e < 10 ? '0'+ e : e;
            return e;
        }
</script>
</head>
<body>

<div class="container-fluid">
  <div class="row">

    <!-- SIDEBAR -->
    <div class="col-lg-1 sidebar d-flex flex-lg-column flex-row justify-content-between align-items-center py-3">

      <div class="logo">
        ☕
      </div>
        <?php if($_SESSION['level'] == "admin"){ ?>
            <div class="menu-sidebar d-flex flex-lg-column gap-4 align-items-center">
                <a href="/apk_coffe/admin" class="<?= ($url == '/apk_coffe/admin' || $url == '/apk_coffe/admin/') ? 'active' : '' ?>">
                    <i class="fa-solid fa-house"></i>
                </a>
                <a href="/apk_coffe/admin/menu" class="<?= (strpos($url, '/apk_coffe/admin/menu') !== false) ? 'active' : '' ?>">
                    <i class="fa-regular fa-star"></i>
                </a>
                <a href="/apk_coffe/admin/transaksi" class="<?= (strpos($url, '/apk_coffe/admin/transaksi') !== false) ? 'active' : '' ?>">
                    <i class="fa-solid fa-bars"></i>
                </a>
                <a href="/apk_coffe/admin/pengeluaran" class="<?= (strpos($url, '/apk_coffe/admin/pengeluaran') !== false) ? 'active' : '' ?>">
                    <i class="fa-solid fa-wallet"></i>
                </a>
                <a href="/apk_coffe/admin/user" class="<?= (strpos($url, '/apk_coffe/admin/user') !== false) ? 'active' : '' ?>">
                    <i class="fa-regular fa-user"></i>
                </a>
            </div>
        <?php } elseif($_SESSION['level'] == "kasir"){ ?>
            <div class="menu-sidebar d-flex flex-lg-column gap-4 align-items-center">
                <a href="/apk_coffe/kasir" class="<?= ($url == '/apk_coffe/kasir' || $url == '/apk_coffe/kasir/') ? 'active' : '' ?>">
                    <i class="fa-solid fa-house"></i>
                </a>
                <a href="/apk_coffe/kasir/pesanan" class="<?= (strpos($url, '/apk_coffe/kasir/pesanan') !== false) ? 'active' : '' ?>">
                    <i class="fa-regular fa-star"></i>
                </a>    
                <a href="/apk_coffe/kasir/transaksi">
                    <i class="fa-solid fa-bars"></i>
                </a>
                <a href="/apk_coffe/kasir/user">
                    <i class="fa-regular fa-user"></i>
                </a>
            </div>
      <?php }else{
          if($_SESSION['level'] == ""){
          $_SESSION['error'] = 'Anda harus login!';
          header("location:/apk_coffe/login?gagallogin");
          exit;
          }
        } ?>
            <a href="#" onclick="logout()" class="<?= ($url == '/apk_coffe/logout' || $url == '/apk_coffe/logout') ? 'active' : '' ?>"><i class="fa-solid fa-right-from-bracket"></i></a>
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
          <input type="text" placeholder="Cari">
          <i class="fa-solid fa-magnifying-glass"></i>
        </div>

        <div class="d-flex align-items-center gap-3">
           <i class="fa-regular fa-bell fs-4"></i>
            <div class="dropdown">

                <div class="d-flex align-items-center gap-2" role="button" data-bs-toggle="dropdown" aria-expanded="false">

                    <!-- ICON / AVATAR -->
                    
                    <?php 
                        if($profil['user_foto'] == ""){
                    ?>
                        <img class="img-profile rounded-circle" width="50" height="50" src="../gambar/user/user.png" >
                    <?php } else { ?>
                        <img class="img-profile rounded-circle" width="50" height="50" src="../gambar/user/<?php echo $profil['user_foto'] ?>">
                    <?php } ?>

                    <!-- NAMA -->
                    <div class="text-start">
                        <div class="fw-semibold">
                            <?php echo $_SESSION['nama']; ?>
                        </div>

                        <span class="badge bg-secondary">
                            <?php echo $_SESSION['level']; ?>
                        </span>
                    </div>

                </div>

                <ul class="dropdown-menu shadow-sm mt-2">

                    <li>
                        <?php if($_SESSION['level'] == "admin"){ ?>
                        <a class="dropdown-item" href="/apk_coffe/admin/profile">
                            <i class="fa-regular fa-user me-2"></i> Lihat Profil
                        </a>
                        <?php } elseif($_SESSION['level'] == "kasir"){?>
                            <a class="dropdown-item" href="/apk_coffe/kasir/profile">
                            <i class="fa-regular fa-user me-2"></i> Lihat Profil
                        </a>
                        <?php } ?>

                    </li>

                    <li><hr class="dropdown-divider"></li>

                    <li>
                        <a class="dropdown-item text-danger" href="/apk_coffe/logout.php">
                            <i class="fa-solid fa-right-from-bracket me-2"></i> Logout
                        </a>
                    </li>

                </ul>

            </div>
          

          <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
function logout() {
    Swal.fire({
        title: 'Yakin mau logout?',
        text: "Kamu akan keluar dari sistem!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#6D4C41',
        cancelButtonColor: '#aaa',
        confirmButtonText: 'Ya, Logout',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = '/apk_coffe/logout';
        }
    });
}
</script>