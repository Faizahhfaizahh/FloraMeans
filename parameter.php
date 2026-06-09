<?php
    require_once 'auth.php';               
    require_once 'parameter_controller.php'; 
    require_once 'viewHelper.php';           

    Auth::cekLoginAdmin(); 

    $paramObj = new Parameter();
    $dataParam = $paramObj->tampilSemua();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Standarisasi Parameter Sensor - FloraMeans Admin</title>
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
                ViewHelper::renderHeader("Standarisasi Parameter Sensor", "modalTambahParam"); 
            ?>
            <div class="card p-4 border-0 shadow-sm">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th class="py-3">No</th>
                                <th class="py-3">Nama Kategori</th>
                                <th class="py-3 text-center">Suhu Udara (°C)</th>
                                <th class="py-3 text-center">Lembap Udara (%)</th>
                                <th class="py-3 text-center">Lembap Tanah (%)</th>
                                <th class="py-3 text-center">Cahaya (Lux)</th>
                                <th class="py-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $no = 1;
                            if (mysqli_num_rows($dataParam) > 0){
                                while ($row = mysqli_fetch_assoc($dataParam)): 
                            ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td class="fw-bold text-success"><?= $row['nama_kategori']; ?></td>
                                <td class="text-center small text-muted">
                                    <?= $row['suhu_udara_min']; ?> - <?= $row['suhu_udara_max']; ?>
                                </td>
                                <td class="text-center small text-muted">
                                    <?= $row['lembab_udara_min']; ?> - <?= $row['lembab_udara_max']; ?>
                                </td>
                                <td class="text-center small text-muted">
                                    <?= $row['lembab_tanah_min']; ?> - <?= $row['lembab_tanah_max']; ?>
                                </td>
                                <td class="text-center small text-muted">
                                    <?= $row['cahaya_min']; ?> - <?= $row['cahaya_max']; ?>
                                </td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-light text-warning btn-edit-param" 
                                        data-id="<?= $row['id_kategori']; ?>"
                                        data-nama="<?= $row['nama_kategori']; ?>"
                                        data-smin="<?= $row['suhu_udara_min']; ?>" data-smax="<?= $row['suhu_udara_max']; ?>"
                                        data-lumin="<?= $row['lembab_udara_min']; ?>" data-lumax="<?= $row['lembab_udara_max']; ?>"
                                        data-ltmin="<?= $row['lembab_tanah_min']; ?>" data-ltmax="<?= $row['lembab_tanah_max']; ?>"
                                        data-cmin="<?= $row['cahaya_min']; ?>" data-cmax="<?= $row['cahaya_max']; ?>"
                                        data-bs-toggle="modal" data-bs-target="#modalEditParam">
                                        <i class="bi bi-sliders"></i> Atur
                                    </button>
                                </td>
                            </tr>
                            <?php 
                                endwhile; 
                            } else{
                                echo '<tr><td colspan="7" class="text-center py-5 text-muted italic">Tidak ada data yang dimasukkan.</td></tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
</div>

<div class="modal fade" id="modalTambahParam" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 15px;">
            <form action="parameter_controller.php" method="POST">
                <div class="modal-header bg-success text-white" style="border-top-left-radius: 15px; border-top-right-radius: 15px;">
                    <h5 class="modal-title fw-bold"><i class="bi bi-sliders me-2"></i>Atur Standarisasi Kategori</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="mb-2">
                        <label class="form-label fw-bold">Pilih Kategori</label>
                        <select name="id_kategori" class="form-select bg-light border-0" required>
                            <option value="" selected disabled>-- Pilih Kategori --</option>
                            <?php 
                            $kategoriKosong = $paramObj->tampilKategoriKosong();
                            while($kat = mysqli_fetch_assoc($kategoriKosong)): 
                            ?>
                                <option value="<?= $kat['id_kategori']; ?>"><?= $kat['nama_kategori']; ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <hr class="mb-2">

                    <?php
                    $params = [
                        ['id' => 'suhu_udara', 'label' => 'Suhu Udara', 'unit' => '°C', 'min' => 0, 'max' => 50, 'step' => 0.5, 'val_min' => 20, 'val_max' => 35],
                        ['id' => 'cahaya', 'label' => 'Intensitas Cahaya', 'unit' => 'Lux', 'min' => 0, 'max' => 70000, 'step' => 500, 'val_min' => 5000, 'val_max' => 60000],
                        ['id' => 'lembab_udara', 'label' => 'Kelembapan Udara', 'unit' => '%', 'min' => 0, 'max' => 100, 'step' => 1, 'val_min' => 40, 'val_max' => 80],
                        ['id' => 'lembab_tanah', 'label' => 'Kelembapan Tanah', 'unit' => '%', 'min' => 0, 'max' => 100, 'step' => 1, 'val_min' => 30, 'val_max' => 70],
                    ];

                    foreach ($params as $p):
                    ?>
                    <div class="mb-2">
                        <label class="fw-bold mb-2 text-dark"><?= $p['label']; ?> (<?= $p['unit']; ?>)</label>
                        <div class="d-flex align-items-center gap-2">
                            <div class="text-center" style="min-width: 50px;">
                                <small class="text-muted d-block" style="font-size: 9px;">MIN</small>
                                <span class="badge bg-secondary w-100" id="txt_<?= $p['id']; ?>_min"><?= $p['val_min']; ?></span>
                            </div>

                            <input type="range" name="<?= $p['id']; ?>_min" id="range_<?= $p['id']; ?>_min" 
                                   class="form-range" min="<?= $p['min']; ?>" max="<?= $p['max']; ?>" 
                                   step="<?= $p['step']; ?>" value="<?= $p['val_min']; ?>" 
                                   oninput="validateRange('<?= $p['id']; ?>', 'min')">
                            
                            <input type="range" name="<?= $p['id']; ?>_max" id="range_<?= $p['id']; ?>_max" 
                                   class="form-range" min="<?= $p['min']; ?>" max="<?= $p['max']; ?>" 
                                   step="<?= $p['step']; ?>" value="<?= $p['val_max']; ?>" 
                                   oninput="validateRange('<?= $p['id']; ?>', 'max')">

                            <div class="text-center" style="min-width: 50px;">
                                <small class="text-muted d-block" style="font-size: 9px;">MAX</small>
                                <span class="badge bg-success w-100" id="txt_<?= $p['id']; ?>_max"><?= $p['val_max']; ?></span>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <div class="modal-footer border-0 bg-light">
                    <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" name="btn_edit_parameter" class="btn btn-success px-4 fw-bold">Simpan Standarisasi</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalEditParam" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 15px;">
            <form action="parameter_controller.php" method="POST">
                <div class="modal-header bg-warning text-dark" style="border-top-left-radius: 15px; border-top-right-radius: 15px;">
                    <h5 class="modal-title fw-bold"><i class="bi bi-pencil-square me-2"></i>Edit Standarisasi: <span id="label_nama_kategori"></span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <input type="hidden" name="id_kategori" id="edit_id">

                    <?php
                    $paramsEdit = [
                        ['id' => 'suhu_udara', 'label' => 'Suhu Udara', 'unit' => '°C', 'min' => 0, 'max' => 50, 'step' => 0.5],
                        ['id' => 'cahaya', 'label' => 'Intensitas Cahaya', 'unit' => 'Lux', 'min' => 0, 'max' => 70000, 'step' => 500],
                        ['id' => 'lembab_udara', 'label' => 'Kelembapan Udara', 'unit' => '%', 'min' => 0, 'max' => 100, 'step' => 1],
                        ['id' => 'lembab_tanah', 'label' => 'Kelembapan Tanah', 'unit' => '%', 'min' => 0, 'max' => 100, 'step' => 1],
                    ];

                    foreach ($paramsEdit as $pe):
                    ?>
                    <div class="mb-4">
                        <label class="fw-bold mb-2 text-dark"><?= $pe['label']; ?> (<?= $pe['unit']; ?>)</label>
                        <div class="d-flex align-items-center gap-2">
                            <div class="text-center" style="min-width: 70px;">
                                <small class="text-muted d-block" style="font-size: 9px;">MIN</small>
                                <span class="badge bg-secondary w-100" id="txt_edit_<?= $pe['id']; ?>_min">0</span>
                            </div>

                            <input type="range" name="<?= $pe['id']; ?>_min" id="range_edit_<?= $pe['id']; ?>_min" 
                                   class="form-range" min="<?= $pe['min']; ?>" max="<?= $pe['max']; ?>" 
                                   step="<?= $pe['step']; ?>" 
                                   oninput="validateRangeEdit('<?= $pe['id']; ?>', 'min')">
                            
                            <input type="range" name="<?= $pe['id']; ?>_max" id="range_edit_<?= $pe['id']; ?>_max" 
                                   class="form-range" min="<?= $pe['min']; ?>" max="<?= $pe['max']; ?>" 
                                   step="<?= $pe['step']; ?>" 
                                   oninput="validateRangeEdit('<?= $pe['id']; ?>', 'max')">

                            <div class="text-center" style="min-width: 70px;">
                                <small class="text-muted d-block" style="font-size: 9px;">MAX</small>
                                <span class="badge bg-success w-100" id="txt_edit_<?= $pe['id']; ?>_max">0</span>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>

                </div>
                <div class="modal-footer border-0 bg-light">
                    <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" name="btn_edit_parameter" class="btn btn-warning px-4 fw-bold">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function validateRange(paramId, type) {
    const minSlider = document.getElementById(`range_${paramId}_min`);
    const maxSlider = document.getElementById(`range_${paramId}_max`);
    const minTxt = document.getElementById(`txt_${paramId}_min`);
    const maxTxt = document.getElementById(`txt_${paramId}_max`);

    let minValue = parseFloat(minSlider.value);
    let maxValue = parseFloat(maxSlider.value);

    if (type === 'min' && minValue >= maxValue) {
        minSlider.value = maxValue;
        minValue = maxValue;
    } else if (type === 'max' && maxValue <= minValue) {
        maxSlider.value = minValue;
        maxValue = minValue;
    }

    //Agar cahaya ada titik nya
    minTxt.innerText = (paramId === 'cahaya') ? minValue.toLocaleString('id-ID') : minValue;
    maxTxt.innerText = (paramId === 'cahaya') ? maxValue.toLocaleString('id-ID') : maxValue;
}

