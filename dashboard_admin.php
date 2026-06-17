<?php
require_once 'auth.php';
require_once 'dashboard_controller.php';
Auth::cekLoginAdmin();

$dashboardObj     = new Dashboard();
$total_pengguna   = $dashboardObj->getTotalPengguna();
$total_tanaman    = $dashboardObj->getTotalTanaman();
$total_clustering = $dashboardObj->getTotalClustering();
$total_kat_terisi = $dashboardObj->getTotalKategoriTerisi();
$dataMingguanAdmin = $dashboardObj->getAktivitasMingguanAdmin();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - FloraMeans Admin</title>

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
</head>
<body>
    <div class="d-flex">
        <?php include 'sidebar.php'; ?> 

        <main id="main-content">
            <div class="container-fluid p-4 p-md-5">
                <!-- Header -->
                 <div class="mb-4">
                    <h4 class="fw-bold m-0 text-dark">Dashboard</h4>
                    <p class="text-muted small mt-1 mb-0">Selamat datang, <?= htmlspecialchars($nama_admin);?>! Berikut ringkasan sistem FloraMeans</p>
                 </div>
                 <!-- Card -->
                <div class="row g-4 mb-4">
                    <!-- Total Pengguna -->
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="card border-0 shadow-sm rounded-4 p-4 h-100">
                            <div class="d-flex align-items-center gap-3">
                                <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0" 
                                    style="width: 56px; height: 56px; background-color: #dbeafe;">
                                    <i class="bi bi-people-fill" style="color: #1e40af; font-size: 1.5rem;"></i>
                                </div>
                                <div>
                                    <h2 class="fw-bold text-dark mb-0"><?= $total_pengguna; ?></h2>
                                    <p class="text-muted small mb-0">Total Pengguna</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Total Tanaman -->
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="card border-0 shadow-sm rounded-4 p-4 h-100">
                            <div class="d-flex align-items-center gap-3">
                                <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0" 
                                    style="width: 56px; height: 56px; background-color: #dcfce7;">
                                    <i class="bi bi-flower1" style="color: #166534; font-size: 1.5rem;"></i>
                                </div>
                                <div>
                                    <h2 class="fw-bold text-dark mb-0"><?= $total_tanaman; ?></h2>
                                    <p class="text-muted small mb-0">Total Tanaman</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Total Clustering -->
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="card border-0 shadow-sm rounded-4 p-4 h-100">
                            <div class="d-flex align-items-center gap-3">
                                <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0" 
                                    style="width: 56px; height: 56px; background-color: #fef9c3;">
                                    <i class="bi bi-graph-up" style="color: #854d0e; font-size: 1.5rem;"></i>
                                </div>
                                <div>
                                    <h2 class="fw-bold text-dark mb-0"><?= $total_clustering; ?></h2>
                                    <p class="text-muted small mb-0">Total Clustering</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Kategori Terisi -->
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="card border-0 shadow-sm rounded-4 p-4 h-100">
                            <div class="d-flex align-items-center gap-3">
                                <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0" 
                                    style="width: 56px; height: 56px; background-color: #f3e8ff;">
                                    <i class="bi bi-sliders" style="color: #7e22ce; font-size: 1.5rem;"></i>
                                </div>
                                <div>
                                    <h2 class="fw-bold text-dark mb-0"><?= $total_kat_terisi; ?>/4</h2>
                                    <p class="text-muted small mb-0">Parameter Terisi</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Grafik AKtivitas -->
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="card card-custom p-4">
                            <div class="mb-3">
                                <h5 class="fw-bold text-dark m-0">Aktivitas Mingguan</h5>
                                <p class="text-muted small">Frekuensi simulasi clustering harian pengguna</p>
                            </div>
                            <div style="position: relative; height:280px; width:100%">
                                <canvas id="adminAktivitasChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const ctx = document.getElementById('adminAktivitasChart').getContext('2d');
            const dataMingguanReal = <?php echo json_encode($dataMingguanAdmin); ?>;

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'],
                    datasets: [{
                        label: 'Simulasi oleh Pengguna',
                        data: dataMingguanReal, 
                        backgroundColor: '#198754', 
                        borderRadius: 8, 
                        maxBarThickness: 25 
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false } 
                    },
                    scales: {
                        x: {
                            grid: { display: false },
                            categoryPercentage: 0.4
                        },
                        y: {
                            grid: { color: '#f3f4f6', drawTicks: false },
                            border: { dash: [5, 5] },
                            ticks: {
                                beginAtZero: true,
                                stepSize: 1,
                                precision: 0,
                                padding: 8
                            }
                        }
                    }
                }
            });
        });
    </script>
</body>
</html>