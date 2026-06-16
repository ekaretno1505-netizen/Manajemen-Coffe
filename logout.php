<?php
session_start();

/* kalau belum login */
if(!isset($_SESSION['username'])){
    header("Location: /apk_coffe/login?gagallogin");
    exit;
}

/* hapus session */
$_SESSION = [];
session_unset();
session_destroy();

/* redirect ke login dengan status */
header("Location: /apk_coffe/login?logout=success");
exit;
?>