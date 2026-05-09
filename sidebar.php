<?php
// Mendapatkan nama file yang sedang dibuka
$current_page = basename($_SERVER['PHP_SELF']);
?>

<nav id="sidebar" class="shadow">
    <div class="sidebar-header d-flex align-items-center">
        <img src="images/logo/FloraMeans_Logo4.png" alt="Logo" width="30" height="30" class="me-2">
        <h5 class="m-0 fw-bold">FloraMeans</h5>
    </div>

    <ul class="list-unstyled">
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
    // Gunakan pengecekan event listener agar tidak bentrok
    document.addEventListener('DOMContentLoaded', function() {
        const btnLogout = document.getElementById('btnLogoutSide');
        if (btnLogout) {
            btnLogout.addEventListener('click', function(e) {
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
        }
    });
</script>