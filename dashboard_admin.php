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
    padding: 12px 20px;
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

#content {
    width: calc(100% - 250px);
    margin-left: 250px;
    transition: all 0.3s;
    padding: 30px;
}

/* Responsive Mobile */
@media (max-width: 768px) {
    #sidebar {
        margin-left: -250px;
    }
    #sidebar.active {
        margin-left: 0;
    }
    #content {
        width: 100%;
        margin-left: 0;
    }
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

            <ul class="list-unstyled components">
                <li><a href="dashboard_admin.php" class="active"><i class="bi bi-grid-1x2-fill"></i> Dashboard</a></li>
                <li><a href="kelola_kategori.php"><i class="bi bi-tags-fill"></i> Kategori Air</a></li>
                <li><a href="data_referensi_tanaman.php"><i class="bi bi-tree-fill"></i> Daftar Tanaman</a></li>
                <li><a href="standarisasi_lingkungan.php"><i class="bi bi-sliders"></i> Parameter</a></li>
                <li><a href="daftar_pengguna.php"><i class="bi bi-people-fill"></i> Daftar Pengguna</a></li>
                <li><a href="riwayat_clustering.php"><i class="bi bi-clock-history"></i> Riwayat Clustering</a></li>
                <li><a href="logout.php"><i class="bi bi-box-arrow-right"></i> Logout</a></li>
            </ul>
        </nav>

        
    <script>
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