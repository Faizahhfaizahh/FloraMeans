<?php
// Mendapatkan nama file yang sedang dibuka
$current_page = basename($_SERVER['PHP_SELF']);

$nama_admin = isset($_SESSION['admin_username']) ? $_SESSION['admin_username'] : 'Admin';
?>

<style>
    body {
        background-color: #f5f5f5;
        overflow-x: hidden;
    }

    .main-navbar {
        height: 60px;
        z-index: 1020;
        left: 250px; 
        width: calc(100% - 250px);
        transition: all 0.3s ease-in-out;
    }

    .brand-text-toggle {
        font-size: 1.15rem;
        opacity: 0;
        visibility: hidden;
        transform: translateX(-10px);
        transition: all 0.3s ease-in-out;
    }

    #sidebar {
        min-width: 250px;
        max-width: 250px;
        background-color: #064e3b; 
        color: white;
        min-height: 100vh;
        position: fixed;
        top: 0;
        left: 0;
        z-index: 1030;
        transition: all 0.3s ease-in-out;
    }

    #sidebar .sidebar-header {
        padding: 20px;
        background: #043d2e;
        height: 60px; 
    }

    #sidebar ul {
        padding: 15px 0;
        list-style: none;
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
        padding-left: 250px;
        padding-top: 45px;
        transition: all 0.3s ease-in-out;
        position: relative;
    }

    .container-box { 
        max-width: 1000px; 
        margin: 0 auto; 
    }

    .card { 
        border: none; 
        border-radius: 12px; 
        box-shadow: 0 4px 12px rgba(0,0,0,0.05); 
    }

    
    /* Ketika Sidebar disembunyikan Class .sidebar-hidden aktif*/
    body.sidebar-hidden #sidebar {
        left: -250px;
    }
    body.sidebar-hidden #main-content {
        padding-left: 0;
    }
    body.sidebar-hidden .main-navbar {
        left: 0;
        width: 100%;
    }
    /* Muncul FloraMeans ketika sidebar disembunyikan*/
    body.sidebar-hidden .brand-text-toggle {
        opacity: 1;
        visibility: visible;
        transform: translateX(0);
    }

    @media (max-width: 768px) {
        #sidebar { 
            left: -250px; 
            max-width: 260px;
            min-width: 260px;
        }
        #main-content { 
            padding-left: 0; 
        }
        .main-navbar {
            left: 0;
            width: 100%;
        }

        body.sidebar-hidden #sidebar {
            left: 0;
        }
        .brand-text-toggle {
            opacity: 1;
            visibility: visible;
            transform: translateX(0);
        }
        body.sidebar-hidden #main-content::after {
            content: "";
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.4); 
            z-index: 1025; 
            transition: all 0.3s ease-in-out;
        }
    }
</style>

<nav class="navbar navbar-expand-lg navbar-light bg-white px-4 shadow-sm fixed-top main-navbar">
    <div class="container-fluid p-0">
        <div class="d-flex align-items-center">
            <button class="btn btn-light border-0 shadow-sm me-3" id="menu-toggle">
                <i class="bi bi-list fs-5"></i>
            </button>
            
            <span class="brand-text-toggle text-success fw-bold m-0">FloraMeans</span>
        </div>

        <div class="ms-auto d-flex align-items-center">
            <div class="dropdown">
                <a class="d-flex align-items-center text-decoration-none dropdown-toggle text-dark" href="#" role="button" id="dropdownProfile" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="images/avatar.jpg" alt="Admin" width="32" height="32" class="rounded-circle me-md-2 border">
                    <div class="d-none d-md-block text-start me-1">
                        <p class="m-0 small fw-bold lh-1"><?= htmlspecialchars($nama_admin); ?></p>
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2" aria-labelledby="dropdownProfile" style="border-radius: 10px;">
                    <li><h6 class="dropdown-header text-muted">Manajemen Akun</h6></li>
                    <li><a class="dropdown-item py-2" href="profil_admin.php"><i class="bi bi-person me-2 text-secondary"></i> Profil Saya</a></li>
                    <li><a class="dropdown-item py-2 text-danger" href="#" id="btnLogoutNavbar"><i class="bi bi-box-arrow-right me-2"></i> Logout</a></li>
                </ul>
            </div>
        </div>
    </div>
</nav>

<nav id="sidebar" class="shadow">
    <div class="sidebar-header d-flex align-items-center">
        <img src="images/logo/FloraMeans_Logo4.png" alt="Logo" width="30" height="30" class="me-2">
        <h5 class="m-0 fw-bold">FloraMeans</h5>
    </div>

    <ul class="list-unstyled mb-0">
        <li>
            <a href="dashboard_admin.php" class="<?= ($current_page == 'dashboard_admin.php') ? 'active' : ''; ?>">
                <i class="bi bi-grid-1x2-fill"></i> Dashboard
            </a>
        </li>
        <li>
            <a href="kelola_kategori.php" class="<?= ($current_page == 'kelola_kategori.php') ? 'active' : ''; ?>">
                <i class="bi bi-tags-fill"></i> Kategori
            </a>
        </li>
        <li>
            <a href="daftar_tanaman.php" class="<?= ($current_page == 'daftar_tanaman.php') ? 'active' : ''; ?>">
                <i class="bi bi-tree-fill"></i> Daftar Tanaman
            </a>
        </li>
        <li>
            <a href="parameter.php" class="<?= ($current_page == 'parameter.php') ? 'active' : ''; ?>">
                <i class="bi bi-sliders"></i> Parameter
            </a>
        </li>
        <li>
            <a href="daftar_pengguna.php" class="<?= ($current_page == 'daftar_pengguna.php') ? 'active' : ''; ?>">
                <i class="bi bi-people-fill"></i> Daftar Pengguna
            </a>
        </li>
        <li>
            <a href="riwayat_clustering.php" class="<?= ($current_page == 'riwayat_clustering.php') ? 'active' : ''; ?>">
                <i class="bi bi-clock-history"></i> Riwayat Clustering
            </a>
        </li>
        <li>
            <a href="#" id="btnLogoutSide">
                <i class="bi bi-box-arrow-right"></i> Logout
            </a>
        </li>
    </ul>
</nav>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const menuToggle = document.getElementById('menu-toggle');
        const body = document.body;
        const mainContent = document.getElementById('main-content');
        
        if (menuToggle) {
            menuToggle.addEventListener('click', function(e) {
                e.preventDefault();

                body.classList.toggle('sidebar-hidden');
            });
        }
        //Untuk di mobile ketika sidebar muncul dan mengetuk area kosong di kanan, otomatis sidebar tertutup
        if (mainContent) {
            mainContent.addEventListener('click', function() {
                if (window.innerWidth <= 768 && body.classList.contains('sidebar-hidden')) {
                    body.classList.remove('sidebar-hidden'); 
                }
            });
        }

        const btnLogoutSide = document.getElementById('btnLogoutSide');
        const btnLogoutNavbar = document.getElementById('btnLogoutNavbar');

        function prosesLogout(e) {
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
        }

        if (btnLogoutSide) btnLogoutSide.addEventListener('click', prosesLogout);
        if (btnLogoutNavbar) btnLogoutNavbar.addEventListener('click', prosesLogout);
    });
</script>