<?php
// Mendapatkan nama file yang sedang dibuka
$current_page = basename($_SERVER['PHP_SELF']);

$nama_user = isset($_SESSION['user_username']) ? $_SESSION['user_username'] : 'User';
$initial = strtoupper(substr($nama_user, 0, 1)); // Mendapatkan inisial huruf pertama dari nama user
?>

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

    .navbar-flora .nav-link.dropdown-toggle-custom {
        padding-top: 7px !important;
        padding-bottom: 7px !important;
    }

    .profile-circle {
        width: 35px;
        height: 35px;
        border-radius: 50%;
        background-color: #34d399; 
        color: #064e3b; 
        font-weight: bold;
        font-size: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 2px solid rgba(255, 255, 255, 0.3);
        transition: 0.3s;
    }

    .navbar-flora .profile-circle:hover {
        background-color: #2ecc71;
        border-color: #fff;
    }

    .dropdown-menu-custom {
        background-color: #065f46;
        border: none;
        box-shadow: 0 4px 12px rgba(0,0,0,0.3);
    }

    .dropdown-menu-custom .dropdown-item {
        color: #f0fdf4;
    }

    .dropdown-menu-custom .dropdown-item:hover {
        background-color: #064e3b;
        color: #2ecc71;
    }
    
    .dropdown-menu-custom .dropdown-divider {
        border-color: rgba(255,255,255,0.2);
    }
</style>

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
                <li class="nav-item">
                    <a href="dashboard_user.php" class="nav-link <?= ($current_page == 'dashboard_user.php') ? 'active' : ''; ?>">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a href="cek_kebutuhan_air.php" class="nav-link <?= ($current_page == 'cek_kebutuhan_air.php') ? 'active' : ''; ?>">Cek Kebutuhan</a>
                </li>
                <li class="nav-item">
                    <a href="riwayat_clustering_user.php" class="nav-link <?= ($current_page == 'riwayat_clustering_user.php') ? 'active' : ''; ?>">Riwayat Clustering</a>
                </li>
                <li class="nav-item">
                    <a href="panduan.php" class="nav-link <?= ($current_page == 'panduan.php') ? 'active' : ''; ?>">Panduan</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle-custom d-flex align-items-center gap-2" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="profile-circle">
                            <?= $initial; ?>
                        </div>
                        <i class="bi bi-chevron-down" style="font-size: 0.7rem; color: rgba(255,255,255,0.7);"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-custom">
                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="profil_user.php">
                                <i class="bi bi-person me-2"></i> Profil Saya
                            </a>
                        </li>
                        <li>
                            <a href="logout.php" class="dropdown-item text-danger logout-trigger" style="cursor: pointer;">
                                <i class="bi bi-box-arrow-right me-2"></i> Logout
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

<script>
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