<?php
require_once 'auth.php';
require_once 'dashboard_controller.php';
Auth::cekLoginUser();

$dashboard     = new Dashboard();
$total_clustering = $dashboard->getTotalClustering();
$lingkungan_sesuai = $dashboard->getLingkunganSesuai();
$lingkungan_tidak_sesuai = $dashboard->getLingkunganTidakSesuai();
$dataDetailMingguan = $dashboard->getAktivitas7HariDetail();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - FloraMeans</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <!-- CSS -->
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .card-custom {
            border: none;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            background: #ffffff;
        }
        .icon-shape {
            width: 48px;
            height: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            font-size: 24px;
        }
        .bg-light-blue { background-color: rgba(13, 110, 253, 0.1); color: #0d6efd; }
        .bg-light-green { background-color: rgba(25, 135, 84, 0.1); color: #198754; }
        .bg-light-danger { background-color: rgba(220, 53, 69, 0.1); color: #dc3545; }
        
        .main-content {
            padding: 2rem;
        }
    </style>
</head>
<body>
    <!-- NAVBAR -->
    <?php include 'navbar.php'; ?>
<div class="container-fluid main-content">
        
        <div class="row mb-4">
            <div class="col">
                <h2 class="fw-bold text-dark">Dashboard</h2>
            </div>
        </div>

        <div class="row g-4 mb-4">
            <!-- Total clustering -->
            <div class="col-12 col-md-4">
                <div class="card card-custom p-3">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="text-muted small text-uppercase fw-semibold mb-1">Total Clustering</p>
                            <h3 class="fw-bold mb-0 text-dark"><?= number_format($total_clustering); ?></h3>
                        </div>
                        <div class="icon-shape bg-light-blue">
                            <i class="bi bi-graph-up"></i>
                        </div>
                    </div>
                    <div class="mt-2 text-muted small">Keseluruhan proses simulasi</div>
                </div>
            </div>
            <!-- Lingkungan sesuai -->
            <div class="col-12 col-md-4">
                <div class="card card-custom p-3">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="text-muted small text-uppercase fw-semibold mb-1">Lingkungan Sesuai</p>
                            <h3 class="fw-bold mb-0 text-success"><?= number_format($lingkungan_sesuai); ?></h3>
                        </div>
                        <div class="icon-shape bg-light-green">
                            <i class="bi bi-check-circle-fill"></i>
                        </div>
                    </div>
                    <div class="mt-2 text-muted small">Kondisi ideal untuk pertumbuhan</div>
                </div>
            </div>
            <!-- Lingkungan tidak sesuai -->
            <div class="col-12 col-md-4">
                <div class="card card-custom p-3">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="text-muted small text-uppercase fw-semibold mb-1">Lingkungan Tidak Sesuai</p>
                            <h3 class="fw-bold mb-0 text-danger"><?= number_format($lingkungan_tidak_sesuai); ?></h3>
                        </div>
                        <div class="icon-shape bg-light-danger">
                            <i class="bi bi-x-circle-fill"></i>
                        </div>
                    </div>
                    <div class="mt-2 text-muted small">Memerlukan penyesuaian parameter</div>
                </div>
            </div>
        </div>
        <!-- Card Aktivitas Mingguan Clustering User -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card card-custom p-4">
                    <div class="mb-3">
                        <h5 class="fw-bold text-dark m-0">Aktivitas Mingguan</h5>
                        <p class="text-muted small">Frekuensi simulasi clustering harian </p>
                    </div>
                    <div style="position: relative; height:280px; width:100%">
                        <canvas id="aktivitasChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <!-- Grafik -->
        <div class="row g-4">
            <div class="col-12 col-lg-6">
                <div class="card card-custom p-4">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h5 class="fw-bold text-dark m-0">Scatter Plot: Suhu vs Kelembapan Udara</h5>
                    </div>
                    <p class="text-muted small">Sebaran klaster tanaman berdasarkan aspek termal dan kelembapan atmosfer lingkungan.</p>
                    
                    <div class="text-center py-5 border border-dashed rounded-4 bg-light mt-3">
                        <div class="mb-2 text-muted">
                            <i class="bi bi-graph-up-arrow" style="font-size: 2.5rem; color: #ced4da;"></i>
                        </div>
                        <h6 class="fw-semibold text-secondary small">Area Scatter Plot K-Means 1</h6>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-6">
                <div class="card card-custom p-4">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h5 class="fw-bold text-dark m-0">Scatter Plot: Intensitas Cahaya vs Kelembapan Tanah</h5>
                    </div>
                    <p class="text-muted small">Sebaran klaster tanaman berdasarkan paparan radiasi cahaya dan kandungan air tanah.</p>
                    
                    <div class="text-center py-5 border border-dashed rounded-4 bg-light mt-3">
                        <div class="mb-2 text-muted">
                            <i class="bi bi-graph-up-arrow" style="font-size: 2.5rem; color: #ced4da;"></i>
                        </div>
                        <h6 class="fw-semibold text-secondary small">Area Scatter Plot K-Means 2</h6>
                    </div>
                </div>
            </div>

        </div>

    </div>

<script>
        document.addEventListener("DOMContentLoaded", function() {
            const ctx = document.getElementById('aktivitasChart').getContext('2d');
            
            const backendDataset = <?php echo json_encode($dataDetailMingguan); ?>;

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'],
                    datasets: [
                        {
                            label: 'Lingkungan Sesuai',
                            data: backendDataset.sesuai,
                            backgroundColor: '#198754',
                            borderRadius: 6
                        },
                        {
                            label: 'Tidak Sesuai',
                            data: backendDataset.tidak_sesuai,
                            backgroundColor: '#dc3545',
                            borderRadius: 6
                        },
                        {
                            label: 'Tidak Diketahui',
                            data: backendDataset.tidak_diketahui,
                            backgroundColor: '#6c757d', 
                            borderRadius: 6
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top',
                            labels: {
                                boxWidth: 8, 
                                usePointStyle: true, 
                                padding: 25,
                            }
                        }
                    },
                    scales: {
                        x: {
                            grid: { display: false },
                            categoryPercentage: 0.4, // Mengontrol lebar total area satu hari
                            barPercentage: 1.0 // Mengntrol jarak batang bar     
                        },
                        y: {
                            grid: { 
                                color: '#f3f4f6', 
                                drawTicks: false 
                            },
                            ticks: {
                                beginAtZero: true,
                                stepSize: 1, 
                                precision: 0,
                                padding: 10
                            }
                        }
                    }
                }
            });
        });
    </script>

</body>
</html>