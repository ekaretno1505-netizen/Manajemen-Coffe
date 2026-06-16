<?php include '../temp/header.php';?>
        
        </div>
      </div>
      <hr>
      <div class="row">
        <div class="col-lg-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
            </div>
          <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
              <div class="p-4" style="background:#6F4E37;">
                  <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                      <div>
                          <h4 class="text-white mb-1">
                              Data Pengeluaran
                          </h4>
                          <small style="color:#f5e6d3;">
                              Coffee Management
                          </small>
                      </div>
                      <button class="btn rounded-3 px-4" style="background:#f5e6d3; color:#6F4E37; font-weight:600;" data-bs-toggle="modal" data-bs-target="#modalTambah">
                          + Tambah
                      </button>
                  </div>
              </div>
              <!-- TABLE -->
              <div class="table-responsive">
                  <table class="table align-middle mb-0">
                      <thead>
                          <tr style="background:#f8f1ea;">
                              <th class="ps-4 py-3 border-0">
                                  Nama
                              </th>
                              <th class="py-3 border-0">
                                  Kategori
                              </th>
                              <th class="py-3 border-0">
                                Bukti
                              </th>
                              <th class="py-3 border-0">
                                  Total
                              </th>
                              <th class="py-3 border-0">
                                  Tanggal
                              </th>
                              <th class="text-center py-3 border-0">
                                  Aksi
                              </th>
                          </tr>
                      </thead>
                    <?php
                        $data = mysqli_query($koneksi,"SELECT * FROM tb_pengeluaran");
                        while($d = mysqli_fetch_array($data)){
                    ?>
                      <tbody>
                          <tr>
                              <td class="ps-4 py-3">
                                  <div class="fw-semibold text-dark">
                                      <?= $d['nama_pengeluaran']; ?>
                                  </div>
                                  <small class="text-muted">
                                       <?= $d['keterangan']; ?>
                                  </small>
                              </td>
                              <td>
                                  <span class="badge rounded-pill px-3 py-2" style="background:#ede0d4; color:#6F4E37;">
                                      <?= $d['kategori_pengeluaran']; ?>
                                  </span>
                              </td>
                              <td>
                                <a href="#" data-bs-toggle="modal" data-bs-target="#modalFoto<?= $d['pengeluaran_id'] ?>">
                                    <img src="../gambar/bukti/<?= $d['bukti_foto'] ?>" width="70"height="70" style=" object-fit:cover; border-radius:16px;border:3px solid #f3e5d8;">
                                </a>
                              </td>
                              <td class="fw-bold text-danger">
                                 <?php echo "Rp. ".number_format($d['total_pengeluaran'],2,',','.')." ,-"; ?>
                                   
                              </td>
                              <td class="text-muted">
                                 <?= date('d - M - Y', strtotime($d['created_at'])) ?>
                              </td>
                              <td class="text-center">
                                <a href="#" class="text-dark" data-bs-toggle="modal" data-bs-target="#modalEdit<?= $d['pengeluaran_id'] ?>"><i class="fa-regular fa-pen-to-square"></i></a>
                                <a href="pengeluaran_hapus.php?id=<?= $d['pengeluaran_id']; ?>" onclick="return hapusData(event, this)" class="text-danger" data-bs-toggle="modal"onclick="hapusData()""><i class="fa-regular fa-trash-can"></i></a>
                              </td>
                              <!-- MODAL Edit -->
                            <div class="modal fade" id="modalEdit<?= $d['pengeluaran_id'] ?>" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content border-0 rounded-4">
                                        <div class="modal-header">
                                            <h5 class="modal-title">
                                                Edit Pengeluaran
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <form action="pengeluaran_update.php" method="POST" enctype="multipart/form-data">
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label class="form-label">
                                                        Nama Pengeluaran
                                                    </label>
                                                    <input type="hidden" name="id" value="<?= $d['pengeluaran_id'] ?>">
                                                    <input type="text" class="form-control rounded-pill" name="nama" value="<?= $d['nama_pengeluaran'] ?>">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">
                                                        Kategori
                                                    </label>
                                                    <select class="form-select rounded-pill" name="kategori">
                                                        <option>- Pilih -</option>
                                                        <option <?php if($d['kategori_pengeluaran'] == "Bahan Baku"){echo "selected='selected'";} ?>>Bahan Baku</option>
                                                        <option <?php if($d['kategori_pengeluaran'] == "Operasional"){echo "selected='selected'";} ?>>Operasional</option>
                                                        <option <?php if($d['kategori_pengeluaran'] == "Gaji"){echo "selected='selected'";} ?>>Gaji</option>
                                                        <option <?php if($d['kategori_pengeluaran'] == "Lainnya"){echo "selected='selected'";} ?>>Lainnya</option>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">
                                                        Total Pengeluaran
                                                    </label>
                                                    <input type="number" class="form-control rounded-pill" name="total" value="<?= $d['total_pengeluaran'] ?>">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">
                                                        Keterangan
                                                    </label>
                                                    <textarea class="form-control rounded-pill" rows="3" name="keterangan"><?= $d['keterangan'] ?></textarea>
                                                </div>
                                                <div class="mb-3">
                                                    <label  for="exampleFormControlFile1">Upload File</label>
                                                    <input type="file" name="trnfoto" class="form-control-file"><br>
                                                    <!-- <small><?php echo $d['bukti_foto'] ?></small> -->
                                                    <p class="help-block">File <?php echo "<a class='fancybox btn btn-xs btn-primary' target=_blank href='../gambar/bukti/$d[bukti_foto]'>$d[bukti_foto]</a>";?></p>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                    Batal
                                                </button>
                                                <button type="submit" class="btn btn-dark">
                                                    Simpan
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- MODAL HAPUS -->
                            <div class="modal fade" id="modalHapus<?= $d['pengeluaran_id'] ?>" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content rounded-4">
                                        <div class="modal-header border-0">
                                            <h5 class="modal-title fw-bold">
                                                Hapus Menu
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            Yakin ingin menghapus
                                            <b><?= $d['menu_nama'] ?></b> ?
                                        </div>
                                        <div class="modal-footer border-0">
                                            <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">
                                                Batal
                                            </button>
                                            <button type="button" class="btn btn-danger rounded-pill px-4">
                                                Hapus
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- MODAL FOTO -->
                            <div class="modal fade" id="modalFoto<?= $d['pengeluaran_id'] ?>" tabindex="-1">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content border-0 rounded-4 overflow-hidden">
                                        <div class="modal-header border-0">
                                            <h5 class="modal-title">
                                                Bukti Pengeluaran
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal">
                                            </button>
                                        </div>
                                        <div class="modal-body text-center">
                                            <embed src="../gambar/bukti/<?php echo $d['bukti_foto']; ?>" type="application/pdf" width="100%" height="400px" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                                }
                            ?>
                          </tr>
                      </tbody>
                  </table>
              </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- MODAL TAMBAH -->
