
          <?php include '../temp/header.php';?>
         
        </div>
      </div>
       <!-- MODAL Tambah -->
                <div class="modal fade" id="modalTambah" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content rounded-4">
                            <form action="menu_act.php" method="post" enctype="multipart/form-data">
                              <div class="modal-header border-0">
                                <h5 class="modal-title fw-bold">
                                    Tambah Menu
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                              </div>
                              <div class="modal-body">
                                  <div class="mb-3">
                                      <label class="form-label">Nama Menu</label>
                                      <input type="input" name = "nama" class="form-control rounded-pill" value="" required="required">
                                  </div>
                                  <div class="mb-3">
                                      <label class="form-label">Deskripsi Menu</label>
                                      <input type="text" name="desk" class="form-control rounded-pill" value="" required="required">
                                  </div>
                                  <div class="mb-3">
                                      <label class="form-label">Kategori Menu</label>
                                      <select name="kat" class="form-select rounded-pill" required="required">
                                        <option value="">- Pilih -</option>
                                        <option value="Susu">Susu</option>
                                        <option value="Kopi">Kopi</option>
                                        <option value="Cemilan">Cemilan</option>
                                        <option value="Teh">Teh</option>
                                      </select>
                                  </div>
                                  <div class="mb-3">
                                      <div class="form-check">
                                          <input class="form-check-input" type="checkbox" id="checkM">
                                          <label class="form-check-label" for="checkM">
                                              Size M
                                          </label>
                                      </div>
                                      <div id="inputM" style="display:none;">
                                          <label class="form-label">
                                              Harga Size M
                                          </label>
                                          <input type="text" name="hargaM" class="form-control rounded-pill" placeholder="">
                                      </div>
                                      <div class="form-check">
                                          <input class="form-check-input" type="checkbox" id="checkL">
                                          <label class="form-check-label" for="checkL">
                                              Size L
                                          </label>
                                      </div>
                                  <div id="inputL" style="display:none;">
                                     <label class="form-label">
                                          Harga Size L
                                      </label>
                                      <input type="text" name="hargaL" class="form-control rounded-pill" placeholder="">
                                  </div>
                                  </div>
                                  <div class="mb-3">
                                      <label class="form-label">Stok Menu</label>
                                      <select name="stok" class="form-select rounded-pill" required="required">
                                        <option value="">- Pilih -</option>
                                        <option value="Tersedia">Tersedia</option>
                                        <option value="Kosong">Kosong</option>
                                      </select>
                                  </div>
                                  <div class="mb-3">
                                      <label  for="exampleFormControlFile1">Upload File</label>
                                      <input type="file" name="trnfoto" class="form-control-file" id="exampleFormControlFile1">
                                      <small>File yang di perbolehkan *PDF | *JPG | *jpeg </small>
                                  </div>
                              </div>
                              <div class="modal-footer border-0">
                                  <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">
                                      Batal
                                  </button>
                                  <button type="submit" class="btn btn-dark rounded-pill px-4">
                                      Simpan
                                  </button>
                              </form>
                            </div>
                        </div>
                    </div>
                </div>
      <hr>
     
      <!-- CATEGORY -->
      <?php include '../temp/kategori.php';?>

      <div class="row">
        <!-- MENU -->
        <div class="col-lg-12">
            <h1 class="d-flex justify-content-between align-items-center mb-4">
                Menu <?= $kategori ?>
            <button class="btn btn-light rounded-pill px-4 fw-semibold" data-bs-toggle="modal" data-bs-target="#modalTambah">
                + Tambah Menu
            </button>
            </h1>
            <div class="row g-4">
            <?php
              while($d = mysqli_fetch_array($data)){
            ?>
                <!-- Isi Menu -->
                <div class="col-md-4">
                    <div class="menu-card">
                        <div class="d-flex justify-content-between">
                            <div class="d-flex gap-3">
                                <img src="../gambar/menu/<?php echo $d['menu_gambar']; ?>">
                                <div>
                                    <h5>
                                      <?= $d['menu_nama'] ?>
                                    </h5>
                                    <p class="small">
                                      <?= $d['menu_desk'] ?>
                                    </p>
                                    <p class="small">
                                      <small>Size : M - Rp <?= number_format($d['menu_hargaM'],0,',','.') ?> </small><br>
                                    </p>
                                    <p class="small">
                                      <small>Size : L - Rp <?= number_format($d['menu_hargaL'],0,',','.') ?> </small><br>
                                    </p>

                              
                                </div>
                            </div>
                            <div class="d-flex gap-2">
                                <a href="#" class="text-dark" data-bs-toggle="modal" data-bs-target="#modalEdit<?= $d['menu_id'] ?>"><i class="fa-regular fa-pen-to-square"></i></a>
                                <a href="menu_hapus.php?id=<?= $d['menu_id']; ?>" onclick="return hapusData(event, this)" class="text-danger" data-bs-toggle="modal"onclick="hapusData()""><i class="fa-regular fa-trash-can"></i></a>
                            </div>
                        </div>
      
                    </div>
                </div>

                <!-- MODAL EDIT -->
                <div class="modal fade" id="modalEdit<?= $d['menu_id'] ?>" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content rounded-4">
                            <form action="menu_update.php" method="post" enctype="multipart/form-data">
                              <div class="modal-header border-0">
                                <h5 class="modal-title fw-bold">
                                    Edit Menu
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                              </div>
                              <div class="modal-body">
                                  <div class="mb-3">
                                      <label class="form-label">Nama Menu</label>
                                      <input type="hidden" name="id" value="<?php echo $d['menu_id'] ?>">
                                      <input type="input" name = "nama" class="form-control rounded-pill" value="<?php echo $d['menu_nama']?>" required="required">
                                  </div>
                                  <div class="mb-3">
                                      <label class="form-label">Deskripsi Menu</label>
                                      <input type="text" name="desk" class="form-control rounded-pill" value="<?php echo $d['menu_desk']?>" required="required">
                                  </div>
                                  <div class="mb-3">
                                      <label class="form-label">Kategori Menu</label>
                                      <select name="kat" class="form-select rounded-pill" required="required">
                                        <option value="">- Pilih -</option>
                                        <option <?php if($d['menu_kategori'] == "Susu"){echo "selected='selected'";} ?>  value="Susu">Susu</option>
                                        <option <?php if($d['menu_kategori'] == "Kopi"){echo "selected='selected'";} ?>  value="Kopi">Kopi</option>
                                        <option <?php if($d['menu_kategori'] == "Cemilan"){echo "selected='selected'";} ?>  value="Snack">Cemilan</option>
                                        <option <?php if($d['menu_kategori'] == "Teh"){echo "selected='selected'";} ?>  value="Snack">Teh</option>
                                      </select>
                                  </div>
                                  <div class="mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="checkM"
                                            <?php if(!empty($d['menu_hargaM'])) echo 'checked'; ?>>
                                        <label class="form-check-label" for="checkM">Size M</label>
                                    </div>
                                    <div id="inputM" style="<?php echo !empty($d['menu_hargaM']) ? '' : 'display:none;'; ?>">
                                        <label class="form-label">Harga Size M</label>
                                        <input type="text" name="hargaM" class="form-control rounded-pill" value="<?php echo $d['menu_hargaM']?>">
                                    </div>

                                    <!-- Checkbox & Input Size L -->
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="checkL"
                                            <?php if(!empty($d['menu_hargaL'])) echo 'checked'; ?>>
                                        <label class="form-check-label" for="checkL">Size L</label>
                                    </div>
                                    <div id="inputL" style="<?php echo !empty($d['menu_hargaL']) ? '' : 'display:none;'; ?>">
                                        <label class="form-label">Harga Size L</label>
                                        <input type="text" name="hargaL" class="form-control rounded-pill" value="<?php echo $d['menu_hargaL']?>">
                                    </div>
                                </div>


                                  <div class="mb-3">
                                      <label class="form-label">Stok Menu</label>
                                      <select name="stok" class="form-select rounded-pill" required="required">
                                        <option value="">- Pilih -</option>
                                        <option <?php if($d['menu_stok'] == "Tersedia"){echo "selected='selected'";} ?>   value="Tersedia">Tersedia</option>
                                        <option <?php if($d['menu_stok'] == "Kosong"){echo "selected='selected'";} ?>   value="Kosong">Kosong</option>
                                      </select>
                                  </div>
                                  <div class="mb-3">
                                      <label  for="exampleFormControlFile1">Upload File</label>
                                     <input type="file" name="trnfoto" class="form-control-file"><br>
                                                <!-- <small><?php echo $d['menu_gambar'] ?></small> -->
                                                <p class="help-block">File <?php echo "<a class='fancybox btn btn-xs btn-primary' target=_blank href='../gambar/$d[menu_gambar]'>$d[menu_gambar]</a>";?></p>
                                  </div>
                              </div>
                              <div class="modal-footer border-0">
                                  <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">
                                      Batal
                                  </button>
                                  <button type="submit" class="btn btn-dark rounded-pill px-4">
                                      Simpan
                                  </button>
                              </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- MODAL HAPUS -->
                <div class="modal fade" id="modalHapus<?= $d['menu_id'] ?>" tabindex="-1">
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
            <?php } ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<script>
// CATEGORY ACTIVE
const categoryButtons = document.querySelectorAll('.category-btn');
categoryButtons.forEach(button => {
    button.addEventListener('click', function(){
        categoryButtons.forEach(btn => {
            btn.classList.remove('category-active');
        });
        this.classList.add('category-active');
    });
});
</script>

<script>
// CHECKBOX M
const checkM =
document.getElementById('checkM');
const inputM =
document.getElementById('inputM');
checkM.addEventListener('change', function(){
    if(this.checked){
        inputM.style.display = 'block';
    }else{
        inputM.style.display = 'none';
    }
});
// CHECKBOX L
const checkL =
document.getElementById('checkL');
const inputL =
document.getElementById('inputL');
checkL.addEventListener('change', function(){
    if(this.checked){
        inputL.style.display = 'block';
    }else{
        inputL.style.display = 'none';
    }
});
</script>

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

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>