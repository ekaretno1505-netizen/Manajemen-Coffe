
<?php include '../temp/header.php'; ?>

</div>
</div>
<hr>

<!-- CATEGORY -->
<div class="d-flex flex-wrap gap-3 mb-4">
  <?php include '../temp/kategori.php'; ?>
</div>

<?php
$totalHarga = 0;
$totalItem  = 0;

$keranjang = mysqli_query($koneksi, "
    SELECT tb_keranjang.*, tb_menu.menu_nama 
    FROM tb_keranjang 
    JOIN tb_menu ON tb_keranjang.menu_id = tb_menu.menu_id 
    ORDER BY keranjang_id DESC
");

$isEmpty = (mysqli_num_rows($keranjang) == 0);
?>

<div class="row">

<!-- MENU -->
<div class="col-lg-8">
    <h1 class="mb-4">Menu <?= $kategori ?></h1>

    <div class="row g-4">
        <?php while($d = mysqli_fetch_array($data)){ ?>
        <div class="col-md-6">
            <div class="menu-card" data-id="<?= $d['menu_id'] ?>">

                <div class="d-flex gap-3">
                    <img src="https://images.unsplash.com/photo-1509042239860-f550ce710b93" width="80" class="rounded-4">

                    <div>
                        <h5><?= $d['menu_nama'] ?></h5>
                        <p class="small text-muted"><?= $d['menu_desk'] ?></p>
                    </div>
                </div>

                <hr>

                <!-- SIZE -->
                <div class="d-flex gap-2 mb-3">
                    <?php if($d['menu_hargaM'] > 0){ ?>
                    <button type="button" class="size-btn"
                        data-size="M"
                        data-price="<?= $d['menu_hargaM'] ?>">
                        M
                    </button>
                    <?php } ?>

                    <?php if($d['menu_hargaL'] > 0){ ?>
                    <button type="button" class="size-btn"
                        data-size="L"
                        data-price="<?= $d['menu_hargaL'] ?>">
                        L
                    </button>
                    <?php } ?>
                </div>

                <!-- BUTTON -->
                <button type="button"
                        class="btn-order add-order"
                        data-name="<?= $d['menu_nama'] ?>">
                    Tambahkan ke Pesanan
                </button>

            </div>
        </div>
        <?php } ?>
    </div>
</div>

<!-- ORDER -->
<div class="col-lg-4 mt-4 mt-lg-0">
    <div class="order-box">
        <div class="d-flex justify-content-between mb-4">
            <h2>Pesanan</h2>
            <button class="btn btn-danger btn-sm" onclick="clearKeranjang()">
                Clear
            </button>
        </div>

        <!-- LIST -->
        <div id="order-list">

            <?php while($k = mysqli_fetch_array($keranjang)){

                $harga = ($k['qty'] > 0)
                ? ($k['subtotal'] / $k['qty'])
                : 0;

                $totalHarga += $k['subtotal'];
                $totalItem  += $k['qty'];
            ?>

            <div class="order-item d-flex justify-content-between border-bottom pb-3 mb-3">

                <div>
                    <h6><?= $k['menu_nama'] ?></h6>
                    <small>Size: <?= $k['menu_size'] ?></small><br>
                    <small>Rp <?= number_format($k['subtotal']) ?></small>
                </div>

                <div class="d-flex gap-2 align-items-center">

                    <a href="qty_minus.php?id=<?= $k['keranjang_id'] ?>" class="btn btn-sm btn-secondary">-</a>

                    <span><?= $k['qty'] ?></span>

                    <a href="qty_plus.php?id=<?= $k['keranjang_id'] ?>" class="btn btn-sm btn-secondary">+</a>

                    <a href="hapus_keranjang.php?id=<?= $k['keranjang_id'] ?>" class="btn btn-sm btn-danger">x</a>

                </div>

            </div>

            <?php } ?>
        </div>

        <hr>

        <!-- TOTAL -->
        <div class="d-flex justify-content-between">
            <strong>Total Item</strong>
            <strong><?= $totalItem ?></strong>
        </div>

        <div class="d-flex justify-content-between mb-3">
            <strong>Total Bayar</strong>
            <strong>Rp <?= number_format($totalHarga) ?></strong>
        </div>
        <div id="cashForm" class="p-3 mb-3 rounded-3" style="display:none; background:#f8f9fa; border:1px solid #e0e0e0;">

        <!-- INPUT UANG -->
        <div class="mb-2">
            <label style="font-weight:600;">Uang Customer</label>
        </div>

        <input type="number" id="uangCash" class="form-control mb-2" placeholder="Masukkan uang customer" style="border-radius:10px;">

        <!-- BUTTON HITUNG -->
        <button type="button"
                onclick="hitungKembalian()"
                class="btn w-100 mb-2"
                style="background:#6D4C41; color:white; border-radius:10px;">
            Hitung Kembalian
        </button>

        <!-- HASIL -->
        <div id="hasilKembalian"
            class="text-center fw-bold"
            style="font-size:16px; color:#3E2723;">
        </div>

    </div>

        <!-- PAYMENT -->
        <div class="d-flex gap-2 flex-wrap mb-3">

    <button type="button" class="payment-btn payment-active"
        onclick="setPayment('Cash', this)"  <?= $isEmpty ? 'disabled style="opacity:0.5;cursor:not-allowed;"' : '' ?>>
        Cash
    </button>

    <button type="button" class="payment-btn"
        onclick="setPayment('Debit', this)"  <?= $isEmpty ? 'disabled style="opacity:0.5;cursor:not-allowed;"' : '' ?>>
        Debit
    </button>

    <button type="button" class="payment-btn"
        onclick="setPayment('E-Wallet', this)"  <?= $isEmpty ? 'disabled style="opacity:0.5;cursor:not-allowed;"' : '' ?>>
        E-Wallet
    </button>

</div>

        <!-- PROSES -->
        <button type="button"
            class="btn-process"
            id="btnProses"
            data-bs-toggle="modal"
            data-bs-target="#modalPemesanan"
            <?= $isEmpty ? 'disabled style="opacity:0.5;cursor:not-allowed;"' : '' ?>>

            Proses
        </button>

       

    </div>
</div>
</div>

<!-- MODAL -->
<div class="modal fade" id="modalPemesanan">
<div class="modal-dialog modal-dialog-centered">
<div class="modal-content rounded-4">

<div class="modal-header border-0">
    <h5>Data Pemesan</h5>
    <button class="btn-close" data-bs-dismiss="modal"></button>
</div>

<form action="proses.php" method="POST">

<div class="modal-body">
    <input type="hidden" name="uang_bayar" id="uang_bayar">
    <input type="hidden" name="id" value="<?php echo $_SESSION['id']?>">
    <input type="text" name="namap" class="form-control rounded-pill mb-3" placeholder="Nama Pemesan" required id="namaPelanggan">


</div>

<div class="modal-footer border-0">
    <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
    <button class="btn btn-dark"  target="_blank">Simpan Pesanan</button>
</div>

</form>

</div>
</div>
</div>
<script>
// PILIH SIZE
document.querySelectorAll('.menu-card').forEach(card => {

    const sizeButtons = card.querySelectorAll('.size-btn');

    sizeButtons.forEach(btn => {
        btn.addEventListener('click', function(){

            sizeButtons.forEach(b => b.classList.remove('size-active'));

            this.classList.add('size-active');

            card.dataset.size = this.dataset.size;
            card.dataset.price = this.dataset.price;
        });
    });

});

// TAMBAH PESANAN
document.querySelectorAll('.add-order').forEach(button => {

    button.addEventListener('click', function(){

        const card = this.closest('.menu-card');

        const menu_id = card.dataset.id;
        const size = card.dataset.size;
        const price = parseInt(card.dataset.price || 0);

       if(!size){

        Swal.fire({
            icon: 'warning',
            title: 'Oops...',
            text: 'Pilih size terlebih dahulu',
            confirmButtonColor: '#6f4e37'
        });

        return;

    }

        fetch('act_keranjang.php', {

            method : 'POST',

            headers : {
                'Content-Type' : 'application/x-www-form-urlencoded'
            },

            body :
                'menu_id=' + menu_id +
                '&menu_size=' + size +
                '&qty=1' +
                '&subtotal=' + price

        })

        .then(response => response.text())

        .then(data => {

            location.reload();

        });

    });

});
// PROSES VALIDASI
document.getElementById('btnProses')?.addEventListener('click', function(e){

    const items = document.querySelectorAll('.order-item');

    if(items.length === 0){
        e.preventDefault();

        Swal.fire({
            icon: 'warning',
            title: 'Keranjang kosong'
        });
    }

});

// CLEAR
function clearKeranjang(){

    const items = document.querySelectorAll('.order-item');

    if(items.length === 0){
        Swal.fire({
            icon: 'warning',
            title: 'Kosong'
        });
        return;
    }

    Swal.fire({
        title: 'Hapus semua?',
        showCancelButton: true,
        confirmButtonText: 'Ya'
    }).then((res) => {
        if(res.isConfirmed){
            window.location = 'clear_keranjang.php';
        }
    });
}
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>

let selectedPayment = "Cash";
let total = <?= $totalHarga ?>;

/* PILIH PAYMENT */
function setPayment(method, el){

    selectedPayment = method;

    document.querySelectorAll('.payment-btn')
        .forEach(b => b.classList.remove('payment-active'));

    el.classList.add('payment-active');

    /* CASH */
    if(method === 'Cash'){
        document.getElementById('cashForm').style.display = 'block';
    } else {
        document.getElementById('cashForm').style.display = 'none';
    }

    /* DEBIT & EWALLET LANGSUNG PROSES */
    if(method === 'Debit' || method === 'E-Wallet'){

        setTimeout(() => {
            document.getElementById('paymentInput').value = method;
            document.getElementById('formPesanan').submit();
        }, 1000);
    }
}

function hitungKembalian(){

    let uang = parseInt(document.getElementById('uangCash').value || 0);
    let total = <?= $totalHarga ?>;
    let kembali = uang - total;

    if(kembali < 0){
        Swal.fire({
            icon: 'error',
            title: 'Uang kurang!'
        });
        return;
    }

    // tampilkan ke user
    document.getElementById('hasilKembalian').innerHTML =
        "Kembalian: Rp " + kembali.toLocaleString('id-ID');

    // kirim ke hidden input
    document.getElementById('uang_bayar').value = uang;
    document.getElementById('kembalian_hidden').value = kembali;
}
/* VALIDASI FORM */
document.getElementById('formPesanan').addEventListener('submit', function(e){

    let nama = document.getElementById('namaPelanggan').value;

    if(nama === ""){
        e.preventDefault();

        Swal.fire({
            icon: 'warning',
            title: 'Nama pelanggan wajib diisi'
        });
        return;
    }

    document.getElementById('paymentInput').value = selectedPayment;

});

</script>

<!-- BOOTSTRAP -->
 <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>