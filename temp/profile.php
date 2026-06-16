<?php include '../temp/header.php';?>

</div>
</div>
<hr>
<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
            <!-- HEADER -->
            <div class="p-4 text-white" style="background:#6F4E37;">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-circle d-flex justify-content-center align-items-center" style="width:70px;height:70px;background:#ffffff22;">
                        <i class="fa-regular fa-user fs-2"></i>
                    </div>
                    <div>
                        <h3 class="mb-1 fw-bold">
                            Edit Profil
                        </h3>
                        <small style="color:#f5e6d3;">
                            Coffee Management System
                        </small>
                    </div>
                </div>
            </div>

            <?php
            $profil = mysqli_query($koneksi,"select * from tb_user where user_id='$id_user'");
            while($d = mysqli_fetch_array($profil)){
            ?>

            <!-- BODY -->
            <div class="card-body p-4">
                <form action="/apk_coffe/admin/profileupdate" method="POST" enctype="multipart/form-data">

                    <input type="hidden" name="user_id" value="<?= $d['user_id']; ?>">
                    <input type="hidden" name="level" value="<?= $d['user_level']; ?>">
                    <!-- FOTO -->
                    <div class="text-center mb-4">
                        <?php if($d['user_foto'] != ""){ ?>
                            <img src="../gambar/user/<?= $d['user_foto']; ?>" class="rounded-circle shadow" width="120" height="120"  style="object-fit:cover;">
                        <?php }else{ ?>
                            <div class="rounded-circle d-inline-flex justify-content-center align-items-center shadow" style="width:120px;height:120px;background:#6F4E37;color:white;">
                                <i class="fa-regular fa-user fs-1"></i>
                            </div>
                        <?php } ?>
                    </div>

                    <!-- FOTO UPLOAD -->
                    <div class="mb-4">
                        <label class="form-label fw-semibold">
                            Foto Profil
                        </label>
                        <input type="file" name="trnfoto" class="form-control py-3">
                        <small class="text-muted">
                            Format: JPG, JPEG, PNG, PDF
                        </small>
                    </div>

                    <!-- NAMA -->
                    <div class="mb-4">
                        <label class="form-label fw-semibold">
                            Nama Lengkap
                        </label>

                        <div class="input-group">

                            <span class="input-group-text bg-light border-0">
                                <i class="fa-regular fa-user"></i>
                            </span>

                            <input type="text" name="user_nama" class="form-control border-0 bg-light py-3" value="<?= $d['user_nama']; ?>" required>
                        </div>
                    </div>

                    <!-- USERNAME -->
                    <div class="mb-4">
                        <label class="form-label fw-semibold">
                            Username
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0">
                                <i class="fa-solid fa-at"></i>
                            </span>
                            <input type="text" name="username" class="form-control border-0 bg-light py-3" value="<?= $d['user_username']; ?>" required>
                        </div>
                    </div>

                    <!-- NOMOR -->
                    <div class="mb-4">
                        <label class="form-label fw-semibold">
                            Nomor HP
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0">
                                <i class="fa-solid fa-phone"></i>
                            </span>
                            <input type="text" name="nomor" class="form-control border-0 bg-light py-3" value="<?= $d['user_nomor']; ?>">
                        </div>
                    </div>

                    <!-- PASSWORD -->
                    <div class="mb-4">
                        <label class="form-label fw-semibold">
                            Password Baru
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0">
                                <i class="fa-solid fa-lock"></i>
                            </span>
                            <input type="password" name="password" class="form-control border-0 bg-light py-3" placeholder="Kosongkan jika tidak diganti">
                        </div>
                        <small class="text-muted">
                            Password lama tetap digunakan jika kosong
                        </small>

                    </div>

                    <!-- BUTTON -->
                    <div class="d-flex justify-content-end gap-2">

                        <a href="/apk_coffe/admin" class="btn btn-light px-4 py-2 rounded-3 border">
                            Kembali
                        </a>

                        <button type="submit" class="btn text-white px-4 py-2 rounded-3" style="background:#6F4E37;">
                            <i class="fa-solid fa-floppy-disk me-1"></i>
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
            <?php } ?>
        </div>
    </div>
</div>

</div>
</div>
</div>

<?php if(isset($_SESSION['success'])){ ?>

<script>
Swal.fire({
    icon: 'success',
    title: 'Sukses',
    text: '<?php echo $_SESSION['success']; ?>',
    showConfirmButton: false,
    timer: 2000
});
</script>

<?php 
unset($_SESSION['success']);
} ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>