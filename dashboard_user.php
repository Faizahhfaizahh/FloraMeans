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
                    <li class="nav-item"><a class="nav-link active" href="dashbaord_user.php">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="cek_kebutuhan_air.php">Cek Kebutuhan Air</a></li>
                    <li class="nav-item"><a class="nav-link" href="riwayat_clustering.php">Riwayat Clustering</a></li>
                    <li class="nav-item"><a class="nav-link" href="profil_user.php">Profil</a></li>
                    <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-md">
        
    </div>
    
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
</body>
</html>