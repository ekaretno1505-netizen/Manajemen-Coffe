<?php

session_start();
include('koneksi.php');

if(isset($_POST['cek_login'])){
    $username = $_POST['username'];
    $password = $_POST['password'];

    if(empty($username) && empty($password)){
        $error = 'Harap isi username dan password';
    }elseif(empty($username)){
        $error = 'Harap isi username';
    }
    elseif(empty($password)){
        $error = 'Harap isi password';
    }else{
        $user = mysqli_query($koneksi,"SELECT * FROM tb_user WHERE user_username='$username'") or die(mysqli_error($koneksi));
        if(mysqli_num_rows($user)!=0){
            $data = mysqli_fetch_array($user);
                if(password_verify($password,$data['user_password'])){
                    $_SESSION['id'] = $data['user_id'];
                    $_SESSION['nama'] = $data['user_nama'];
                    $_SESSION['username'] = $data['user_username'];
                    $_SESSION['level'] = $data['user_level'];
                    $_SESSION['user_foto'] = $data['user_foto'];
                    $_SESSION['timestamp'] = time();
                    
                    if($data['user_level'] == "admin"){
                        $_SESSION['status'] = "administrator_logedin";
                        header("location:/apk_coffe/admin/");
                    }else if($data['user_level'] == "kasir"){
                        $_SESSION['status'] = "kasir_logedin";
                        header("location:/apk_coffe/kasir/");
                    }else{
                        header("location:/apk_coffe/login?gagallogin");
                    }
                }else{
                    $error = 'Password anda salah';
                }
        }else{
            $error= 'Username tidak terdaftar';
        }
    }
    $_SESSION['error'] = $error;
}

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        Login Coffee Shop
    </title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>

        *{
            font-family:'Poppins',sans-serif;
        }

        body{
            margin:0;
            padding:0;
            min-height:100vh;

            background:
            linear-gradient(rgba(40,25,15,0.75), rgba(40,25,15,0.75)),
            url('https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?q=80&w=1600&auto=format&fit=crop');

            background-size:cover;
            background-position:center;

            display:flex;
            justify-content:center;
            align-items:center;

            overflow:hidden;
        }

        .login-box{
            width:100%;
            max-width:430px;

            background:rgba(255,255,255,0.1);

            backdrop-filter:blur(12px);

            border:1px solid rgba(255,255,255,0.15);

            padding:45px;

            border-radius:30px;

            box-shadow:0 10px 35px rgba(0,0,0,0.35);

            color:#fff;

            animation:fadeUp 0.7s ease;
        }

        @keyframes fadeUp{

            from{
                opacity:0;
                transform:translateY(40px);
            }

            to{
                opacity:1;
                transform:translateY(0);
            }

        }

        .coffee-icon{

            width:85px;
            height:85px;

            background:#6f4e37;

            display:flex;
            justify-content:center;
            align-items:center;

            border-radius:50%;

            margin:auto;

            font-size:35px;

            box-shadow:0 5px 20px rgba(0,0,0,0.3);
        }

        .title{
            text-align:center;
            margin-top:20px;
            margin-bottom:5px;
            font-size:32px;
            font-weight:700;
        }

        .subtitle{
            text-align:center;
            color:#e6d7cc;
            margin-bottom:35px;
            font-size:14px;
        }

        .form-label{
            color:#f3e9e2;
            font-weight:500;
            margin-bottom:8px;
        }

        .form-control{

            height:55px;

            border:none;

            border-radius:18px;

            background:rgba(255,255,255,0.15);

            color:#fff;

            padding-left:18px;
        }

        .form-control:focus{

            background:rgba(255,255,255,0.2);

            box-shadow:none;

            border:1px solid #c8a27a;

            color:#fff;
        }

        .form-control::placeholder{
            color:#ddd;
        }

        .btn-login{

            width:100%;

            height:55px;

            border:none;

            border-radius:18px;

            background:#c08b5c;

            color:#fff;

            font-weight:600;

            font-size:17px;

            transition:0.3s;

            margin-top:10px;
        }

        .btn-login:hover{

            background:#9b6b43;

            transform:translateY(-2px);
        }

        .extra{
            text-align:center;
            margin-top:25px;
            color:#eee;
            font-size:14px;
        }

        .coffee-bean{

            position:absolute;

            opacity:0.08;

            font-size:120px;

            color:#fff;
        }

        .bean1{
            top:40px;
            left:40px;
            transform:rotate(-20deg);
        }

        .bean2{
            bottom:30px;
            right:40px;
            transform:rotate(20deg);
        }

    </style>

</head>

<body>

    <div class="coffee-bean bean1">
        ☕
    </div>

    <div class="coffee-bean bean2">
        ☕
    </div>

    <div class="login-box">

        <div class="coffee-icon">
            ☕
        </div>

        <h1 class="title">
            Coffee Login
        </h1>

        <p class="subtitle">
            Selamat datang kembali di Coffee Shop
        </p>

        <form method="POST">

            <div class="mb-3">

                <label class="form-label">
                    Username
                </label>

                <input type="text"
                       name="username"
                       class="form-control"
                       placeholder="Masukkan username">

            </div>

            <div class="mb-4">

                <label class="form-label">
                    Password
                </label>

                <input type="password"
                       name="password"
                       class="form-control"
                       placeholder="Masukkan password">

            </div>

            <button type="submit"
                    class="btn-login"
                    name="cek_login">

                Login Sekarang

            </button>

        </form>

        <div class="extra">
            Made with ☕ for coffee lovers
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <?php if(isset($_SESSION['error'])){ ?>

    <script>

    Swal.fire({
        icon: 'error',
        title: 'Login Gagal',
        text: '<?= $_SESSION['error']; ?>',
        confirmButtonColor: '#6f4e37'
    });

    </script>

    <?php unset($_SESSION['error']); } ?>

    <script>
        const urlParams = new URLSearchParams(window.location.search);
        const logout = urlParams.get('logout');

        if(logout === 'success'){
            Swal.fire({
                icon: 'success',
                title: 'Berhasil Logout',
                text: 'Sampai jumpa lagi 👋',
                confirmButtonColor: '#6D4C41'
            });
        }
        </script>

<script>
const urlParams = new URLSearchParams(window.location.search);
const alertType = urlParams.get('alert');

if(alertType === 'login'){
    Swal.fire({
        icon: 'warning',
        title: 'Login Diperlukan',
        text: 'Anda harus login terlebih dahulu',
        confirmButtonColor: '#6D4C41'
    });
}

if(alertType === 'timeout'){
    Swal.fire({
        icon: 'error',
        title: 'Session Habis',
        text: '30 menit telah berakhir, silakan login kembali',
        confirmButtonColor: '#6D4C41'
    });
}
</script>
</body>

</html>