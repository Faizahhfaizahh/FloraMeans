<?php
    require_once 'auth.php';
    Auth::cekLoginUser();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panduan - FloraMeans</title>

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

    <style>
        .card-hover {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            cursor: default;
        }

        .card-hover:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08) !important;
        }

        .step-circle {
            transition: background-color 0.2s ease, color 0.2s ease;
        }

        .step-item:hover .step-circle {
            background-color: #064e3b !important;
            color: white !important;
            border-color: #064e3b !important;
        }

        .status-card {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .status-card:hover {
            transform: translateX(4px);
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.07) !important;
        }
    </style>
</head>
<body class="bg-user-theme">
    <?php include 'navbar.php'; ?>

    <main id="main-content">
        <div class="container-fluid p-4 p-md-5">

            <!-- Header -->
            <div class="mb-4">
                <h4 class="fw-bold m-0 text-dark">Panduan</h4>
                <p class="text-muted small mt-1 mb-0">Pelajari cara menggunakan FloraMeans dan kenali kategori tanamanmu</p>
            </div>

            <!-- Apa itu Clustering -->
            <div class="card border-0 shadow-sm rounded-3 p-4 mb-4">
                <div class="d-flex align-items-center gap-2 mb-2">
                    <i class="bi bi-info-circle text-primary fs-5"></i>
                    <h6 class="fw-bold m-0">Apa itu clustering tanaman?</h6>
                </div>
                <p class="text-muted small mb-0" style="line-height: 1.7;">
                    Sistem FloraMeans mengelompokkan tanaman ke dalam 4 kategori berdasarkan kebutuhan airnya menggunakan metode K-Means. Hasil pengelompokan ini membantu kamu mengetahui apakah kondisi lingkungan saat ini sudah sesuai untuk tanamanmu.
                </p>
            </div>

            <!-- Kategori Tanaman -->
            <h6 class="fw-bold mb-3">Kategori tanaman</h6>
            <div class="row g-3 mb-4">
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="card border-0 shadow-sm rounded-3 p-3 h-100 card-hover">
                        <span class="badge rounded-pill fw-semibold mb-2 d-inline-block" style="background-color: #fef9c3; color: #854d0e; width: fit-content;">Xerofit</span>
                        <p class="text-muted small mb-2" style="line-height: 1.6;">Tanaman tahan kering, butuh sedikit air. Cocok untuk lingkungan panas dan gersang.</p>
                        <p class="mb-0" style="font-size: 0.75rem; color: #9ca3af;">Contoh: Kaktus, Lidah Buaya</p>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="card border-0 shadow-sm rounded-3 p-3 h-100 card-hover">
                        <span class="badge rounded-pill fw-semibold mb-2 d-inline-block" style="background-color: #dcfce7; color: #166534; width: fit-content;">Mesofit</span>
                        <p class="text-muted small mb-2" style="line-height: 1.6;">Tanaman dengan kebutuhan air sedang. Tumbuh di lingkungan normal.</p>
                        <p class="mb-0" style="font-size: 0.75rem; color: #9ca3af;">Contoh: Mangga, Jambu</p>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="card border-0 shadow-sm rounded-3 p-3 h-100 card-hover">
                        <span class="badge rounded-pill fw-semibold mb-2 d-inline-block" style="background-color: #dbeafe; color: #1e40af; width: fit-content;">Hidrofit</span>
                        <p class="text-muted small mb-2" style="line-height: 1.6;">Tanaman yang hidup di dalam atau di permukaan air.</p>
                        <p class="mb-0" style="font-size: 0.75rem; color: #9ca3af;">Contoh: Teratai, Eceng Gondok</p>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="card border-0 shadow-sm rounded-3 p-3 h-100 card-hover">
                        <span class="badge rounded-pill fw-semibold mb-2 d-inline-block" style="background-color: #e0f2fe; color: #075985; width: fit-content;">Higrofit</span>
                        <p class="text-muted small mb-2" style="line-height: 1.6;">Tanaman yang butuh lingkungan lembap dengan kelembapan tinggi.</p>
                        <p class="mb-0" style="font-size: 0.75rem; color: #9ca3af;">Contoh: Pakis, Lumut</p>
                    </div>
                </div>
            </div>

            <!-- Cara Penggunaan -->
            <h6 class="fw-bold mb-3">Cara menggunakan cek kebutuhan air</h6>
            <div class="card border-0 shadow-sm rounded-3 p-4 mb-4">
                <div class="d-flex flex-column gap-3">
                    <div class="d-flex gap-3 align-items-start step-item">
                        <div class="rounded-circle bg-light border d-flex align-items-center justify-content-center flex-shrink-0 step-circle " style="width: 30px; height: 30px; font-size: 13px; font-weight: 600;">1</div>
                        <div>
                            <p class="fw-semibold small mb-1">Siapkan alat sensor</p>
                            <p class="text-muted small mb-0">Ukur suhu udara, kelembapan udara, intensitas cahaya, dan kelembapan tanah di sekitar tanamanmu menggunakan alatmu sendiri.</p>
                        </div>
                    </div>
                    <div class="d-flex gap-3 align-items-start step-item">
                        <div class="rounded-circle bg-light border d-flex align-items-center justify-content-center flex-shrink-0 step-circle " style="width: 30px; height: 30px; font-size: 13px; font-weight: 600;">2</div>
                        <div>
                            <p class="fw-semibold small mb-1">Isi form cek kebutuhan</p>
                            <p class="text-muted small mb-0">Masukkan nama tanaman dan nilai hasil bacaan sensor ke dalam form yang tersedia di menu Cek Kebutuhan.</p>
                        </div>
                    </div>
                    <div class="d-flex gap-3 align-items-start step-item">
                        <div class="rounded-circle bg-light border d-flex align-items-center justify-content-center flex-shrink-0 step-circle " style="width: 30px; height: 30px; font-size: 13px; font-weight: 600;">3</div>
                        <div>
                            <p class="fw-semibold small mb-1">Lihat hasil cluster</p>
                            <p class="text-muted small mb-0">Sistem akan menghitung dan menampilkan kategori tanaman beserta status kesesuaian lingkungannya.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Arti Status Lingkungan -->
            <h6 class="fw-bold mb-3">Arti status lingkungan</h6>
            <div class="d-flex flex-column gap-2">
                <div class="card border-0 shadow-sm rounded-3 p-3 status-card">
                    <div class="d-flex align-items-start gap-3">
                        <span class="badge rounded-pill fw-semibold flex-shrink-0 mt-1" style="background-color: #dcfce7; color: #166534;">Sesuai</span>
                        <p class="text-muted small mb-0" style="line-height: 1.7;">Kondisi lingkungan saat ini cocok untuk tanaman tersebut. Pertahankan kondisi ini agar tanaman tetap tumbuh optimal.</p>
                    </div>
                </div>
                <div class="card border-0 shadow-sm rounded-3 p-3 status-card">
                    <div class="d-flex align-items-start gap-3">
                        <span class="badge rounded-pill fw-semibold flex-shrink-0 mt-1" style="background-color: #fee2e2; color: #be123c;">Tidak Sesuai</span>
                        <p class="text-muted small mb-0" style="line-height: 1.7;">Kondisi lingkungan saat ini kurang cocok untuk tanaman tersebut. Pertimbangkan untuk menyesuaikan kondisi lingkungan tanamanmu.</p>
                    </div>
                </div>
                <div class="card border-0 shadow-sm rounded-3 p-3 status-card">
                    <div class="d-flex align-items-start gap-3">
                        <span class="badge rounded-pill fw-semibold flex-shrink-0 mt-1" style="background-color: #e2e8f0; color: #475569;">Tidak Diketehui</span>
                        <p class="text-muted small mb-0" style="line-height: 1.7;">Nama tanaman belum terdaftar di referensi sistem. Kesesuaian lingkungan tidak dapat ditentukan.</p>
                    </div>
                </div>
            </div>

        </div>
    </main>
</body>
</html>