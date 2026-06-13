<?php
    require_once 'auth.php';
    require_once 'viewHelper.php';
    require_once 'riwayat_clustering_controller.php';

    Auth::cekLoginUser();
    $id_user = $_SESSION['id_user'];
    $keyword = isset($_GET['search']) && !empty($_GET['search']) ? $_GET['search'] : '';

    $riwayatObj = new Riwayat();
    $totalData  = $riwayatObj->hitungTotalRiwayatUser($id_user, $keyword);
    $pagination = ViewHelper::getPaginationData($totalData, 10);
    $simulasi_riwayat = $riwayatObj->cariRiwayatUser($id_user, $keyword, $pagination['perPage'], $pagination['offset']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Clustering - FloraMeans</title>

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
    <?php ViewHelper::renderStyles() ?>

</head>
<body class="bg-user-theme">
    <?php include 'navbar.php'; ?>

    <main id="main-content">
        <div class="container-fluid p-4 p-md-5">
            
<div class="container-box">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h4 class="fw-bold m-0 text-dark">Riwayat Clustering</h4>
            <p class="text-muted small mt-1 mb-0">Lihat hasil analisis kebutuhan air tanamanmu</p>
        </div>
    </div>
</div>

<?php ViewHelper::renderSearchBar("Cari nama tanaman..."); ?>

            <div class="card p-4 shadow-sm border-0 mt-3">
                <div class="card-body p-0"> 
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light text-secondary">
                                <tr>
                                    <th class="ps-4 py-3" style="width: 70px;">No</th>
                                    <th class="py-3">Nama Tanaman</th>
                                    <th class="py-3 text-center">Hasil Cluster</th>
                                    <th class="py-3">Status Lingkungan</th>
                                    <th class="py-3">Waktu</th>
                                    <th class="py-3 " style="width: 130px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = $pagination['offset'] + 1;
                                if ($totalData > 0) {
                                    foreach($simulasi_riwayat as $row){
                                ?>
                                <tr>
                                    <td class="ps-4 fw-medium text-dark"><?= $no++; ?></td>
                                    <td class="fw-semibold text-dark"><?= htmlspecialchars($row['nama_tanaman']); ?></td>
                                    <td class="text-center">
                                        <?php
                                        $clusterColor = [
                                            'Xerofit'  => ['bg' => '#fef9c3', 'text' => '#854d0e'],
                                            'Mesofit'  => ['bg' => '#dcfce7', 'text' => '#166534'],
                                            'Hidrofit' => ['bg' => '#dbeafe', 'text' => '#1e40af'],
                                            'Higrofit' => ['bg' => '#e0f2fe', 'text' => '#075985'],
                                        ];
                                        $warna = $clusterColor[$row['hasil_cluster']] ?? ['bg' => '#f3f4f6', 'text' => '#374151'];
                                        ?>
                                        <span class="fw-semibold px-3 py-1 rounded-pill" style="background-color: <?= $warna['bg'] ?>; color: <?= $warna['text'] ?>; font-size: 0.85rem;">
                                            <?= $row['hasil_cluster']; ?>
                                        </span>
                                    </td>
                                    <td>
                                        <?php if($row['status_lingkungan'] == 'Sesuai'): ?>
                                            <span class="badge bg-success-subtle text-success px-3 py-2 rounded-pill">
                                                <i class="bi bi-check-circle-fill me-1"></i> Sesuai
                                            </span>
                                        <?php elseif($row['status_lingkungan'] == 'Tidak Sesuai'): ?>
                                            <span class="badge bg-danger-subtle text-danger-emphasis px-3 py-2 rounded-pill">
                                                <i class="bi bi-exclamation-triangle-fill me-1"></i> Tidak Sesuai
                                            </span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary-subtle text-secondary px-3 py-2 rounded-pill">
                                                <i class="bi bi-question-circle me-1 "></i> Tidak Diketahui
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-muted small"><?= $row['waktu']; ?></td>
                                    
                                    <td>
                                        <button class="btn btn-light text-primary border-0 text-decoration-none" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#modalDetailRiwayat<?= $row['id_riwayat']; ?>" 
                                                title="Lihat Detail Parameter">
                                            <i class="bi bi-eye-fill"></i>
                                        </button>
                                    </td>
                                </tr>

                                <!-- Modal Detail Hasil Analisis -->
                                <div class="modal fade" id="modalDetailRiwayat<?= $row['id_riwayat']; ?>"  tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content border-0 shadow" style="border-radius: 16px;">
                                            <div class="modal-header border-bottom-0 pt-4 px-4">
                                                <h5 class="modal-title fw-bold text-dark"><i class="bi bi-info-circle text-primary me-2"></i> Detail Hasil Analisis</h5>
                                                <button type="button" class="btn-close" data-bs-toggle="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body px-4 pb-4">
                                                <p class="text-muted small mb-3">Berikut adalah rincian data sensor lingkungan saat pengujian tanaman <strong><?= $row['nama_tanaman']; ?></strong>.</p>
                                                
                                                <div class="d-flex align-items-center gap-2 mb-3">
                                                    <span class="text-muted small">Hasil Cluster:</span>
                                                    <span class="fw-bold"><?= $row['hasil_cluster']; ?></span>
                                                </div>

                                                <?php if($row['status_lingkungan'] == 'Sesuai'): ?>
                                                    <div class="alert alert-success border-success-subtle d-flex align-items-center mb-4" role="alert">
                                                        <i class="bi bi-shield-check-fill fs-4 me-3"></i>
                                                        <div>
                                                            <span class="fw-bold d-block">Status Kondisi Lingkungan:</span>
                                                            Kondisi lingkungan saat ini <strong>SESUAI</strong> untuk tanaman ini.
                                                        </div>
                                                    </div>
                                                <?php elseif($row['status_lingkungan'] == 'Tidak Sesuai'): ?>
                                                    <div class="alert alert-danger border-danger-subtle d-flex align-items-center mb-4" role="alert">
                                                        <i class="bi bi-shield-exclamation-fill fs-4 me-3"></i>
                                                        <div>
                                                            <span class="fw-bold d-block">Status Kondisi Lingkungan:</span>
                                                            Kondisi lingkungan saat ini <strong>TIDAK SESUAI</strong> untuk tanaman ini.
                                                        </div>
                                                    </div>
                                                <?php else: ?>
                                                    <div class="alert alert-secondary d-flex align-items-center mb-4" role="alert">
                                                        <i class="bi bi-question-circle fs-4 me-3"></i>
                                                        <div>
                                                            <span class="fw-bold d-block">Status Kondisi Lingkungan:</span>
                                                            Tanaman ini belum terdaftar di referensi sistem. Kesesuaian tidak dapat ditentukan.
                                                        </div>
                                                    </div>
                                                <?php endif; ?>

                                                <h6 class="fw-bold text-secondary mb-2" style="font-size: 12px; letter-spacing: 0.5px; text-transform: uppercase;">Nilai Parameter Input</h6>
                                                <div class="row g-2">
                                                    <div class="col-6">
                                                        <div class="p-3 bg-light rounded-3 text-center border">
                                                            <span class="text-muted small d-block mb-1"><i class="bi bi-thermometer-half text-danger"></i> Suhu Udara</span>
                                                            <strong class="fs-5 text-dark"><?= $row['suhu']; ?></strong>
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="p-3 bg-light rounded-3 text-center border">
                                                            <span class="text-muted small d-block mb-1"><i class="bi bi-cloud-haze2 text-primary"></i> Kelembapan Udara</span>
                                                            <strong class="fs-5 text-dark"><?= $row['kelembapan_udara']; ?></strong>
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="p-3 bg-light rounded-3 text-center border">
                                                            <span class="text-muted small d-block mb-1"><i class="bi bi-sun-fill text-warning"></i> Cahaya</span>
                                                            <strong class="fs-5 text-dark"><?= $row['intensitas_cahaya']; ?></strong>
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="p-3 bg-light rounded-3 text-center border">
                                                            <span class="text-muted small d-block mb-1"><i class="bi bi-moisture text-info"></i> Kelembapan Tanah</span>
                                                            <strong class="fs-5 text-dark"><?= $row['kelembapan_tanah']; ?></strong>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php 
                                    } 
                                } else {
                                    echo '<tr><td colspan="6" class="text-center py-5 text-muted"><em>Tidak ditemukan riwayat pengujian tanaman yang sesuai.</em></td></tr>';
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        <?php ViewHelper::renderTableFooter($totalData, "riwayat", $pagination); ?>
    </div>
</main>

<script>
    function konfirmasiHapus(id) {
        Swal.fire({
            title: 'Hapus Riwayat?',
            text: 'Data riwayat clustering ini akan dihapus permanen.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = `riwayat_clustering_controller.php?action=hapus&id=${id}&from=user`;
            }
        });
    }

    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('pesan') === 'sukses_hapus') {
        Swal.fire({
            title: 'Berhasil!',
            text: 'Riwayat clustering telah dihapus.',
            icon: 'success'
        }).then(() => {
            window.history.replaceState({}, document.title, window.location.pathname);
        });
    }
</script>
</body>
</html>