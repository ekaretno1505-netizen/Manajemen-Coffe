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
                <div class="col-md-12">
                    <div class="card border-0 shadow-sm rounded-4">
                        <div class="card-body">
                            <h5 class="text-brown mb-3">
                                Grafik Menu Favorit
                            </h5>
                            <canvas id="bestSeller" height="100"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- CHART JS -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

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
                '#4E342E',
                '#5D4037',
                '#6D4C41',
                '#795548',
                '#8D6E63',
                '#A1887F',
                '#BCAAA4',
                '#D7CCC8',
                '#EFEBE9',
                '#4B2E2B',
                '#5C4033',
                '#6F4E37',
                '#7B5E57',
                '#8B7355',
                '#A9746E',
                '#B08968',
                '#C4A484',
                '#D2B48C',
                '#E6CCB2'
            ],

            borderColor: '#D7CCC8',
            borderWidth: 1,
            borderRadius: 15,
            barThickness: 50
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                labels: {
                    color: '#6D4C41',
                    font: {
                        size: 16
                    }
                }
            }
        },
        scales: {
            x: {
                ticks: {
                    color: '#6D4C41',
                    font: {
                        size: 15
                    }
                },
                grid: {
                    display: false
                }
            },
            y: {
                beginAtZero: true,
                ticks: {
                    color: '#6D4C41',
                    font: {
                      size: 15
                    }
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