<?php
session_start();


@$page = $_GET['page'];

/// =======================
// ROUTE HALAMAN
// =======================

switch ($page) {

    // =======================
    // ADMIN
    // =======================

    case 'admin':
        include "../admin/index.php";
        break;

    case 'admin-menu':
        include "../admin/menu.php";
        break;

    case 'admin-pengeluaran':
        include "../admin/pengeluaran.php";
        break;

    // =======================
    // KASIR
    // =======================

    case 'kasir':
        include "../kasir/index.php";
        break;

    case 'kasir-pesanan':
        include "../kasir/pesanan.php";
        break;

    // =======================
    // DEFAULT
    // =======================

    default:
        include "index.php";
        break;
}
?>