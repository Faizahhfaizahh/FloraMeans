<?php
require_once 'auth.php';
require_once 'dashboard_controller.php';
Auth::cekLoginUser();
$id_user = $_SESSION['id_user'];

$dashboard     = new Dashboard();
$total_clustering = $dashboard->getTotalClustering($id_user);
$lingkungan_sesuai = $dashboard->getLingkunganSesuai($id_user);
$lingkungan_tidak_sesuai = $dashboard->getLingkunganTidakSesuai($id_user);
$dataScatter   = $dashboard->getDataScatterPlot($id_user);
$dataCentroid  = $dashboard->getCentroidKategori();
$semuaMingguan = $dashboard->getSemuaAktivitasMingguan($id_user);
$semuaBulanan  = $dashboard->getSemuaAktivitasBulanan($id_user);
$daftarTanaman = $dashboard->getDaftarTanamanDicek($id_user);
$tanamanDefault = !empty($daftarTanaman) ? $daftarTanaman[0]['nama'] : null;
$dataTrenSensor = $tanamanDefault ? $dashboard->getTrenSensorTanaman($id_user, $tanamanDefault) : null;
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
                    <div class="mt-2 text-muted small">Tanaman dalam kondisi optimal</div>
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
                    <div class="mt-2 text-muted small">Tanaman memerlukan penyesuaian</div>
                </div>
            </div>
        </div>
        <!-- Card Aktivitas (Mingguan/Bulanan) Dan Tren Sensor -->
        <div class="row g-4 mb-4">
            <div class="col-12 col-lg-5">
                <div class="card card-custom p-4 h-100">
                    <div class="d-flex justify-content-between align-items-start mb-3 flex-wrap gap-2">
                        <div>
                            <h5 class="fw-bold text-dark m-0">Aktivitas Clustering</h5>
                        </div>
                        <div class="d-flex align-items-center gap-2 flex-wrap">
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-sm btn-dark" id="btnMingguan">Mingguan</button>
                                <button type="button" class="btn btn-sm btn-outline-secondary" id="btnBulanan">Bulanan</button>
                            </div>
                            <select class="form-select form-select-sm" id="pilihPeriode" style="width: auto; max-width: 180px;"></select>
                        </div>
                    </div>
                    <div style="position: relative; height:280px; width:100%">
                        <canvas id="aktivitasChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-7">
                <div class="card card-custom p-4 h-100">
                    <div class="d-flex justify-content-between align-items-start mb-3 flex-wrap gap-2">
                        <div>
                            <h5 class="fw-bold text-dark m-0">Tren Lingkungan Tanaman</h5>
                        </div>
                        <?php if (!empty($daftarTanaman)): ?>
                            <select class="form-select form-select-sm" id="pilihTanaman" style="width: auto; max-width: 180px;">
                                <?php foreach ($daftarTanaman as $t): ?>
                                    <option value="<?= htmlspecialchars($t['nama']); ?>">
                                        <?= htmlspecialchars($t['nama']); ?> (<?= $t['jumlah']; ?>x)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        <?php endif; ?>
                    </div>
                    <?php if (!empty($daftarTanaman)): ?>
                        <div style="position: relative; height:280px; width:100%">
                            <canvas id="trenSensorChart"></canvas>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-5 text-muted">
                            <i class="bi bi-graph-up fs-1 d-block mb-2"></i>
                            <p class="mb-0 small">Belum ada data sensor.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <!-- Grafik Scatter Plot -->
        <div class="row g-4 mb-4">
            <div class="col-12 col-lg-6">
                <div class="card card-custom p-4">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h5 class="fw-bold text-dark m-0">Suhu vs Kelembapan Udara</h5>
                    </div>
                    <div style="position: relative; height:320px; width:100%">
                        <canvas id="scatterSuhuKelembapan"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-6">
                <div class="card card-custom p-4">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h5 class="fw-bold text-dark m-0">Intensitas Cahaya vs Kelembapan Tanah</h5>
                    </div>
                    <div style="position: relative; height:320px; width:100%">
                        <canvas id="scatterCahayaTanah"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Scater Plot
        const dataScatter  = <?php echo json_encode($dataScatter); ?>;
        const dataCentroid = <?php echo json_encode($dataCentroid); ?>;

        function buatScatterChart(canvasId, dataTitik, dataCentroidSet, labelX, labelY) {
            const ctx = document.getElementById(canvasId).getContext('2d');

            const kategoriList = ['Xerofit', 'Mesofit', 'Hidrofit', 'Higrofit'];
            const warnaKategori = {
                'Xerofit': '#ca8a04',
                'Mesofit': '#166534',
                'Hidrofit': '#0891b2',
                'Higrofit': '#1e40af'
            };
            const titikOutlier = dataTitik.filter(d => d.outlier);
            const datasetsKategori = kategoriList.map(kat => {
                const titikKategori = dataTitik.filter(d => !d.outlier && d.kategori === kat);
                return {
                    label: kat,
                    data: titikKategori.map(d => ({ x: d.x, y: d.y })),
                    backgroundColor: warnaKategori[kat],
                    pointRadius: 5,
                    pointHoverRadius: 7
                };
            });
            new Chart(ctx, {
                type: 'scatter',
                data: {
                    datasets: [
                        ...datasetsKategori,
                        {
                            label: 'Outlier',
                            data: titikOutlier.map(d => ({ x: d.x, y: d.y })),
                            backgroundColor: '#dc2626',
                            pointRadius: 7,
                            pointHoverRadius: 9
                        },
                        {
                            label: 'Centroid',
                            data: dataCentroidSet.map(d => ({ x: d.x, y: d.y })),
                            backgroundColor: dataCentroidSet.map(d => d.color),
                            pointRadius: 10,
                            pointHoverRadius: 12
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top',
                            labels: {
                                boxWidth: 8,
                                usePointStyle: true,
                                padding: 20,
                                font: { family: 'Poppins', size: 11 }
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const point = context.raw;
                                    return `${labelX}: ${point.x}, ${labelY}: ${point.y}`;
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            title: { display: true, text: labelX, font: { family: 'Poppins', size: 12} },
                            grid: { color: '#f3f4f6' }
                        },
                        y: {
                            title: { display: true, text: labelY, font: { family: 'Poppins', size: 12} },
                            grid: { color: '#f3f4f6' }
                        }
                    }
                },
                plugins: [{
                    id: 'legendMargin',
                    beforeInit(chart) {
                        const originalFit = chart.legend.fit;
                        chart.legend.fit = function fit() {
                            originalFit.bind(chart.legend)();
                            this.height += 15;
                        };
                    }
                }]
            });
        }
        // Chart 1: Suhu vs Kelembapan Udara
        buatScatterChart(
            'scatterSuhuKelembapan',
            dataScatter.suhu_kelembapan,
            dataCentroid.suhu_kelembapan,
            'Suhu Udara (°C)',
            'Kelembapan Udara (%)'
        );
        // Chart 2: Cahaya vs Kelembapan Tanah
        buatScatterChart(
            'scatterCahayaTanah',
            dataScatter.cahaya_tanah,
            dataCentroid.cahaya_tanah,
            'Intensitas Cahaya (Lux)',
            'Kelembapan Tanah (%)'
        );

        // Aktivitas Grafik
        let aktivitasChartInstance = null;
        const semuaMingguan = <?php echo json_encode($semuaMingguan); ?>;
        const semuaBulanan  = <?php echo json_encode($semuaBulanan); ?>;
        let modeAktivitasSaatIni = 'mingguan';

        function renderAktivitasChart(labels, data) {
            const ctx = document.getElementById('aktivitasChart').getContext('2d');

            if (aktivitasChartInstance) {
                aktivitasChartInstance.destroy();
            }
            aktivitasChartInstance = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Total Simulasi',
                        data: data,
                        backgroundColor: '#198754',
                        borderRadius: 6,
                        maxBarThickness: 40
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            callbacks: {
                                title: function(context) {
                                    const prefix = modeAktivitasSaatIni === 'mingguan' ? 'Hari: ' : 'Tanggal: ';
                                    return prefix + context[0].label;
                                },
                                label: function(context) {
                                    return 'Total Simulasi: ' + context.raw;
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            title: {display: true, text: 'Waktu Simulasi', font: {size: 10}},
                            grid: { display: false }
                        },
                        y: {
                            title: {display: true, text: 'Jumlah Simulasi', font: {size: 10}},
                            grid: { color: '#f3f4f6', drawTicks: false },
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
        }

        function isiDropdownPeriode(dataset) {
            const select = document.getElementById('pilihPeriode');
            select.innerHTML = '';

            dataset.forEach((item, index) => {
                const opt = document.createElement('option');
                opt.value = index;
                opt.textContent = item.label;
                select.appendChild(opt);
            });
        }

        function gantiPeriode() {
            const select = document.getElementById('pilihPeriode');
            const index = parseInt(select.value);

            const dataset = modeAktivitasSaatIni === 'mingguan' ? semuaMingguan : semuaBulanan;
            const item = dataset[index];

            if (item) {
                renderAktivitasChart(item.labels_chart, item.data_chart);
            }
        }

        function gantiModeAktivitas(mode) {
            modeAktivitasSaatIni = mode;
            if (mode === 'mingguan') {
                document.getElementById('btnMingguan').classList.replace('btn-outline-secondary', 'btn-dark');
                document.getElementById('btnBulanan').classList.replace('btn-dark', 'btn-outline-secondary');
                isiDropdownPeriode(semuaMingguan);
            } else {
                document.getElementById('btnBulanan').classList.replace('btn-outline-secondary', 'btn-dark');
                document.getElementById('btnMingguan').classList.replace('btn-dark', 'btn-outline-secondary');
                isiDropdownPeriode(semuaBulanan);
            }
            gantiPeriode();
        }
        document.getElementById('btnMingguan').addEventListener('click', () => gantiModeAktivitas('mingguan'));
        document.getElementById('btnBulanan').addEventListener('click', () => gantiModeAktivitas('bulanan'));
        document.getElementById('pilihPeriode').addEventListener('change', gantiPeriode);
        gantiModeAktivitas('mingguan');

        // Tren Sensor per Tanaman
        <?php if (!empty($daftarTanaman)): ?>
        let trenSensorChartInstance = null;
        const daftarTanamanList = <?php echo json_encode($daftarTanaman); ?>;
        let dataTrenAwal = <?php echo json_encode($dataTrenSensor); ?>;

        function renderTrenSensorChart(dataset) {
            const ctx = document.getElementById('trenSensorChart').getContext('2d');

            if (trenSensorChartInstance) {
                trenSensorChartInstance.destroy();
            }

            trenSensorChartInstance = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: dataset.labels,
                    datasets: [
                        {
                            label: 'Suhu Udara (°C)',
                            data: dataset.suhu,
                            borderColor: '#dc2626',
                            backgroundColor: '#dc2626',
                            tension: 0.1,
                            pointRadius: 4,
                            borderWidth: 2
                        },
                        {
                            label: 'Kelembapan Udara (%)',
                            data: dataset.lembab_udara,
                            borderColor: '#7c3aed',
                            backgroundColor: '#7c3aed',
                            tension: 0.1,
                            pointRadius: 4,
                            borderWidth: 2
                        },
                        {
                            label: 'Kelembapan Tanah (%)',
                            data: dataset.lembab_tanah,
                            borderColor: '#0891b2',
                            backgroundColor: '#0891b2',
                            tension: 0.1,
                            pointRadius: 4,
                            borderWidth: 2
                        },
                        {
                            label: 'Intensitas Cahaya (dinormalisasi)',
                            data: dataset.cahaya,
                            borderColor: '#ca8a04',
                            backgroundColor: '#ca8a04',
                            tension: 0.1,
                            pointRadius: 4,
                            borderWidth: 2
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top',
                            labels: {
                                boxWidth: 8,
                                usePointStyle: true,
                                padding: 16,
                                font: { family: 'Poppins', size: 10 }
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    if (context.dataset.label.includes('Cahaya')) {
                                        const nilaiAsli = dataset.cahaya_asli[context.dataIndex];
                                        return `Cahaya: ${nilaiAsli} Lux`;
                                    }
                                    return `${context.dataset.label}: ${context.raw}`;
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            title: {display: true, text: 'Waktu Pengecekan', font: {size: 10}},
                            grid: { display: false },
                            ticks: { font: { size: 10 } }
                        },
                        y: {
                            min: 0,
                            max: 100,
                            title: { display: true, text: 'Nilai (Suhu °C / Kelembapan % / Cahaya)', font: { size: 10 } },
                            grid: { color: '#f3f4f6' }
                        }
                    }
                },
                plugins: [{
                    id: 'legendMargin',
                    beforeInit(chart) {
                        const originalFit = chart.legend.fit;
                        chart.legend.fit = function fit() {
                            originalFit.bind(chart.legend)();
                            this.height += 15;
                        };
                    }
                }]
            });
        }

        document.getElementById('pilihTanaman').addEventListener('change', function() {
            const namaTanamanTerpilih = this.value;
            fetch('ajax_tren_sensor.php?nama_tanaman=' + encodeURIComponent(namaTanamanTerpilih))
                .then(res => res.json())
                .then(data => renderTrenSensorChart(data));
        });
        renderTrenSensorChart(dataTrenAwal);
        <?php endif; ?>
    });
</script>
</body>
</html>