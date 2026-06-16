    <?php include '../temp/header.php';?>
        
        </div>
      </div>
      <hr>
      <div class="row">
        <div class="col-lg-12">
            <h1 class="mb-4">
              Grafik
            </h1>
            <div class="row g-4">
                <!-- LINE CHART -->
                <div class="col-md-8">
                    <div class="card border-0 shadow-sm rounded-4">
                        <div class="card-body">
                            <h5 class="text-brown mb-3">
                                Grafik Penjualan
                            </h5>
                            <canvas id="lineChart" height="120"></canvas>
                        </div>
                    </div>
                </div>
                
                <?php
                    $jumlahmasuk= 0;
                    $sql1 = "SELECT * from tb_pesanan";
                    $query1 = mysqli_query($koneksi,$sql1);
                    while ($masuk=mysqli_fetch_array($query1)){
                        $arraymasuk[] = $masuk['pesanan_totalharga'];
                        $jumlahmasuk = array_sum($arraymasuk);
                    }
                    
                    $jumlahkeluar = 0;
                    $sql2 = "SELECT * from tb_pengeluaran";
                    $query2 = mysqli_query($koneksi,$sql2);
                    while ($keluar=mysqli_fetch_array($query2)){
                        $arraykeluar[] = $keluar['total_pengeluaran'];
                        $jumlahkeluar = array_sum($arraykeluar);
                    }
                    

                    $total=0;
                    $total=$jumlahmasuk-$jumlahkeluar;
                    
                ?>
                <!-- PIE CHART -->
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm rounded-4">
                        <div class="card-body text-center">
                            <h5 class="text-brown mb-3">
                                Total Uang
                            </h5>
                            <div style="width:307px; margin:auto;">
                                <canvas id="pieChart"></canvas>
                            </div>
                            <h4 class="mt-3 fw-bold text-brown">
                                <?php echo "Rp." . number_format($total) ; ?>
                            </h4>
                        </div>
                    </div>
                </div>
                <?php
                    $data = mysqli_query($koneksi, "
                        SELECT 
                            detail_menu,
                            SUM(detail_qty) as total
                        FROM tb_detail_pesanan
                        GROUP BY detail_menu
                        ORDER BY total DESC
                        LIMIT 10
                    ");

                    while($d = mysqli_fetch_array($data)){

                        $menu[] = $d['detail_menu'];
                        $totalin[] = $d['total'];

                    }

                    ?>
                <div class="col-md-12   ">
                    <div class="card border-0 shadow-sm rounded-4">
                        <div class="card-body">
                            <h5 class="text-brown mb-3">
                                Grafik Menu Favorit
                            </h5>
                            <canvas id="bestSeller" height="80"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>


<?php
$year = date('Y');
    $total=array();
    for ($month = 1; $month <= 12; $month ++){
        $sql=mysqli_query($koneksi, "select *, sum(pesanan_totalharga) as total from tb_pesanan where month(created_at)='$month' and year(created_at)='$year'");
        while ($row=mysqli_fetch_array($sql)){

            $total[]=$row['total'];
        }
    }
 
    $tjan = $total[0];
    $tfeb = $total[1];
    $tmar = $total[2];
    $tapr = $total[3];
    $tmay = $total[4];
    $tjun = $total[5];
    $tjul = $total[6];
    $taug = $total[7];
    $tsep = $total[8];
    $toct = $total[9];
    $tnov = $total[10];
    $tdec = $total[11]; 
?>
<!-- CHART JS -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

//
// LINE CHART
//
const lineCtx = document.getElementById('lineChart');

new Chart(lineCtx, {
    type: 'line',
    data: {
        labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
        datasets: [{
            label: 'Penjualan',
            data: [
                    "<?php echo $tjan; ?>",
                    "<?php echo $tfeb; ?>",
                    "<?php echo $tmar; ?>",
                    "<?php echo $tapr; ?>",
                    "<?php echo $tmay; ?>",
                    "<?php echo $tjun; ?>",
                    "<?php echo $tjul; ?>",
                    "<?php echo $taug; ?>",
                    "<?php echo $tsep; ?>",
                    "<?php echo $toct; ?>",
                    "<?php echo $tnov; ?>",
                    "<?php echo $tdec; ?>"
                ],

            borderColor: '#6F4E37',
            backgroundColor: 'rgba(111,78,55,0.15)',
            fill: true,
            tension: 0.4,
            pointBackgroundColor: '#4E342E',
            pointRadius: 4
        }]
    },

    options: {
        responsive:true,
        plugins:{
            legend:{
                display:false
            }
        },

        scales:{
            y:{
                beginAtZero:true,
                ticks:{
                    color:'#6D4C41'
                },
                grid:{
                    color:'rgba(93,64,55,0.08)'
                }
            },
            x:{
                ticks:{
                    color:'#6D4C41'
                },
                grid:{
                    display:false
                }
            }
        }
    }
});
//
// PIE CHART
//
const pieCtx = document.getElementById('pieChart');
new Chart(pieCtx, {
    type: 'pie',
    data: {
        labels: ['Masuk', 'Keluar'],
        datasets: [{
            data: [
                "<?php echo $jumlahmasuk; ?>",
                "<?php echo $jumlahkeluar; ?>"
            ],
            backgroundColor: [
                '#6F4E37',
                '#D7B899'
            ],
            borderWidth:0
        }]
    },
    options:{
        responsive:true,
        plugins:{
            legend:{
                position:'bottom',
                labels:{
                    color:'#5D4037'
                }
            }
        }
    }
});

const ctx = document.getElementById('bestSeller');
new Chart(ctx, {
    type: 'bar',
    data: {
        labels: <?= json_encode($menu); ?>,
        datasets: [{
            label: 'Menu Terjual',
            data: <?= json_encode($totalin); ?>,
            backgroundColor: [
                        '#3E2723',
                        '#4B2E2B',
                        '#4E342E',
                        '#5C4033',
                        '#5D4037',
                        '#6F4E37',
                        '#6D4C41',
                        '#795548',
                        '#7B5E57',
                        '#8B7355',
                        '#8D6E63',
                        '#A9746E',
                        '#A1887F',
                        '#B08968',
                        '#BCAAA4',
                        '#C4A484',
                        '#D2B48C',
                        '#D7CCC8',
                        '#E6CCB2',
                        '#EFEBE9'
                    ],

            borderColor: '#D7CCC8',
            borderWidth: 1,
            borderRadius: 15,
            barThickness: 40
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                labels: {
                    color: '#6D4C41',
                    font: {
                        size: 14
                    }
                }
            }
        },
        scales: {
            x: {
                ticks: {
                    color: '#6D4C41',
                    font: {
                        size: 13
                    }
                },
                grid: {
                    display: false
                }
            },
            y: {
                beginAtZero: true,
                ticks: {
                    color: '#6D4C41'
                },
                grid: {
                    color: 'rgba(255,255,255,0.08)'
                }
            }
        }
    }
});
</script>

<style>
.text-brown{
    color:#5D4037;
}
.card{
    background:#fff;
}
</style>

<script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</body>
</html>