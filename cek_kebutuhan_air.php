<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Check</title>

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
        .navbar-flora {
            background-color: #064e3b; 
            backdrop-filter: blur(10px); 
        }

        .navbar-flora .navbar-brand {
            color: #f5f5f5 !important;
            letter-spacing: 1px;
        }

        .navbar-flora .nav-link {
            color: rgba(255, 255, 255, 0.8) !important;
            font-weight: 500;
            transition: 0.3s;
            padding: 10px 15px !important;
        }

        .navbar-flora .nav-link:hover {
            color: #2ecc71 !important;
        }

        .navbar-flora .nav-link.active {
            color: #2ecc71 !important;
            font-weight: 600;
        }

        .tracking-wider { 
            letter-spacing: 0.05em; 
        }
        .form-control:focus { 
            background-color: #f8f9fa !important; 
        }
        .btn-success:hover { 
            background-color: #14462e !important; 
            transform: translateY(-1px); 
        }
        .transition-all { 
            transition: all 0.2s ease-in-out; 
        }

        ::placeholder {
            font-size: 0.85rem; 
            opacity: 0.5 !important; 
            font-weight: 400;
        }
    </style>
</head>
<body class="bg-user-theme">
    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-flora navbar-dark sticky-top shadow-sm">
        <div class="container-fluid"> <a class="navbar-brand fw-bold d-flex align-items-center" href="#">
                <img src="images/logo/FloraMeans_Logo4.png" alt="Logo" width="30" height="30" class="">
                FloraMeans
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto gap-lg-2">
                    <li class="nav-item"><a class="nav-link" href="dashboard_user.php">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link active" href="cek_kebutuhan_air.php">Cek Kebutuhan Air</a></li>
                    <li class="nav-item"><a class="nav-link" href="riwayat_clustering.php">Riwayat Clustering</a></li>
                    <li class="nav-item"><a class="nav-link" href="profil_user.php">Profil</a></li>
                    <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container py-4 py-md-5">
        <div class="row justify-content-center">
            <div class="col-12 col-md-9 col-lg-6 col-xl-5">
                <div class="card border-0 shadow-sm rounded-4 ">
                    <div class="card-body p-4 p-md-5">
                        <div class="text-center mb-4">
                            <h4 class="fw-bold text-dark">Cek Kebutuhan Air</h4>
                            <p class="text-muted small">Input variabel lingkungan untuk identifikasi kategori tanaman.</p>
                        </div>

                            <form id="formClustering" action="proses_kmeans.php" method="POST">
                                <div class="mb-4">
                                    <label class="form-label fw-bold">Nama Tanaman</label>
                                    <input type="text" class="form-control fborder-0 bg-light py-2 px-3 shadow-none rounded-3" name="nama_tanaman" placeholder="Contoh: Lidah Buaya" required>
                                </div>

                                <div class="row g-3">
                                    <div class="col-12 col-md-6 mb-2">
                                        <label class="form-label small fw-bold text-muted text-uppercase">Suhu Udara (°C)</label>
                                        <div class="input-group shadow-sm rounded-3">
                                            <span class="input-group-text bg-white border-end-0 "><i class="bi bi-thermometer-half"></i></span>
                                            <input type="number" step="0.01" class="form-control border-start-0 py-2 shadow-none" name="suhu" placeholder="30.00" required>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 mb-2">
                                        <label class="form-label small fw-bold text-muted text-uppercase">Intensitas Cahaya (Lux)</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-white border-end-0"><i class="bi bi-sun"></i></span>
                                            <input type="number" step="0.01" class="form-control border-start-0 py-2 shadow-none" name="cahaya" placeholder="20000" required>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 mb-2">
                                        <label class="form-label small fw-bold text-muted text-uppercase">Kelembapan Udara (%)</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-white border-end-0"><i class="bi bi-wind"></i></span>
                                            <input type="number" step="0.01" class="form-control border-start-0 py-2 shadow-none" name="lembap_udara" placeholder="60.0" required>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 mb-2">
                                        <label class="form-label small fw-bold text-muted text-uppercase">Kelembapan Tanah (%)</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-white border-end-0"><i class="bi bi-moisture"></i></span>
                                            <input type="number" step="0.01" class="form-control border-start-0 py-2 shadow-none" name="lembap_tanah" placeholder="45.0" required>
                                        </div>
                                    </div>
                                </div>
                            <div class="mt-4 pt-2 border-top">
                                <p class="text-center text-muted" style="font-size: 0.75rem;">
                                    <i class="bi bi-info-circle me-1"></i> Gunakan titik (.) untuk angka desimal.
                                </p>
                            </div>

                                <div class="mt-4">
                                    <button type="button" onclick="konfirmasiClustering()" class="btn btn-success w-100 fw-bold py-2 shadow-sm rounded-3 transition-all" style="background-color: #1a5c3d; border: none;">
                                        Mulai Clustering
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function konfirmasiClustering(){
            const form = document.getElementById('formClustering');
            const inputs = form.querySelectorAll('input[required]');
            let allFilled = true;

            inputs.forEach(input => {
                if (!input.value) allFilled = false;
            });

            if (!allFilled) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Data Belum Lengkap',
                    text: 'Silakan isi semua variabel sensor agar klasifikasi K-Means dapat diproses.',
                    customClass: { confirmButton: 'swal2-confirm-flora' }
                });
                return;
            }
            Swal.fire({
                title: 'Analisis Kebutuhan Air?',
                text: "Sistem akan menganalisis kategori tanaman berdasarkan data yang Anda masukkan.",
                icon: 'question',
                showCancelButton: true,
                cancelButtonColor: "#d33",
                confirmButtonText: 'Ya, Analisis Sekarang',
                cancelButtonText: 'Batal',
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Memproses Data...',
                        html: 'Algoritma K-Means sedang bekerja',
                        timerProgressBar: true,
                        didOpen: () => {
                            Swal.showLoading();
                            setTimeout(() => { form.submit(); }, 800);
                        },
                        allowOutsideClick: false,
                        showConfirmButton: false
                    });
                }
            });
        }
        //Untuk Logout
        const logoutBtn = document.querySelector('a[href="logout.php"]');
        logoutBtn.addEventListener('click', function(e) {
        e.preventDefault(); 
        
        Swal.fire({
            title: 'Konfirmasi Log Out',
            text: "Apakah Anda yakin ingin keluar dari sistem?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6', 
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Keluar',
            cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'logout.php'; 
                }
            });
        });

    </script>
</body>
</html>