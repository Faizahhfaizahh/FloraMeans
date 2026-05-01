<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Mengambil data terbaru dari session atau database
$current_username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Profile</title>

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

        .btn-profile {
            background-color: #1a5c3d; 
            border: none;
        }

        .btn-profile:hover {
            background-color: #27ae60;
            color: white;
        }
    </style>

</head>
<body>
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
                    <li class="nav-item"><a class="nav-link" href="dashbaord_user.php">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="cek_kebutuhan_air.php">Cek Kebutuhan Air</a></li>
                    <li class="nav-item"><a class="nav-link" href="riwayat_clustering.php">Riwayat Clustering</a></li>
                    <li class="nav-item"><a class="nav-link active" href="profil_user.php">Profil</a></li>
                    <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- profil.php -->
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-5">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4 p-md-5">
                    <!-- Avatar Section -->
                    <div class="text-center mb-4">
                        <div class="bg-user-theme rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                            <i class="bi bi-person-fill text-success fs-1"></i>
                        </div>
                        <h5 class="fw-bold m-0">Profil Pengguna</h5>
                        <p class="text-muted small mt-2">Kelola informasi akun Anda di FloraMeans</p>
                    </div>

                    <form action="function.php" method="POST" id="formUpdateProfile">
                        <input type="hidden" name="action" value="updateProfile">
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Username</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0"><i class="bi bi-person"></i></span>
                                <input type="text" class="form-control bg-light border-0" name="username" value="<?= $_SESSION['username']; ?>" required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="passwordBaru" class="form-label small fw-bold">Password Baru</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0"><i class="bi bi-lock"></i></span>
                                <input type="password" class="form-control bg-light border-0 shadow-none" name="password" id="passwordBaru" placeholder="Isi jika ingin ganti">
                                <span class="input-group-text bg-light border-0" id="togglePassword" style="cursor: pointer;">
                                    <i class="bi bi-eye" id="toggleIcon"></i>
                                </span>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-profile btn-success w-100 fw-bold py-2 rounded-3 shadow-sm transition-all">
                            Update Profil
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>  
</div>

<script>
    const togglePassword = document.querySelector('#togglePassword');
    const toggleIcon = document.querySelector('#toggleIcon');
    const passwordField = document.querySelector('#passwordBaru');

    togglePassword.addEventListener('click', function () {
        const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordField.setAttribute('type', type);
        toggleIcon.classList.toggle('bi-eye');
        toggleIcon.classList.toggle('bi-eye-slash');
    });

    document.getElementById('formUpdateProfile').addEventListener('submit', function(e) {
        e.preventDefault(); 
        const form = this;
        const newPassword = passwordField.value;

        if (newPassword !== "") {
            const hasNumber = /[0-9]/.test(newPassword);
            const hasLetter = /[A-Za-z]/.test(newPassword);
            
            if (newPassword.length < 8 || !hasNumber || !hasLetter) {
                Swal.fire({
                    icon: 'error',
                    title: 'Password Tidak Valid',
                    text: 'Password minimal 8 karakter dan harus kombinasi angka-huruf.',
                    confirmButtonColor: '#d33'
                });
                return; 
            }
        }

        Swal.fire({
            title: 'Konfirmasi Perubahan',
            text: "Apakah Anda yakin ingin memperbarui data profil?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6', 
            confirmButtonText: 'Ya, Update!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                const formData = new FormData(form);

                fetch('function.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: 'Profil Anda telah diperbarui.',
                            confirmButtonColor: '#3085d6'
                        }).then(() => {
                            location.reload(); 
                        });
                    } else {
                        Swal.fire('Gagal', 'Terjadi kesalahan pada sistem.', 'error');
                    }
                })
                .catch(error => {
                    Swal.fire('Gagal', 'Terjadi masalah pada koneksi server.', 'error');
                });
            }
        });
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