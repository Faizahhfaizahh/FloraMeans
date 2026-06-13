<?php
    require_once 'auth.php';               
    require_once 'kategori_controller.php';
    require_once 'viewHelper.php';   

    Auth::cekLoginAdmin(); 

    // Membuat objek 
    $katObj = new Kategori();
    $dataKategori = $katObj->tampilSemua(); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kategori Tanaman - FloraMeans Admin</title>

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
                // Header 
                ViewHelper::renderHeader("Kelola Kategori", "modalTambah", "Tambah Kategori"); 
            ?>
                <div class="card p-4 border-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th class="py-3 px-3">No</th>
                                    <th class="py-3">Nama Kategori</th>
                                    <th class=" py-3 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no =1;
                                if (mysqli_num_rows($dataKategori) > 0 ){
                                    while ($row = mysqli_fetch_assoc($dataKategori)):
                                ?>
                                <tr>
                                    <td class="px-3"><?= $no++;?></td>
                                    <td class="fw-medium text-dark"><?= $row['nama_kategori'];?></td>
                                    <td class="text-center">
                                        <button class="btn btn-sm btn-light text-warning me-1 btn-edit" 
                                            data-id="<?= $row['id_kategori'];?>" 
                                            data-nama="<?= $row['nama_kategori'];?>"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modalEdit">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                        <button class="btn btn-sm btn-light text-danger btn-delete" data-id="<?= $row['id_kategori'];?>"><i class="bi bi-trash3-fill"></i></button>
                                    </td>
                                </tr>
                                <?php 
                                    endwhile; 
                                    } else {
                                        echo '<tr><td colspan="5" class="text-center py-5 text-muted italic">Belum ada data kategori yang dimasukkan.</td></tr>';
                                    }?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Modal Tambah Kategori -->
    <div class="modal fade" id="modalTambah" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header border-0 bg-light">
                    <h5 class="modal-title fw-bold">Tambah Kategori Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="kategori_controller.php" method="POST">
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label class="form-label" for="tambah_nama_kategori">Nama Kategori</label>
                            <input type="text" class="form-control bg-light py-2" id="tambah_nama_kategori" name="nama_kategori" placeholder="Contoh: Xerofit" required>
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" name="btn_simpan_kategori" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit Kategori -->
    <div class="modal fade" id="modalEdit" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header border-0 bg-light">
                    <h5 class="modal-title fw-bold">Edit Kategori</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="kategori_controller.php" method="POST">
                    <div class="modal-body p-4">
                        <input type="hidden" name="id_kategori" id="edit_id">
                        <div class="mb-3">
                            <label class="form-label" for="edit_nama_kategori">Nama Kategori</label>
                            <input type="text" class="form-control  bg-light py-2" id="edit_nama_kategori" name="nama_kategori" id="edit_nama" required>
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" name="btn_edit_kategori" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
        
    <script>

        const urlParams = new URLSearchParams(window.location.search);
        const pesan = urlParams.get('pesan');

        // Notifikasi tambah kategori berhasil
        if (pesan === 'sukses_tambah') {
            Swal.fire({
                title: 'Berhasil!',
                text: 'Kategori baru telah ditambahkan ke sistem FloraMeans.',
                icon: 'success',
            }).then(() => {
                // Bersihkan parameter URL agar alert tidak muncul lagi saat refresh
                window.history.replaceState({}, document.title, window.location.pathname);
            });
        }

        if (pesan === 'duplikat') {
        Swal.fire({
            title: 'Gagal!',
            text: 'Nama kategori tersebut sudah terdaftar di database.',
            icon: 'error',
            confirmButtonColor: '#d33'
        });
    }

    if (pesan === 'sukses_hapus') {
        Swal.fire({
            title: 'Berhasil!',
            text: 'Kategori telah berhasil dihapus.',
            icon: 'success',
        }).then(() => {
            // Bersihkan parameter URL agar alert tidak muncul lagi saat refresh
            window.history.replaceState({}, document.title, window.location.pathname);
        });
    }

        // Untuk hapus kategori
        document.querySelectorAll('.btn-delete').forEach(btn => {
            btn.addEventListener('click', function() {
                const id_kategori = this.getAttribute('data-id'); // Mengambil id dari tombol
                Swal.fire({
                    title: 'Hapus Kategori?',
                    text: "Data yang dihapus tidak bisa dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = `kategori_controller.php?action=hapus&id_kategori=${id_kategori}`;
                    }
                });
            });
        });

        // Mengisi data ke modal edit saat tombol diklik
        document.querySelectorAll('.btn-edit').forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const nama = this.getAttribute('data-nama');

                document.getElementById('edit_id').value = id;
                document.getElementById('edit_nama').value = nama;
            });
        });

        if (pesan === 'sukses_edit') {
            Swal.fire('Berhasil!', 'Kategori telah diperbarui.', 'success');
            window.history.replaceState({}, document.title, window.location.pathname);
        }

    </script>
</body>
</html>