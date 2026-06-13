<?php
require_once 'auth.php';
require_once 'database.php';

Auth::cekLoginUser();

$db   = new Database();
// $conn = $db->conn;
$authObj = new Auth();
$conn = (fn() => $this->conn)->call($authObj);

// Validasi parameter ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: cek_kebutuhan_air.php");
    exit;
}

$id_simulasi = intval($_GET['id']);
$id_user     = $_SESSION['id_user'];

// Ambil data hasil simulasi — pastikan hanya milik user yang login
$query = "
    SELECT s.*, k.nama_kategori as kategori_referensi
    FROM simulasi s
    LEFT JOIN tanaman t ON s.id_tanaman = t.id_tanaman
    LEFT JOIN kategori k ON t.id_kategori = k.id_kategori
    WHERE s.id_simulasi = '$id_simulasi' AND s.id_user = '$id_user'
    LIMIT 1
";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) === 0) {
    header("Location: cek_kebutuhan_air.php");
    exit;
}

$data = mysqli_fetch_assoc($result);

// Warna badge per cluster
$clusterColor = [
    'Xerofit'  => ['bg' => '#fef9c3', 'text' => '#854d0e'],
    'Mesofit'  => ['bg' => '#dcfce7', 'text' => '#166534'],
    'Hidrofit' => ['bg' => '#dbeafe', 'text' => '#1e40af'],
    'Higrofit' => ['bg' => '#e0f2fe', 'text' => '#075985'],
];
$warna = $clusterColor[$data['hasil_clustering']] ?? ['bg' => '#f3f4f6', 'text' => '#374151'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Clustering - FloraMeans</title>

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
</head>
<body class="bg-user-theme">
    <?php include 'navbar.php'; ?>

    <main id="main-content">
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-12 col-md-9 col-lg-6 col-xl-5">
                    <div class="card border-0 shadow-sm rounded-4">
                        <div class="card-body p-4 p-md-5">

                            <!-- Header hasil -->
                            <div class="text-center mb-4">
                                <div class="mb-3">
                                    <?php if ($data['status_lingkungan'] === 'Sesuai'): ?>
                                        <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-2" style="width: 70px; height: 70px; background-color: #dcfce7;">
                                            <i class="bi bi-check-circle-fill text-success fs-2"></i>
                                        </div>
                                    <?php elseif ($data['status_lingkungan'] === 'Tidak Sesuai'): ?>
                                        <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-2" style="width: 70px; height: 70px; background-color: #fee2e2;">
                                            <i class="bi bi-x-circle-fill text-danger fs-2"></i>
                                        </div>
                                    <?php else: ?>
                                        <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-2" style="width: 70px; height: 70px; background-color: #f3f4f6;">
                                            <i class="bi bi-question-circle-fill text-secondary fs-2"></i>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <h5 class="fw-bold text-dark mb-1">Hasil Analisis</h5>
                                <p class="text-muted small mb-0">
                                    Tanaman <strong><?= htmlspecialchars($data['nama_tanaman_input']); ?></strong>
                                </p>
                            </div>

                            <!-- Hasil Cluster -->
                            <div class="d-flex justify-content-between align-items-center p-3 rounded-3 mb-3" style="background-color: #f9fafb;">
                                <span class="text-muted small fw-medium">Hasil Cluster</span>
                                <span class="fw-bold px-3 py-1 rounded-pill" style="background-color: <?= $warna['bg'] ?>; color: <?= $warna['text'] ?>; font-size: 0.85rem;">
                                    <?= htmlspecialchars($data['hasil_clustering']); ?>
                                </span>
                            </div>

                            <!-- Status Lingkungan -->
                            <div class="alert <?= $data['status_lingkungan'] === 'Sesuai' ? 'alert-success' : ($data['status_lingkungan'] === 'Tidak Sesuai' ? 'alert-danger' : 'alert-secondary') ?> d-flex align-items-center mb-4" role="alert">
                                <i class="bi <?= $data['status_lingkungan'] === 'Sesuai' ? 'bi-shield-check-fill' : ($data['status_lingkungan'] === 'Tidak Sesuai' ? 'bi-shield-exclamation-fill' : 'bi-shield-fill') ?> fs-4 me-3"></i>
                                <div>
                                    <span class="fw-bold d-block">Status Kondisi Lingkungan:</span>
                                    <?php if ($data['status_lingkungan'] === 'Sesuai'): ?>
                                        Kondisi lingkungan saat ini <strong>SESUAI</strong> untuk tanaman ini.
                                    <?php elseif ($data['status_lingkungan'] === 'Tidak Sesuai'): ?>
                                        Kondisi lingkungan saat ini <strong>TIDAK SESUAI</strong> untuk tanaman ini.
                                    <?php else: ?>
                                        Tanaman ini <strong>belum terdaftar</strong> di referensi sistem. Status lingkungan tidak dapat ditentukan.
                                    <?php endif; ?>
                                </div>
                            </div>

                            <!-- Nilai Sensor -->
                            <h6 class="fw-bold text-secondary mb-2" style="font-size: 12px; letter-spacing: 0.5px; text-transform: uppercase;">Nilai Parameter yang Diinput</h6>
                            <div class="row g-2 mb-4">
                                <div class="col-6">
                                    <div class="p-3 bg-light rounded-3 text-center border">
                                        <span class="text-muted small d-block mb-1">
                                            <i class="bi bi-thermometer-half text-danger"></i> Suhu Udara
                                        </span>
                                        <strong class="fs-5 text-dark"><?= $data['suhu_input']; ?>°C</strong>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="p-3 bg-light rounded-3 text-center border">
                                        <span class="text-muted small d-block mb-1">
                                            <i class="bi bi-sun-fill text-warning"></i> Intensitas Cahaya
                                        </span>
                                        <strong class="fs-5 text-dark"><?= $data['cahaya_input']; ?> Lux</strong>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="p-3 bg-light rounded-3 text-center border">
                                        <span class="text-muted small d-block mb-1">
                                            <i class="bi bi-cloud-haze2 text-primary"></i> Kelembapan Udara
                                        </span>
                                        <strong class="fs-5 text-dark"><?= $data['lembab_udara_input']; ?>%</strong>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="p-3 bg-light rounded-3 text-center border">
                                        <span class="text-muted small d-block mb-1">
                                            <i class="bi bi-moisture text-info"></i> Kelembapan Tanah
                                        </span>
                                        <strong class="fs-5 text-dark"><?= $data['lembab_tanah_input']; ?>%</strong>
                                    </div>
                                </div>
                            </div>

                            <!-- Tombol aksi -->
                            <div class="d-flex gap-2">
                                <a href="cek_kebutuhan_air.php" class="btn btn-outline-secondary w-50 fw-semibold py-2 rounded-3">
                                    <i class="bi bi-arrow-repeat me-1"></i> Cek Lagi
                                </a>
                                <a href="riwayat_clustering_user.php" class="btn w-50 fw-semibold py-2 rounded-3 text-white" style="background-color: #064e3b; border: none;">
                                    <i class="bi bi-clock-history me-1"></i> Lihat Riwayat
                                </a>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>