function validateRangeEdit(paramId, type) {
    const minSlider = document.getElementById(`range_edit_${paramId}_min`);
    const maxSlider = document.getElementById(`range_edit_${paramId}_max`);
    const minTxt = document.getElementById(`txt_edit_${paramId}_min`);
    const maxTxt = document.getElementById(`txt_edit_${paramId}_max`);

    let minValue = parseFloat(minSlider.value);
    let maxValue = parseFloat(maxSlider.value);

    if (type === 'min' && minValue >= maxValue) {
        minSlider.value = maxValue;
        minValue = maxValue;
    } else if (type === 'max' && maxValue <= minValue) {
        maxSlider.value = minValue;
        maxValue = minValue;
    }

    minTxt.innerText = (paramId === 'cahaya') ? minValue.toLocaleString('id-ID') : minValue;
    maxTxt.innerText = (paramId === 'cahaya') ? maxValue.toLocaleString('id-ID') : maxValue;
}

document.querySelectorAll('.btn-edit-param').forEach(btn => {
    btn.addEventListener('click', function() {
        document.getElementById('edit_id').value = this.dataset.id;
        document.getElementById('label_nama_kategori').innerText = this.dataset.nama;

        const fillSlider = (param, minVal, maxVal) => {
            const sMin = document.getElementById(`range_edit_${param}_min`);
            const sMax = document.getElementById(`range_edit_${param}_max`);
            if(sMin && sMax) {
                sMin.value = minVal;
                sMax.value = maxVal;

                validateRangeEdit(param, 'min');
                validateRangeEdit(param, 'max');
            }
        };

        fillSlider('suhu_udara', this.dataset.smin, this.dataset.smax);
        fillSlider('cahaya', this.dataset.cmin, this.dataset.cmax);
        fillSlider('lembab_udara', this.dataset.lumin, this.dataset.lumax);
        fillSlider('lembab_tanah', this.dataset.ltmin, this.dataset.ltmax);
    });
});

const urlParams = new URLSearchParams(window.location.search);
if(urlParams.get('pesan') === 'sukses_edit') {
    Swal.fire({
        title: 'Berhasil!',
        text: 'Parameter lingkungan telah diperbarui.',
        icon: 'success',
        confirmButtonColor: '#198754'
    });
    window.history.replaceState({}, document.title, window.location.pathname);
}
</script>
</body>
</html>