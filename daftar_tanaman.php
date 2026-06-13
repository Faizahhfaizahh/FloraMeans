<?php
    require_once 'auth.php';               
    require_once 'daftar_tanaman_controller.php'; 
    require_once 'kategori_controller.php'; 
    require_once 'viewHelper.php';

    Auth::cekLoginAdmin(); 

    $tanamanObj = new Tanaman();
    $keyword    = isset($_GET['search']) && !empty($_GET['search']) ? $_GET['search'] : '';

    // Menghitung total data untuk pagination
    $totalData  = $tanamanObj->hitungTotal($keyword);
    // Ambil data pagination
    $pagination = ViewHelper::getPaginationData($totalData, 10);
    // Ambil data sesuai halaman
    $dataTanaman = $tanamanObj->cari($keyword, $pagination['perPage'], $pagination['offset']);

    $katObj = new Kategori();
    $dataKategori = $katObj->tampilSemua();
    
    $listKategori = []; 
    while($rowKat = mysqli_fetch_assoc($dataKategori)) {
        $listKategori[] = $rowKat;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Tanaman - FloraMeans Admin</title>

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
    <!-- CSS page -->
    <?php ViewHelper::renderStyles(); ?>
</head>
<body>
    <div class="d-flex">
         <?php include 'sidebar.php'; ?> 

        <main id="main-content">
            <div class="container-fluid p-4 p-md-5">
                <?php 
                    ViewHelper::renderHeader("Daftar Referensi Tanaman", "modalTambah", "Tambah Tanaman"); 
                    ViewHelper::renderSearchBar("Cari nama atau kategori tanaman..."); 
                ?>

                <div class="card p-4 border-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th class="py-3 px-3">No</th>
                                    <th class="py-3">Nama Tanaman</th>
                                    <th class="py-3">Sinonim (Nama Lain Tanaman)</th>
                                    <th class="py-3">Kategori</th>
                                    <th class=" py-3 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = $pagination['offset'] + 1;
                                if (mysqli_num_rows($dataTanaman) > 0 ){
                                    while ($row = mysqli_fetch_assoc($dataTanaman)){
                                ?>
                                <tr>
                                    <td class="px-3"><?= $no++;?></td>
                                    <td class="fw-medium text-dark"><?= $row['nama_tanaman'];?></td>
                                    <td class="fw-medium text-dark">
                                        <?= !empty($row['sinonim']) ? $row['sinonim'] : '<span class="text-muted small"><em>-</em></span>'; ?>
                                    </td>
                                    <td class="fw-medium text-dark"><?= $row['nama_kategori'];?></td>
                                    <td class="text-center">
                                        <button class="btn btn-sm btn-light text-warning me-1 btn-edit" 
                                            data-id="<?= $row['id_tanaman'];?>" 
                                            data-nama="<?= $row['nama_tanaman'];?>"
                                            data-sinonim="<?= $row['sinonim'];?>"
                                            data-edit-kategori="<?= $row['id_kategori'];?>"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modalEdit">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                        <button class="btn btn-sm btn-light text-danger btn-delete" data-id="<?= $row['id_tanaman'];?>"><i class="bi bi-trash3-fill"></i></button>
                                    </td>
                                </tr>
                                <?php
                                    }  
                                } else {
                                    $totalData = 0;
                                    echo '<tr><td colspan="5" class="text-center py-5 text-muted italic">Belum ada data tanaman yang terdaftar.</td></tr>';
                                }
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <?php ViewHelper::renderTableFooter($totalData, "tanaman", $pagination); ?>
                </div>
            </div>
        </main>
    </div>

    <!-- Modal Tambah Tanaman -->
    <div class="modal fade" id="modalTambah" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header border-0 bg-light">
                    <h5 class="modal-title fw-bold">Tambah Tanaman Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="daftar_tanaman_controller.php" method="POST">
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label class="form-label" for="tambah_nama_tanaman">Nama Tanaman</label>
                            <input type="text" class="form-control bg-light py-2" id="tambah_nama_tanaman" name="nama_tanaman" placeholder="Contoh: Lidah Buaya" required>
                        </div>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between">
                            <label class="form-label" for="tambah_sinonim">Sinonim (Nama Lain Tanaman)</label>
                            <span class="text-muted small">Opsional</span> </div>
                        
                        <input type="text" 
                            class="form-control bg-light py-2" 
                            name="sinonim" 
                            id="tambah_sinonim" 
                            placeholder="Contoh: Aloe Vera, Jadam, Lidah Naga"> <div class="form-text mt-1 text-secondary" style="font-size: 0.8rem;">
                            <i class="bi bi-info-circle me-1"></i> 
                            Gunakan koma ( , ) sebagai pemisah nama.
                        </div> 
                    </div>
                        <div class="mb-3">
                            <label class="form-label" for="pilih_nama_kategori">Kategori</label>
                            <select name="id_kategori" id="pilih_nama_kategori" class="form-select bg-light py-2" required>
                                <option value="" selected disabled>-- Pilih Kategori --</option>
                                <?php foreach($listKategori as $k): ?>
                                    <option value="<?= $k['id_kategori']; ?>"><?= $k['nama_kategori']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" name="btn_simpan_tanaman" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit Tanaman -->
    <div class="modal fade" id="modalEdit" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header border-0 bg-light">
                    <h5 class="modal-title fw-bold">Edit Tanaman</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="daftar_tanaman_controller.php" method="POST">
                    <div class="modal-body p-4">
                        <input type="hidden" name="id_tanaman" id="edit_id">
                        <!-- Waktu edit akan ke halaman tanaman yang di edit -->
                        <input type="hidden" name="current_page" id="edit_current_page" value="<?= $pagination['currentPage']; ?>"> 
                        <div class="mb-3">
                            <label class="form-label" for="edit_nama_tanaman">Nama Tanaman</label>
                            <input type="text" class="form-control  bg-light py-2" id="edit_nama_tanaman" name="nama_tanaman" required>
                        </div>
                        <div class="mb-3">
                            <div class="d-flex justify-content-between">
                                <label class="form-label" for="edit_sinonim">Sinonim (Nama Lain Tanaman)</label>
                                <span class="text-muted small">Opsional</span>
                            </div>

                            <input type="text" 
                                class="form-control bg-light py-2" 
                                name="sinonim" 
                                id="edit_sinonim">
                            
                            <div class="form-text mt-1 text-secondary" style="font-size: 0.8rem;">
                                <i class="bi bi-info-circle me-1"></i> 
                                Gunakan koma ( , ) sebagai pemisah nama.
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="edit_kategori">Kategori</label>
                            <select name="id_kategori" id="edit_kategori" class="form-select bg-light py-2" required>
                                <option value="">-- Pilih Kategori --</option>
                                <?php foreach($listKategori as $k): ?>
                                    <option value="<?= $k['id_kategori']; ?>"><?= $k['nama_kategori']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" name="btn_edit_tanaman" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
        
    <script>
        const urlParams = new URLSearchParams(window.location.search);
        const pesan = urlParams.get('pesan');

        // Notifikasi tambah tanaman berhasil
        if (pesan === 'sukses_tambah') {
            Swal.fire({
                title: 'Berhasil!',
                text: 'Tanaman berhasil ditambahkan',
                icon: 'success',
            }).then(() => {
                // Bersihkan parameter URL agar alert tidak muncul lagi saat refresh
                window.history.replaceState({}, document.title, window.location.pathname);
            });
        }

        if (pesan === 'duplikat') {
        Swal.fire({
            title: 'Gagal!',
            text: 'Nama tanaman tersebut sudah terdaftar di database.',
            icon: 'error',
            confirmButtonColor: '#d33'
        });
    }

    if (pesan === 'sukses_hapus') {
        Swal.fire({
            title: 'Berhasil!',
            text: 'Tanaman telah berhasil dihapus.',
            icon: 'success',
        }).then(() => {
            // Bersihkan parameter URL agar alert tidak muncul lagi saat refresh
            window.history.replaceState({}, document.title, window.location.pathname);
        });
    }

        // Untuk hapus tanaman
        document.querySelectorAll('.btn-delete').forEach(btn => {
            btn.addEventListener('click', function() {
                const id_tanaman = this.getAttribute('data-id'); // Mengambil id dari tombol
                Swal.fire({
                    title: 'Hapus Tanaman?',
                    text: "Data yang dihapus tidak bisa dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = `daftar_tanaman_controller.php?action=hapus&id_tanaman=${id_tanaman}`;
                    }
                });
            });
        });

        // Mengisi data ke modal edit saat tombol diklik
        document.querySelectorAll('.btn-edit').forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const nama = this.getAttribute('data-nama');
                const sinonim = this.getAttribute('data-sinonim');
                const kategori = this.getAttribute('data-edit-kategori');

                document.getElementById('edit_id').value = id;
                document.getElementById('edit_nama_tanaman').value = nama;
                document.getElementById('edit_kategori').value = kategori;

                const inputSinonim = document.getElementById('edit_sinonim');
                if (!sinonim || sinonim.trim() === "") {
                    inputSinonim.value = ""; //Kosong agar admin bisa mengetik
                    inputSinonim.placeholder = "Belum ada sinonim"; 
                } else {
                    inputSinonim.value = sinonim;
                    inputSinonim.placeholder = "Contoh: Aloe Vera, Jadam";
                }

            });
        });

        if (pesan === 'sukses_edit') {
            Swal.fire('Berhasil!', 'Tanaman berhasil diperbarui.', 'success');
            window.history.replaceState({}, document.title, window.location.pathname);
        }
    </script>
</body>
</html>