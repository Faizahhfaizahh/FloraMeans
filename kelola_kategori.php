<?php
    include 'koneksi.php';
    //Ambil data dari database
    $query = mysqli_query($conn, "SELECT * FROM kategori");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard User FloraMeans</title>

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
        /* Sidebar Styling */
    #sidebar {
        min-width: 250px;
        max-width: 250px;
        background-color: #064e3b; 
        color: white;
        transition: all 0.3s;
        min-height: 100vh;
        position: fixed;
        z-index: 1000;
    }

    #sidebar .sidebar-header {
        padding: 20px;
        background: #043d2e;
    }

    #sidebar ul.components {
        padding: 20px 0;
    }

    #sidebar ul li a {
        padding: 14px 20px;
        font-size: 0.95rem;
        display: block;
        color: rgba(255, 255, 255, 0.7);
        text-decoration: none;
        transition: 0.3s;
    }

    #sidebar ul li a:hover, #sidebar ul li a.active {
        color: #fff;
        background: rgba(255, 255, 255, 0.1);
        border-left: 4px solid #2ecc71;
    }

    #sidebar ul li a i {
        margin-right: 10px;
    }

    #main-content {
        width: 100%;
        padding-left: 300px; 
        transition: all 0.3s;
    }

    .container-box { 
        max-width: 1000px; 
        margin: 0 auto; 
    }

    .card { border: none; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); }
    .btn-primary { background-color: #064e3b; border: none; }
    .btn-primary:hover { background-color: #043d2e; }

    /* Responsive Mobile */
    @media (max-width: 768px) {
            #sidebar { margin-left: -260px; }
            #sidebar.active { margin-left: 0; }
            #main-content { padding-left: 0; }
    }
    </style>

</head>
<body>
    <div class="d-flex">
        <nav id="sidebar" class="shadow">
            <div class="sidebar-header d-flex align-items-center">
                <img src="images/logo/FloraMeans_Logo4.png" alt="Logo" width="30" height="30" class="me-2">
                <h5 class="m-0 fw-bold">FloraMeans</h5>
            </div>

            <ul class="list-unstyled">
                <li><a href="dashboard_admin.php"><i class="bi bi-grid-1x2-fill"></i> Dashboard</a></li>
                <li><a href="kelola_kategori.php" class="active"><i class="bi bi-tags-fill"></i> Kategori</a></li>
                <li><a href="data_referensi_tanaman.php"><i class="bi bi-tree-fill"></i> Daftar Tanaman</a></li>
                <li><a href="standarisasi_lingkungan.php"><i class="bi bi-sliders"></i> Parameter</a></li>
                <li><a href="daftar_pengguna.php"><i class="bi bi-people-fill"></i> Daftar Pengguna</a></li>
                <li><a href="riwayat_clustering.php"><i class="bi bi-clock-history"></i> Riwayat Clustering</a></li>
                <li><a href="logout.php"><i class="bi bi-box-arrow-right"></i> Logout</a></li>
            </ul>
        </nav>

        <main id="main-content">
            <div class="container-fluid p-4 p-md-5">
                <div class="container-box">
                    <div class="d-flex justify-content-between align-items-end mb-4">
                        <div>
                            <h4 class="fw-bold m-0 text-dark">Kelola Kategori</h4>
                        </div>
                        <button class="btn btn-success shadow-sm px-4" data-bs-toggle="modal" data-bs-target="#modalTambah">Tambah Kategori</button>
                    </div>
                </div>

                <div class="card p-4 border-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th class="py-3 px-3">No</th>
                                    <th class="py-3">Nama Kategori</th>
                                    <th class=" py-3 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no =1;
                                while ($row = mysqli_fetch_assoc($query)):
                                ?>
                                <tr>
                                    <td class="px-3"><?= $no++;?></td>
                                    <td class="fw-medium text-dark"><?= $row['nama_kategori'];?></td>
                                    <td class="text-center">
                                        <button class="btn btn-sm btn-outline-warning me-1"><i class="bi bi-pencil-square"></i></button>
                                        <button class="btn btn-sm btn-outline-danger btn-delete"><i class="bi bi-trash"></i></button>
                                    </td>
                                </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Modal Tambah Kategori -->
    <div class="modal fade" id="modalTambah" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header border-0 bg-light">
                    <h5 class="modal-title fw-bold">Tambah Kategori Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="function.php" method="POST">
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label class="form-label">Nama Kategori</label>
                            <input type="text" class="form-control border-0 bg-light py-2" name="nama_kategori" placeholder="Contoh: Xerofit" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" name="btn_simpan_kategori"class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
        
    <script>

        const urlParams = new URLSearchParams(window.location.search);
        const pesan = urlParams.get('pesan');

        // Notifikasi tambah kategori berhasil
        if (pesan === 'sukses_tambah') {
            Swal.fire({
                title: 'Berhasil!',
                text: 'Kategori baru telah ditambahkan ke sistem FloraMeans.',
                icon: 'success',
                confirmButtonColor: '#064e3b' // Warna tema hijau sidebar kamu
            }).then(() => {
                // Bersihkan parameter URL agar alert tidak muncul lagi saat refresh
                window.history.replaceState({}, document.title, window.location.pathname);
            });
        }

        if (pesan === 'duplikat') {
        Swal.fire({
            title: 'Gagal!',
            text: 'Nama kategori tersebut sudah terdaftar di database.',
            icon: 'error',
            confirmButtonColor: '#d33'
        });
    }

        // Untuk hapus kategori
        document.querySelectorAll('.btn-delete').forEach(btn => {
            btn.addEventListener('click', function() {
                Swal.fire({
                    title: 'Hapus Kategori?',
                    text: "Data yang dihapus tidak bisa dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire('Terhapus!', 'Kategori telah dihapus.', 'success');
                    }
                });
            });
        });

        document.getElementById('sidebarCollapse')?.addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('active');
        });

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