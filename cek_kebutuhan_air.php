<?php
    require_once 'auth.php';
    Auth::cekLoginUser();

    $authObj = new Auth();
    $koneksi = (fn() => $this->conn)->call($authObj); //Memanggil conn pda database yang bersifat protected

    $query = "SELECT DISTINCT nama_tanaman FROM tanaman ORDER BY nama_tanaman ASC";
    $result = mysqli_query($koneksi, $query);

    $daftar_tanaman = [];
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $daftar_tanaman[] = $row['nama_tanaman'];
        }
    }
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cek Kebutuhan Air - FloraMeans </title>

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
        .tracking-wider { 
            letter-spacing: 0.05em; 
        }
        .form-control:focus { 
            background-color: #f8f9fa !important; 
        }
        .btn-success:hover { 
            background-color: #2ecc71 !important; 
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
    <?php include 'navbar.php'; ?>

    <div class="container py-4 py-md-5">
        <div class="row justify-content-center">
            <div class="col-12 col-md-9 col-lg-6 col-xl-5">
                <div class="card border-0 shadow-sm rounded-4 ">
                    <div class="card-body p-4 p-md-5">
                        <div class="text-center mb-4">
                            <h4 class="fw-bold text-dark">Cek Kebutuhan Air</h4>
                            <p class="text-muted small">Masukkan data sensor tanamanmu untuk mengetahui kategori dan kebutuhan airnya.</p>
                        </div>

                            <form id="formClustering" action="proses_kmeans.php" method="POST">
                                <div class="mb-4">
                                    <label class="form-label" for="tambah_nama_tanaman">Nama Tanaman</label>
                                    <input type="text"  id="tambah_nama_tanaman" class="form-control fborder-0 bg-white py-2 px-3 shadow-none rounded-3" name="nama_tanaman" placeholder="Lidah Buaya" list="listTanaman" required>
                                    <datalist id="listTanaman">
                                        <?php foreach ($daftar_tanaman as $nama): ?>
                                            <option value="<?= htmlspecialchars($nama); ?>">
                                        <?php endforeach; ?>
                                    </datalist>
                                </div>

                                <div class="row g-3">
                                    <div class="col-12 col-md-6 mb-2">
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                            <label class="form-label small mb-0" for="tambah_suhu_udara"><i class="bi bi-thermometer-half me-1"></i>Suhu Udara (°C)</label>
                                            <span class="badge bg-light text-dark border fw-semibold" id="label_suhu_udara">30.0</span>
                                        </div>
                                        <input type="range" id="tambah_suhu_udara" class="form-range" name="suhu_input" min="0" max="60" step="0.1" value="30" oninput="document.getElementById('label_suhu_udara').textContent = this.value" required>
                                    </div>
                                    <div class="col-12 col-md-6 mb-2">
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                            <label class="form-label small mb-0" for="tambah_intensitas_cahaya"><i class="bi bi-sun me-1"></i>Intensitas Cahaya (Lux)</label>
                                            <span class="badge bg-light text-dark border fw-semibold" id="label_intensitas_cahaya">20000</span>
                                        </div>
                                        <input type="range" id="tambah_intensitas_cahaya" class="form-range" name="cahaya_input" min="0" max="130000" step="100" value="20000" oninput="document.getElementById('label_intensitas_cahaya').textContent = this.value" required>
                                    </div>
                                    <div class="col-12 col-md-6 mb-2">
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                            <label class="form-label small mb-0" for="tambah_kelembapan_udara"><i class="bi bi-wind me-1"></i>Kelembapan Udara (%)</label>
                                            <span class="badge bg-light text-dark border fw-semibold" id="label_kelembapan_udara">60.0</span>
                                        </div>
                                        <input type="range" id="tambah_kelembapan_udara" class="form-range" name="lembab_udara_input" min="0" max="100" step="0.1" value="60" oninput="document.getElementById('label_kelembapan_udara').textContent = this.value" required>
                                    </div>
                                    <div class="col-12 col-md-6 mb-2">
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                            <label class="form-label small mb-0" for="tambah_kelembapan_tanah"><i class="bi bi-moisture me-1"></i>Kelembapan Tanah (%)</label>
                                            <span class="badge bg-light text-dark border fw-semibold" id="label_kelembapan_tanah">45.0</span>
                                        </div>
                                        <input type="range" id="tambah_kelembapan_tanah" class="form-range" name="lembab_tanah_input" min="0" max="100" step="0.1" value="45" oninput="document.getElementById('label_kelembapan_tanah').textContent = this.value" required>
                                    </div>
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
                    text: 'Silakan isi semua data agar klasifikasi K-Means dapat diproses.',
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

    </script>
</body>
</html>