<?php
$koneksi = mysqli_connect(
    "localhost",
    "root",
    "",
    "coffe"
);

if(!$koneksi){
    die("Koneksi gagal");
}

?>