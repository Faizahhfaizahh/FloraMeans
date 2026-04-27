<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Creat Your Account to FloraMeans Website</title>

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
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card-login card shadow-lg overflow-hidden">
            <div class="row align-items-stretch g-0">
                <!-- Regis -->
                <div class="col-md-6 d-flex align-items-center order-2 order-md-1"> <!-- Order-2 untuk muncul ke 2 untuk mobile -->
                    <div class="card-body w-100 p-3 p-md-5">
                        <h4 class="fw-bold text-center">Buat Akun Baru</h4>
                        <p class="text-muted text-center small ">Daftar untuk mendapatkan analisis kebutuhan air yang tepat bagi setiap tanamanmu.</p>
                        <form action="" method="POST" id="formRegistrasi">
                            <div class="mb-3">
                                <label for="inputUsernameUser" class="form-label">Username</label>
                                <input type="text" class="form-control" id="inputUsernameUser">
                            </div>
                            <div class="mb-3">
                                <label for="inputPasswordUser" class="form-label">Password</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="inputPasswordUser">
                                    <span class="input-group-text bg-white toggle-password" data-target="#inputPasswordUser" style="cursor: pointer;">
                                        <i class="bi bi-eye"></i>
                                    </span>
                                </div>
                                <div class="form-text" style="font-size: 0.75rem;">Minimal 8 karakter (huruf & angka).</div>
                            </div>
                            <div class="mb-3">
                                <label for="konfirmasiPasswordUser" class="form-label">Konfirmasi password</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="konfirmasiPasswordUser">
                                    <span class="input-group-text bg-white toggle-password" data-target="#konfirmasiPasswordUser" style="cursor: pointer;">
                                        <i class="bi bi-eye"></i>
                                    </span>
                                </div>
                            </div>
                            <p class="mt-3 text-end">Sudah punya akun? <a href="login.php" class="text-decoration-none ">Masuk</a></p>
                            <button type="submit" class="btn w-100 btn-login ">Daftar</button>
                        </form>
                    </div>
                 </div>
                <div class="col-md-6 order-1 order-md-2"> <!-- Order-1 untuk muncul ke 1 (atas) untuk mobile -->
                    <img src="images/img_bg2.png" alt="background" class="img-login img-fluid w-100 h-100">
                </div>
            </div>
        </div>
    </div>

    <script>
        document.querySelectorAll('.toggle-password').forEach(btn => {
            btn.addEventListener('click', function() {
                const targetId = this.getAttribute('data-target');
                const input = document.querySelector(targetId);
                
                const icon = this.querySelector('i');

                const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
                input.setAttribute('type', type);

                icon.classList.toggle('bi-eye');
                icon.classList.toggle('bi-eye-slash');
            });
        });

        document.getElementById('formRegistrasi').addEventListener('submit', function(e) {
        e.preventDefault(); // Menahan refresh halaman

        let username = document.getElementById('inputUsernameUser').value;
        let password = document.getElementById('inputPasswordUser').value;
        let konfirmasiPassword = document.getElementById('konfirmasiPasswordUser').value;
        // RegEx: Minimal 8 karakter, minimal 1 huruf dan 1 angka
        let passwordRegex = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/;

        if (username === "" || password === "" || konfirmasiPassword === "") { 
            Swal.fire({
                icon: "warning",
                title: "Data Belum Lengkap",
                text: "Mohon isi semua kolom pendaftaran."
            });
            return; // Berhenti di sini, jangan kirim ke PHP
        } 

        if (!passwordRegex.test(password)) {
            Swal.fire({
                icon: "warning",
                title: "Password Lemah",
                text: "Password harus minimal 8 karakter dan mengandung kombinasi huruf serta angka."
            });
            return;
        }
        
        if (password !== konfirmasiPassword) {
                Swal.fire({
                icon: "warning",
                title: "Password tidak cocok!",
                text: "Pastikan konfirmasi password sama dengan password yang kamu masukkan."
            });
            return;
        }
        // Kirim data ke PHP menggunakan Fetch API
        let formData = new FormData();
        formData.append('action', 'register');
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
                    title: "Akun Dibuat!",
                    text: "Silahkan login menggunakan akun baru mu.",
                    showConfirmButton: true,
                }).then(() => {
                    window.location.href = "login.php"; // Pindah ke halaman utama
                });
            } else if (data.status === 'username_terpakai') {
                Swal.fire({
                    icon: "error",
                    title: "Pendaftaran Gagal",
                    text: "Username tersebut sudah digunakan. Silakan pilih username lain."
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