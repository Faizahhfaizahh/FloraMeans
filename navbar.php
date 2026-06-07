<?php
// Mendapatkan nama file yang sedang dibuka
$current_page = basename($_SERVER['PHP_SELF']);

$nama_user = isset($_SESSION['user_username']) ? $_SESSION['user_username'] : 'User';
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
                    <a href="profil_user.php" class="nav-link <?= ($current_page == 'profil_user.php') ? 'active' : ''; ?>">Profil</a>
                </li>
                <li class="nav-item">
                    <a href="logout.php" class="nav-link">Logout</a>
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