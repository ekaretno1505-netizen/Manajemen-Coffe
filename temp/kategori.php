 <?php
        $kategori = isset($_GET['kategori']) ? $_GET['kategori'] : 'Kopi';
        $data = mysqli_query($koneksi,"SELECT * FROM tb_menu WHERE menu_kategori='$kategori'");
      ?>
<div class="d-flex flex-wrap gap-3 mb-4">
        <a href="?kategori=Kopi" class="category-btn text-decoration-none <?= $kategori == 'Kopi' ? 'category-active' : '' ?>">
            Kopi
        </a>
        <a href="?kategori=Susu" class="category-btn text-decoration-none <?= $kategori == 'Susu' ? 'category-active' : '' ?>">
            Susu
        </a>
        <a href="?kategori=Cemilan" class="category-btn text-decoration-none <?= $kategori == 'Cemilan' ? 'category-active' : '' ?>">
            Cemilan
        </a>
        <a href="?kategori=Teh" class="category-btn text-decoration-none <?= $kategori == 'Teh' ? 'category-active' : '' ?>">
            Teh
        </a>
      </div>