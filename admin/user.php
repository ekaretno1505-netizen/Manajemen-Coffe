<?php include '../temp/header.php';?>
        
        </div>
      </div>
      <hr>
      <div class="row">
        <div class="col-lg-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
            </div>
    <div class="p-4" style="background:#6F4E37;">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h4 class="text-white mb-1">Data User</h4>
                <small style="color:#f5e6d3;">Coffee Management</small>
            </div>
            <button class="btn rounded-3 px-4" style="background:#f5e6d3; color:#6F4E37; font-weight:600;" data-bs-toggle="modal"data-bs-target="#modalTambah">
                + Tambah User
            </button>
        </div>
    </div>

    <!-- TABLE -->
    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead>
                <tr style="background:#f8f1ea;">
                    <th class="ps-4 py-3 border-0">Foto</th>
                    <th class="py-3 border-0">Nama</th>
                    <th class="py-3 border-0">Username</th>
                    <th class="py-3 border-0">Nomor</th>
                    <th class="py-3 border-0">Level</th>
                    <th class="text-center py-3 border-0">Aksi</th>
                </tr>
            </thead>
            <tbody>

            <?php
            $data = mysqli_query($koneksi,"SELECT * FROM tb_user");
            while($d = mysqli_fetch_array($data)){
            ?>

                <tr>
                    <td class="ps-4 py-3">
                        <a href="#" data-bs-toggle="modal" data-bs-target="#modalFoto<?= $d['user_id'] ?>">
                            <?php if($d['user_foto'] != ""){ ?>
                                <img src="../gambar/user/<?= $d['user_foto']; ?>" width="60" height="60" style="object-fit:cover; border-radius:50%; border:2px solid #ddd;">
                            <?php }else{ ?>
                                <div class="rounded-circle d-flex justify-content-center align-items-center" style="width:60px;height:60px;background:#6F4E37;color:#fff;">
                                    <i class="fa-regular fa-user"></i>
                                </div>
                            <?php } ?>
                        </a>
                    </td>
                    <td class="fw-semibold"> <?= $d['user_nama']; ?></td>
                    <td><?= $d['user_username']; ?></td>
                    <td><?= $d['user_nomor']; ?></td>
                    <td>
                        <span class="badge bg-dark">
                            <?= $d['user_level']; ?>
                        </span>
                    </td>
                    <td class="text-center">
                        <a href="#" class="text-dark" data-bs-toggle="modal" data-bs-target="#modalEdit<?= $d['user_id'] ?>"><i class="fa-regular fa-pen-to-square"></i></a>
                        <a href="user_delete.php?id=<?= $d['user_id']; ?>" class="text-danger ms-2" onclick="hapusData(event,this)"> <i class="fa-regular fa-trash-can"></i></a>
                    </td>
                </tr>

                <!-- MODAL EDIT -->
                <div class="modal fade" id="modalEdit<?= $d['user_id'] ?>" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5>Edit User</h5>
                                <button class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <form action="user_update.php" method="POST" enctype="multipart/form-data">
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label class="form-label">Nama</label>
                                        <input type="hidden" name="id" value="<?= $d['user_id'] ?>">
                                        <input type="text" name="nama" class="form-control mb-2" value="<?= $d['user_nama'] ?>">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Username</label>
                                        <input type="text" name="username" class="form-control mb-2"value="<?= $d['user_username'] ?>">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Nomor</label>
                                        <input type="text" name="nomor" class="form-control mb-2" value="<?= $d['user_nomor'] ?>">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Level</label>
                                        <select name="level" class="form-control mb-2">
                                            <option <?= $d['user_level']=="admin"?"selected":"" ?>>Administrator</option>
                                            <option <?= $d['user_level']=="kasir"?"selected":"" ?>>Kasir</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Password</label>
                                        <input type="password" name="password" class="form-control mb-2" placeholder="Kosongkan jika tidak diubah">
                                    </div>
                                    <div class="mb-3">
                                        <label  for="exampleFormControlFile1">Upload File</label>
                                        <input type="file" name="trnfoto" class="form-control-file"><br>
                                    <!-- <small><?php echo $d['user_foto'] ?></small> -->
                                        <p class="help-block">File <?php echo "<a class='fancybox btn btn-xs btn-primary' target=_blank href='../gambar/user/$d[user_foto]'>$d[user_foto]</a>";?></p>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                   <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">
                                      Batal
                                  </button>
                                  <button type="submit" class="btn btn-dark rounded-pill px-4">
                                      Simpan
                                  </button>
                                </div>

                            </form>

                        </div>
                    </div>
                </div>
                <!-- MODAL FOTO -->
                <div class="modal fade" id="modalFoto<?= $d['user_id'] ?>" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">

                            <div class="modal-header">
                                <h5>Foto User</h5>
                                <button class="btn-close" data-bs-dismiss="modal"></button>
                            </div>

                            <div class="modal-body text-center">

                                <?php if($d['user_foto'] != ""){ ?>
                                    <img src="../gambar/user/<?= $d['user_foto']; ?>"
                                        class="img-fluid rounded" type="application/pdf" width="100%" height="400px" >
                                <?php }else{ ?>
                                    <p>Tidak ada foto</p>
                                <?php } ?>

                            </div>

                        </div>
                    </div>
                </div>

            <?php } ?>

            </tbody>

        </table>

    </div>

</div>

</div>
</div>

<!-- MODAL TAMBAH -->
<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5>Tambah User</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form action="user_insert.php" method="POST" enctype="multipart/form-data">

                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama</label>
                                        
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama</label>
                        <input type="text" name="nama" class="form-control mb-2" placeholder="Nama">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama</label>
                        <input type="text" name="username" class="form-control mb-2" placeholder="Username">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama</label>
                        <input type="password" name="password" class="form-control mb-2" placeholder="Password">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama</label>
                        <input type="text" name="nomor" class="form-control mb-2" placeholder="Nomor">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama</label>
                        <select name="level" class="form-control mb-2">
                        <option>Administrator</option>
                        <option>Kasir</option>
                    </select>
                    </div>
                    
                    <div class="mb-3">
                        <label  for="exampleFormControlFile1">Upload File</label>
                        <input type="file" name="trnfoto" class="form-control-file" id="exampleFormControlFile1">
                        <small>File yang di perbolehkan *PDF | *JPG | *jpeg </small>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">
                        Batal
                    </button>
                    <button type="submit" class="btn btn-dark rounded-pill px-4">
                        Simpan
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>

<script>
function hapusData(event, element){
    event.preventDefault();

    Swal.fire({
        title: 'Yakin hapus user?',
        text: "Data tidak bisa dikembalikan!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if(result.isConfirmed){
            window.location = element.href;
        }
    });
}
</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="../bootstrap/js/bootstrap.bundle.min.js"></script>

</body>
</html>