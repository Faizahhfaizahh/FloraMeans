<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login to FloraMeans Website as Admin</title>

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
<body class="bg-admin">
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card-login card shadow-lg overflow-hidden">
            <div class="row align-items-stretch g-0">
                <div class="col-md-6">
                    <img src="images/img_bg2.png" alt="background" class="img-login img-fluid w-100 h-100">
                </div>
                <!-- Login -->
                <div class="col-md-6 d-flex align-items-center">
                    <div class="card-body w-100 p-3 p-md-5">
                        <h4 class="fw-bold text-center">Login Administrator</h4>
                        <p class="text-muted text-center small ">Gunakan akun admin Anda untuk mengelola data dan memantau sistem FloraMeans</p>
                        <form action="" method="POST" id="formLoginAdmin">
                            <div class="mb-3">
                                <label for="inputUsernameAdmin" class="form-label">Username</label>
                                <input type="text" class="form-control" id="inputUsernameAdmin">
                            </div>
                            <div class="mb-3">
                                <label for="inputPasswordAdmin" class="form-label">Password</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="inputPasswordAdmin">
                                    <span class="input-group-text bg-white" id="togglePassword" style="cursor: pointer;">
                                        <i class="bi bi-eye" id="toggleIcon"></i>
                                    </span>
                                </div>
                            </div>
                            <button type="submit" class="btn w-100 btn-login-admin ">Login</button>
                        </form>
                    </div>
                 </div>
            </div>
        </div>
    </div>

    <script>
        const togglePassword = document.querySelector('#togglePassword');
        const toggleIcon = document.querySelector('#toggleIcon');
        const passwordField = document.querySelector('#inputPasswordAdmin');

        togglePassword.addEventListener('click', function () {
            const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordField.setAttribute('type', type);

            toggleIcon.classList.toggle('bi-eye');
            toggleIcon.classList.toggle('bi-eye-slash');
        });

        document.getElementById('formLoginAdmin').addEventListener('submit', function(e) {
        e.preventDefault(); // Menahan refresh halaman

        let username = document.getElementById('inputUsernameAdmin').value;
        let password = document.getElementById('inputPasswordAdmin').value;

        if (username === "" || password === "") { 
            Swal.fire({
                icon: "warning",
                title: "Peringatan!",
                text: "Username dan Password tidak boleh kosong."
            });
            return; // Berhenti di sini, jangan kirim ke PHP
        } 
        // Kirim data ke PHP menggunakan Fetch API
        let formData = new FormData();
        formData.append('action', 'loginAdmin');
        formData.append('username', username);
        formData.append('password', password);

        fetch('function.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json()) // Mengambil balasan JSON dari PHP
        .then(data => {
            if (data.status === 'success') {
                Swal.fire({
                    icon: "success",
                    title: "Berhasil!",
                    text: "Selamat datang kembali, Admin FloraMeans.",
                    showConfirmButton: false,
                    timer: 1500
                }).then(() => {
                    window.location.href = "dashboard_admin.php"; // Pindah ke halaman utama
                });
            } else if (data.status === 'wrong_password') {
                Swal.fire({
                    icon: "error",
                    title: "Login Gagal...",
                    text: "Password Admin yang kamu masukkan salah."
                });
            } else if (data.status === 'not_found') {
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "Akun Administrator tidak ditemukan."
                });
            }
        })
        .catch(error => {
            Swal.fire({
                icon: "error",
                title: "Error",
                text: "Gagal terhubung ke server."
            });
        });
    });
    </script>
</body>
</html>