<?php
    require_once 'auth.php';               
    require_once 'viewHelper.php';           
    require_once 'daftar_pengguna_controller.php';           

    Auth::cekLoginAdmin(); 

    $objPengguna = new Pengguna ();

    if (isset($_GET['search']) && !empty($_GET['search'])) {
        $keyword = $_GET['search'];
        $dataPengguna = $objPengguna->cari($keyword); 
    } else {
        $dataPengguna = $objPengguna->tampilSemua(); 
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pengguna - FloraMeans Admin</title>
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
            <div class="container-fluid p-4 p-md-5">
            <?php  
                ViewHelper::renderHeader("Daftar Pengguna Website FloraMeans", ""); 
                ViewHelper::renderSearchBar("Cari username pengguna..."); 
            ?>

                <div class="card p-4 shadow-sm border-0 mt-3">
                    <div class="card-body p-0"> 
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light text-secondary" style="background-color: #f8f9fa;">
                                    <tr>
                                        <th class="ps-4 py-3" style="width: 100px;">No</th>
                                        <th class="py-3">Username Pengguna</th>
                                        <th class="py-3">Tanggal Registrasi</th>
                                        <th class="pe-4 py-3 text-end" style="width: 150px;">Aksi</th>
                                    </tr>
                                </thead>
                                    <tbody>
                                        <?php 
                                        $no = 1;
                                        if (mysqli_num_rows($dataPengguna) > 0) {
                                            while($row = mysqli_fetch_assoc($dataPengguna)) { 
                                            // Cek jika data dari database kosong atau bernilai 0000-00-00
                                            if (empty($row['tanggal_registrasi']) || $row['tanggal_registrasi'] == '0000-00-00') {
                                                $tglRegistrasi = '<em class="text-muted small">Belum Tercatat</em>';
                                            } else {
                                                // Proses konversi tanggal jika datanya valid
                                                $tanggal = strtotime($row['tanggal_registrasi']);
                                                $bulanIndo = [
                                                    1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 
                                                    'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
                                                ];
                                                $tglRegistrasi = date('d', $tanggal) . ' ' . $bulanIndo[(int)date('m', $tanggal)] . ' ' . date('Y', $tanggal);
                                                $tglRegistrasi = htmlspecialchars($tglRegistrasi);
                                            }
                                        ?>
                                        <tr>
                                            <td class="ps-4 fw-medium text-dark"><?= $no++; ?></td>
                                            <td><span class="fw-semibold text-dark "><?= htmlspecialchars($row['username']); ?></span></td>
                                            <td class="fw-semibold text-dark" ><?= $tglRegistrasi; ?></td>
                                            <td class="pe-4 text-end">
                                                <button class="btn btn-light btn-sm text-danger border-0" 
                                                        onclick="konfirmasiHapus(<?= $row['id_user']; ?>)">
                                                    <i class="bi bi-trash3-fill"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <?php 
                                            } 
                                            // Menyimpan jumlah total data untuk info di bawah tabel
                                            $totalData = $no - 1; 
                                        } else {
                                            $totalData = 0;
                                            echo '<tr><td colspan="4" class="text-center py-5 text-muted">Tidak ada data akun pengguna ditemukan.</td></tr>';
                                        }
                                        ?>
                                    </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <?php ViewHelper::renderTableFooter($totalData, "pengguna"); ?>
        </main>
    </div>

<script>
    const urlParams = new URLSearchParams(window.location.search);
    const pesan = urlParams.get('pesan');

    if (pesan === 'sukses_hapus') {
        Swal.fire({
            title: 'Berhasil!',
            text: 'Pengguna telah berhasil dihapus.',
            icon: 'success',
            confirmButtonColor: '#064e3b' 
        }).then(() => {
            // Bersihkan parameter URL agar alert tidak muncul lagi saat refresh
            window.history.replaceState({}, document.title, window.location.pathname);
        });
    }

    function konfirmasiHapus(userId) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Akun pengguna ini akan dihapus permanen dari FloraMeans!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal',
            customClass: { popup: 'rounded-4' } 
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = `daftar_pengguna_controller.php?action=hapus&id_user=${userId}`;
            }
        });
    }
</script>
</body>
</html>