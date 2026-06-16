<?php
include '../koneksi.php';
session_start();

$id_user  = $_POST['id'];
$nama     = $_POST['nama'];
$username = $_POST['username'];
$password = $_POST['password'];
$nomor    = $_POST['nomor'];
$level    = $_POST['level'];

$rand = rand();
$allowed = array('jpg', 'jpeg', 'png', 'pdf');
$filename = $_FILES['trnfoto']['name'];

// QUERY DASAR
$query = "UPDATE tb_user SET 
            user_nama = '$nama',
            user_username = '$username',
            user_nomor = '$nomor',
            user_level = '$level'";

// CEK PASSWORD
if($password != ""){
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    $query .= ",
        password = '$password_hash'";
}

// CEK FOTO
if($filename != ""){

    $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

    if(!in_array($ext, $allowed)){
        $_SESSION['error'] = "Format file tidak didukung";
        
        if($level == "admin"){
            header("Location: /apk_coffe/admin/profile");
        }else{
            header("Location: /apk_coffe/kasir/profile");
        }

        exit;
    }

    $foto_baru = $rand . '_' . $filename;

    move_uploaded_file(
        $_FILES['trnfoto']['tmp_name'],
        '../gambar/user/' . $foto_baru
    );

    $query .= ",
        user_foto = '$foto_baru'";
}

// WHERE
$query .= " WHERE user_id = '$id_user'";

// EKSEKUSI
mysqli_query($koneksi, $query) or die(mysqli_error($koneksi));

$_SESSION['success'] = "Data user berhasil diupdate";

header("location:/apk_coffe/admin/user?alert=berhasilupdate");

exit;
?>