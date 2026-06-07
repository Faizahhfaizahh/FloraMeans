<?php
    require_once 'auth.php';               
    require_once 'viewHelper.php';   
    require_once 'profil_controller.php';   

    Auth::cekLoginAdmin(); 

    // Membuat objek 
    $profilObj = new Profil();
    $current_username = $profilObj->getProfileUsername();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Profile</title>

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

</head>
<body>
<div class="d-flex">
    <?php include 'sidebar.php'; ?>

    <main id="main-content">
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-12 col-md-8 col-lg-5">
                    <div class="card border-0 shadow-sm rounded-4">
                        <div class="card-body p-4 p-md-5">
                            <!-- Avatar Section -->
                            <div class="text-center mb-4">
                                <img src="images/avatar.jpg" alt="Admin" width="80" height="80" class="rounded-circle me-md-2 border">
                                <h5 class="fw-bold m-2">Profil Admin</h5>
                                <p class="text-muted small mt-2">Kelola informasi akun admin Anda</p>
                            </div>

                            <form action="profil_controller.php" method="POST" id="formUpdateProfile">
                                <input type="hidden" name="action" value="updateProfile">
                                <input type="hidden" name="role_form" value="admin">
                                <div class="mb-3">
                                    <label class="form-label small fw-bold">Username</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-0"><i class="bi bi-person"></i></span>
                                        <input type="text" class="form-control bg-light border-0" name="username" value="<?= htmlspecialchars($current_username); ?>" required>
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
    </main>
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

                fetch('profil_controller.php', {
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
</script>
</body>
</html>