<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content border-0 rounded-4">
            <div class="modal-header">
                <h5 class="modal-title">
                    Tambah Pengeluaran
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="pengeluaran_act.php" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">
                            Nama Pengeluaran
                        </label>
                        <input type="text" class="form-control rounded-pill" name="nama">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">
                            Kategori
                        </label>
                        <select class="form-select rounded-pill" name="kategori">
                            <option>- Pilih -</option>
                            <option>Bahan Baku</option>
                            <option>Operasional</option>
                            <option>Gaji</option>
                            <option>Lainnya</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">
                            Total Pengeluaran
                        </label>
                        <input type="number" class="form-control rounded-pill" name="total">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">
                            Keterangan
                        </label>
                        <textarea class="form-control rounded-pill" rows="3" name="keterangan"></textarea>
                    </div>
                    <div class="mb-3">
                        <label  for="exampleFormControlFile1">Upload File</label>
                        <input type="file" name="trnfoto" class="form-control-file" id="exampleFormControlFile1">
                        <small>File yang di perbolehkan *PDF | *JPG | *jpeg </small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Batal
                    </button>
                    <button type="submit" class="btn btn-dark">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>




<script>
  function hapusData(event, element){
  event.preventDefault(); // stop langsung pindah halaman
  Swal.fire({
    title: 'Yakin hapus?',
    text: "Data tidak bisa dikembalikan!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Ya, hapus!',
    cancelButtonText: 'Batal'
  }).then((result) => {
    if (result.isConfirmed) {
      window.location = element.href; 
    }
  });
}
</script>


<script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</body>
</html>
