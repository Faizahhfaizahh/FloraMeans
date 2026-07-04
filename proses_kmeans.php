<?php
require_once 'auth.php';
require_once 'database.php';

Auth::cekLoginUser();

$db = new Database();

$authObj = new Auth();
$conn = (fn() => $this->conn)->call($authObj);

// ============================================================
// LANGKAH 1: Ambil data input dari user
// ============================================================
$nama_tanaman_input = trim($_POST['nama_tanaman']);
$suhu_input         = round(floatval($_POST['suhu_input']), 2);
$cahaya_input       = round(floatval($_POST['cahaya_input']), 2);
$lembab_udara_input = round(floatval($_POST['lembab_udara_input']), 2);
$lembab_tanah_input = round(floatval($_POST['lembab_tanah_input']), 2);
$id_user            = $_SESSION['id_user'];

// ============================================================
// LANGKAH 2: Ambil data standarisasi sensor dari tabel kategori
//            (ini yang menjadi centroid awal K-Means)
// ============================================================
$query_kategori = "SELECT * FROM kategori 
    WHERE suhu_udara_max > 0
    OR lembab_udara_max > 0
    OR lembab_tanah_max > 0
    OR cahaya_max > 0";
$result_kategori = mysqli_query($conn, $query_kategori);

$centroids = [];
while ($row = mysqli_fetch_assoc($result_kategori)) {
    // Centroid = nilai tengah (rata-rata) dari min dan max setiap parameter
    $centroids[] = [
        'id_kategori'   => $row['id_kategori'],
        'nama_kategori' => $row['nama_kategori'],
        'suhu'          => ($row['suhu_udara_min'] + $row['suhu_udara_max']) / 2,
        'cahaya'        => ($row['cahaya_min'] + $row['cahaya_max']) / 2,
        'lembab_udara'  => ($row['lembab_udara_min'] + $row['lembab_udara_max']) / 2,
        'lembab_tanah'  => ($row['lembab_tanah_min'] + $row['lembab_tanah_max']) / 2,
    ];
}

// Validasi: Memastikan ada data kategori
if (empty($centroids)) {
    die(json_encode(['status' => 'error', 'message' => 'Data standarisasi belum diisi admin.']));
}

// ============================================================
// LANGKAH 3: Hitung jarak Euclidean antara input user
//            dengan setiap centroid kategori
// ============================================================
function hitungJarakEuclidean($input, $centroid) {
    return sqrt(
        pow($input['suhu']         - $centroid['suhu'], 2) +
        pow($input['cahaya']       - $centroid['cahaya'], 2) +
        pow($input['lembab_udara'] - $centroid['lembab_udara'], 2) +
        pow($input['lembab_tanah'] - $centroid['lembab_tanah'], 2)
    );
}

$data_input = [
    'suhu'         => $suhu_input,
    'cahaya'       => $cahaya_input,
    'lembab_udara' => $lembab_udara_input,
    'lembab_tanah' => $lembab_tanah_input,
];

$jarak_terdekat   = PHP_FLOAT_MAX;
$cluster_hasil    = '';
$id_kategori_hasil = null;

foreach ($centroids as $centroid) {
    $jarak = hitungJarakEuclidean($data_input, $centroid);

    // ============================================================
    // LANGKAH 4: Tentukan cluster dengan jarak terpendek
    // ============================================================
    if ($jarak < $jarak_terdekat) {
        $jarak_terdekat    = $jarak;
        $cluster_hasil     = $centroid['nama_kategori'];
        $id_kategori_hasil = $centroid['id_kategori'];
    }
}

// ============================================================
// LANGKAH 5: Cari nama tanaman di tabel referensi kemudian
//            Cek nama tanaman dan sinonim (LOWER agar tidak case-sensitive)
// ============================================================
$nama_cari = mysqli_real_escape_string($conn, strtolower($nama_tanaman_input));

$query_tanaman = "
    SELECT t.id_tanaman, t.id_kategori, k.nama_kategori 
    FROM tanaman t
    JOIN kategori k ON t.id_kategori = k.id_kategori
    WHERE LOWER(t.nama_tanaman) = '$nama_cari'
       OR LOWER(t.sinonim) LIKE '%$nama_cari%'
    LIMIT 1
";
$result_tanaman = mysqli_query($conn, $query_tanaman);

$id_tanaman      = null;
$status_tanaman  = 'Belum Terdaftar';
$kategori_referensi = null;

if (mysqli_num_rows($result_tanaman) > 0) {
    $data_tanaman       = mysqli_fetch_assoc($result_tanaman);
    $id_tanaman         = $data_tanaman['id_tanaman'];
    $kategori_referensi = $data_tanaman['nama_kategori'];
    $status_tanaman     = 'Terdaftar';
}

// =================================================================================
// LANGKAH 6: Tentukan kesesuaian lingkungan
//            Dengan membandingkan hasil cluster K-Means dengan kategori referensi
// =================================================================================
if ($status_tanaman === 'Terdaftar') {
    // Tanaman ditemukan di referensi — bandingkan cluster
    $status_lingkungan = (strtolower($cluster_hasil) === strtolower($kategori_referensi))
        ? 'Sesuai'
        : 'Tidak Sesuai';
} else {
    // Tanaman tidak ditemukan di referensi — tidak bisa dibandingkan
    $status_lingkungan = 'Tidak Diketahui';
}

// ============================================================
// LANGKAH 7: Simpan hasil ke tabel simulasi
// ============================================================
$nama_esc = mysqli_real_escape_string($conn, $nama_tanaman_input);
$id_tanaman_sql = $id_tanaman ? "'$id_tanaman'" : "NULL";

$query_simpan = "
    INSERT INTO simulasi (
        id_user, id_tanaman, nama_tanaman_input,
        suhu_input, cahaya_input, lembab_tanah_input, lembab_udara_input,
        hasil_clustering, status_lingkungan, jarak_centroid
    ) VALUES (
        '$id_user', $id_tanaman_sql, '$nama_esc',
        '$suhu_input', '$cahaya_input', '$lembab_tanah_input', '$lembab_udara_input',
        '$cluster_hasil', '$status_lingkungan', $jarak_terdekat
    )
";

if (!mysqli_query($conn, $query_simpan)) {
    die('Gagal menyimpan hasil: ' . mysqli_error($conn));
}

$id_simulasi_baru = mysqli_insert_id($conn);

// ============================================================
// LANGKAH 8: Redirect ke halaman hasil
// ============================================================
header("Location: hasil_clustering.php?id=" . $id_simulasi_baru);
exit;
?>