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
                              Data Transaksi
                          </h4>
                          <small style="color:#f5e6d3;">
                              Coffee Management
                          </small>
                      </div>
                      <div  class="d-flex justify-content-end gap-2 mb-3">
                        <a href="/apk_coffe/admin/transaksi" class="btn rounded-3 px-4" style="background:#f5e6d3; color:#6F4E37; font-weight:600;">
                            Semua Data
                          </a>

                          <a href="?filter=hari_ini" class="btn rounded-3 px-4" style="background:#f5e6d3; color:#6F4E37; font-weight:600;">
                            Hari Ini
                        </a>
                      </div>
                       
                  </div>
              </div>
              <!-- TABLE -->
              <div class="table-responsive">
                <table class="table align-middle text-center">
                      <thead>
                          <tr style="background:#f8f1ea;">
                              <th class="ps-4 py-3 border-0">
                                  No.
                              </th>
                              <th class="ps-4 py-3 border-0">
                                  Nama
                              </th>
                              <th class="py-3 border-0">
                                  Total Harga
                              </th>
                              <th class="py-3 border-0">
                                  Total Pembayaran
                              </th>
                              <th class="py-3 border-0">
                                  Nama Kasir
                              </th>
                              <th class="py-3 border-0">
                                  Tanggal
                              </th>
                          </tr>
                      </thead>
                    <?php
                        $where = "";
                        if(isset($_GET['filter']) && $_GET['filter'] == 'hari_ini'){
                            $where = "WHERE DATE(tb_pesanan.created_at) = CURDATE()";
                        }
                        $no = 1;
                        $total_semua = 0;
                        $data = mysqli_query($koneksi,"
                            SELECT * FROM tb_pesanan
                            JOIN tb_user 
                            ON tb_pesanan.user_id = tb_user.user_id
                            $where
                        ");
                        while($d = mysqli_fetch_array($data)){
                            $total_semua += $d['pesanan_totalharga'];''
                    ?>
                      <tbody>
                          <tr>
                              <td>
                                <div class="text-center align-middle">
                                      <?= $no++; ?>
                                  </div>
                                </td>
                                <td>
                                  <div class="fw-semibold text-dark">
                                      <?= $d['pesanan_nama']; ?>
                                  </div>
                              </td>
                              <td class="fw-bold">
                                 <?php echo "Rp. ".number_format($d['pesanan_totalharga'],2,',','.')." ,-"; ?>
                              </td>
                              <td class="fw-bold text-danger">
                                 <?php echo "Rp. ".number_format($d['pesanan_totbay'],2,',','.')." ,-"; ?>
                              </td>
                              <td>
                                  <span class="badge rounded-pill px-3 py-2" style="background:#ede0d4; color:#6F4E37;">
                                      <?= $d['user_nama']; ?>
                                  </span>
                              </td>
                              <td class="text-muted">
                                 <?= date('d - M - Y', strtotime($d['created_at'])) ?>
                              </td>
                            <?php
                                }
                            ?>
                          </tr>
                        <tr class="fw-bold">
                            <td colspan="2">Total Keseluruhan</td>
                            <td class="fw-bold text-danger">
                                <?php echo "Rp. ".number_format($total_semua,2,',','.')." ,-"; ?>
                            </td>
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


<script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</body>
</html>
