<?php
require_once 'database.php';

class Dashboard extends Database {
    public function __construct() {
        parent::__construct();
    }

    public function getTotalPengguna() {
        $result = mysqli_query($this->conn, "SELECT COUNT(*) as total FROM user");
        return mysqli_fetch_assoc($result)['total'];
    }

    public function getTotalTanaman() {
        $result = mysqli_query($this->conn, "SELECT COUNT(*) as total FROM tanaman");
        return mysqli_fetch_assoc($result)['total'];
    }

    public function getTotalClustering($id_user = null) {
        $whereClause = $id_user !== null ? "WHERE id_user = '" . $this->escape($id_user) . "'" : "";
        $result = mysqli_query($this->conn, "SELECT COUNT(*) as total FROM simulasi $whereClause");
        return mysqli_fetch_assoc($result)['total'];
    }

    public function getLingkunganSesuai($id_user) {
        $id_user = $this->escape($id_user);
        $result = mysqli_query($this->conn, "SELECT COUNT(*) as total FROM simulasi WHERE status_lingkungan = 'Sesuai' AND id_user = '$id_user'");
        return mysqli_fetch_assoc($result)['total'];
    }

    public function getLingkunganTidakSesuai($id_user) {
        $id_user = $this->escape($id_user);
        $result = mysqli_query($this->conn, "SELECT COUNT(*) as total FROM simulasi WHERE status_lingkungan = 'Tidak Sesuai' AND id_user = '$id_user'");
        return mysqli_fetch_assoc($result)['total'];
    }

    public function getDataScatterPlot($id_user = null) {
        $whereClause = $id_user !== null ? "WHERE id_user = '" . $this->escape($id_user) . "'" : "";

        $query = "SELECT suhu_input, cahaya_input, lembab_udara_input, lembab_tanah_input,
                        hasil_clustering, jarak_centroid
                FROM simulasi $whereClause";
        $result = mysqli_query($this->conn, $query);

        $titik_data = [];
        $semua_jarak = [];

        while ($row = mysqli_fetch_assoc($result)) {
            $titik_data[] = $row;
            $semua_jarak[] = (float)$row['jarak_centroid'];
        }

        if (count($semua_jarak) > 0) {
            $rata2 = array_sum($semua_jarak) / count($semua_jarak);
            $variansi = 0;
            foreach ($semua_jarak as $j) {
                $variansi += pow($j - $rata2, 2);
            }
            $std_dev = sqrt($variansi / count($semua_jarak));
            $threshold = $rata2 + (2 * $std_dev);
            $jarakMin = min($semua_jarak);
            $jarakMax = max($semua_jarak);
        } else {
            $threshold = 0;
            $jarakMin = 0;
            $jarakMax = 1;
        }

        $warnaKategoriRGB = [
            'Xerofit'  => [202, 138, 4],
            'Mesofit'  => [22, 101, 52],
            'Hidrofit' => [8, 145, 178],
            'Higrofit' => [30, 64, 175],
        ];

        $scatter_suhu_kelembapan = [];
        $scatter_cahaya_tanah    = [];
        $jarakNonOutlier = [];

        foreach ($titik_data as $t) {
            $jarak = (float)$t['jarak_centroid'];
            $kategori = trim($t['hasil_clustering']);
            $is_outlier = $jarak > $threshold;

            if (!$is_outlier) {
                $jarakNonOutlier[] = $jarak;
            }

            $range = $jarakMax - $jarakMin;
            $jarakNormal = $range > 0 ? ($jarak - $jarakMin) / $range : 0;
            $opacity = $is_outlier ? 1.0 : max(0.3, 1.0 - $jarakNormal);

            if ($is_outlier) {
                $warna = 'rgba(220, 38, 38, 1)';
            } else {
                $rgb = $warnaKategoriRGB[$kategori] ?? [107, 114, 128];
                $warna = "rgba({$rgb[0]}, {$rgb[1]}, {$rgb[2]}, " . round($opacity, 2) . ")";
            }

            $scatter_suhu_kelembapan[] = [
                'x' => (float)$t['suhu_input'],
                'y' => (float)$t['lembab_udara_input'],
                'kategori' => $kategori,
                'outlier' => $is_outlier,
                'jarak' => round($jarak, 2),
                'color' => $warna,
            ];
            $scatter_cahaya_tanah[] = [
                'x' => (float)$t['cahaya_input'],
                'y' => (float)$t['lembab_tanah_input'],
                'kategori' => $kategori,
                'outlier' => $is_outlier,
                'jarak' => round($jarak, 2),
                'color' => $warna,
            ];
        }

        $rataJarak = !empty($jarakNonOutlier) ? array_sum($jarakNonOutlier) / count($jarakNonOutlier) : 0;
        return [
            'suhu_kelembapan' => $scatter_suhu_kelembapan,
            'cahaya_tanah'    => $scatter_cahaya_tanah,
            'threshold'       => round($threshold, 2),
            'total_outlier'   => count(array_filter($titik_data, function($t) use ($threshold) {
                return (float)$t['jarak_centroid'] > $threshold;
            })),
            'rataJarak' => round($rataJarak, 2),
        ];
    }

    public function getCentroidKategori() {
        $query = "SELECT nama_kategori,
                        (suhu_udara_min + suhu_udara_max) / 2 as suhu,
                        (cahaya_min + cahaya_max) / 2 as cahaya,
                        (lembab_udara_min + lembab_udara_max) / 2 as lembab_udara,
                        (lembab_tanah_min + lembab_tanah_max) / 2 as lembab_tanah
                FROM kategori";
        $result = mysqli_query($this->conn, $query);

        $warna_centroid = '#1f2937';
        $centroid_suhu_kelembapan = [];
        $centroid_cahaya_tanah    = [];

        while ($row = mysqli_fetch_assoc($result)) {
            $nama = trim($row['nama_kategori']);

            $centroid_suhu_kelembapan[] = [
                'x' => (float)$row['suhu'],
                'y' => (float)$row['lembab_udara'],
                'label' => $nama,
                'color' => $warna_centroid,
            ];
            $centroid_cahaya_tanah[] = [
                'x' => (float)$row['cahaya'],
                'y' => (float)$row['lembab_tanah'],
                'label' => $nama,
                'color' => $warna_centroid,
            ];
        }
        return [
            'suhu_kelembapan' => $centroid_suhu_kelembapan,
            'cahaya_tanah'    => $centroid_cahaya_tanah,
        ];
    }

    private function formatTanggalIndo($dateTimeObj) {
        $namaBulanIndo = [
            1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr',
            5 => 'Mei', 6 => 'Jun', 7 => 'Jul', 8 => 'Agu',
            9 => 'Sep', 10 => 'Okt', 11 => 'Nov', 12 => 'Des'
        ];
        $tgl = $dateTimeObj->format('d');
        $bulan = $namaBulanIndo[(int)$dateTimeObj->format('n')];
        return $tgl . ' ' . $bulan;
    }

    public function getSemuaAktivitasMingguan($id_user = null) {
        $whereClause = $id_user !== null ? "WHERE id_user = '" . $this->escape($id_user) . "'" : "";

        $query = "SELECT 
                    YEARWEEK(waktu_simulasi, 1) as minggu_key,
                    DATE(waktu_simulasi) as tanggal,
                    COUNT(*) as total
                FROM simulasi $whereClause
                GROUP BY minggu_key, tanggal
                ORDER BY minggu_key ASC, tanggal ASC";

        $result = mysqli_query($this->conn, $query);
        $mingguMap = [];

        while ($row = mysqli_fetch_assoc($result)) {
            $key = $row['minggu_key'];
            if (!isset($mingguMap[$key])) {
                $mingguMap[$key] = [];
            }
            $mingguMap[$key][$row['tanggal']] = (int)$row['total'];
        }
        $hasil = [];

        foreach ($mingguMap as $key => $tanggalData) {
            $tanggalPertama = array_key_first($tanggalData);
            $dt = new DateTime($tanggalPertama);

            $dayOfWeek = (int)$dt->format('N');
            $senin = (clone $dt)->modify('-' . ($dayOfWeek - 1) . ' days');
            $minggu = (clone $senin)->modify('+6 days');

            $labelsHarian = [];
            $dataHarian = [];
            $namaHari = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];

            for ($i = 0; $i < 7; $i++) {
                $tgl = (clone $senin)->modify("+$i days");
                $tglStr = $tgl->format('Y-m-d');
                $labelsHarian[] = $namaHari[$i];
                $dataHarian[] = $tanggalData[$tglStr] ?? 0;
            }
            $hasil[] = [
                'key' => $key,
                'label' => $this->formatTanggalIndo($senin) . ' - ' . $this->formatTanggalIndo($minggu),
                'labels_chart' => $labelsHarian,
                'data_chart' => $dataHarian,
            ];
        }
        // Mengurutkan dari yang terbaru ke terlama (dropdown)
        return array_reverse($hasil);
    }

    public function getSemuaAktivitasBulanan($id_user = null) {
        $whereClause = $id_user !== null ? "WHERE id_user = '" . $this->escape($id_user) . "'" : "";

        $namaBulanIndo = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];
        $query = "SELECT 
                    DATE_FORMAT(waktu_simulasi, '%Y-%m') as bulan_key,
                    DAY(waktu_simulasi) as tanggal_ke,
                    COUNT(*) as total
                FROM simulasi $whereClause
                GROUP BY bulan_key, tanggal_ke
                ORDER BY bulan_key ASC, tanggal_ke ASC";

        $result = mysqli_query($this->conn, $query);

        $bulanMap = [];

        while ($row = mysqli_fetch_assoc($result)) {
            $key = $row['bulan_key'];
            if (!isset($bulanMap[$key])) {
                $bulanMap[$key] = [];
            }
            $bulanMap[$key][(int)$row['tanggal_ke']] = (int)$row['total'];
        }
        $hasil = [];

        foreach ($bulanMap as $key => $tanggalData) {
            $dt = DateTime::createFromFormat('Y-m', $key);
            $jumlahHari = (int)$dt->format('t');
            $bulanNum = (int)$dt->format('n');
            $tahun = $dt->format('Y');

            $labelsChart = [];
            $dataChart = [];

            for ($i = 1; $i <= $jumlahHari; $i++) {
                $labelsChart[] = (string)$i;
                $dataChart[] = $tanggalData[$i] ?? 0;
            }
            $hasil[] = [
                'key' => $key,
                'label' => $namaBulanIndo[$bulanNum] . ' ' . $tahun, 
                'labels_chart' => $labelsChart,
                'data_chart' => $dataChart,
            ];
        }
        return array_reverse($hasil);
    }

    public function getDaftarTanamanDicek($id_user = null) {
        $whereClause = $id_user !== null ? "WHERE id_user = '" . $this->escape($id_user) . "'" : "";

        $query = "SELECT nama_tanaman_input, COUNT(*) as jumlah
                FROM simulasi $whereClause
                GROUP BY nama_tanaman_input
                ORDER BY jumlah DESC, nama_tanaman_input ASC";

        $result = mysqli_query($this->conn, $query);

        $daftar = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $daftar[] = [
                'nama' => $row['nama_tanaman_input'],
                'jumlah' => (int)$row['jumlah'],
            ];
        }
        return $daftar;
    }

    public function getTrenSensorTanaman($id_user = null, $nama_tanaman) {
        $nama_tanaman = $this->escape($nama_tanaman);
        if ($id_user !== null) {
            $id_user = $this->escape($id_user);
            $whereClause = "WHERE id_user = '$id_user' AND nama_tanaman_input = '$nama_tanaman'";
        } else {
            $whereClause = "WHERE nama_tanaman_input = '$nama_tanaman'";
        }

        $query = "SELECT waktu_simulasi, suhu_input, cahaya_input, lembab_udara_input, lembab_tanah_input
                FROM simulasi $whereClause 
                ORDER BY waktu_simulasi ASC";

        $result = mysqli_query($this->conn, $query);

        $labels = [];
        $suhu = [];
        $cahaya = [];
        $cahayaAsli = [];
        $lembabUdara = [];
        $lembabTanah = [];

        while ($row = mysqli_fetch_assoc($result)) {
            $tgl = new DateTime($row['waktu_simulasi']);
            $labels[] = $tgl->format('d/m H:i');
            $suhu[] = (float)$row['suhu_input'];
            $cahayaAsli[] = (float)$row['cahaya_input'];
            $lembabUdara[] = (float)$row['lembab_udara_input'];
            $lembabTanah[] = (float)$row['lembab_tanah_input'];
        }

        // Normalisasi cahaya ke skala 0-100 (Min-Max Normalization)
        if (!empty($cahayaAsli)) {
            $minCahaya = min($cahayaAsli);
            $maxCahaya = max($cahayaAsli);
            $range = $maxCahaya - $minCahaya;

            foreach ($cahayaAsli as $val) {
                $cahaya[] = $range > 0 ? round((($val - $minCahaya) / $range) * 100, 1) : 50;
            }
        }

        return [
            'labels' => $labels,
            'suhu' => $suhu,
            'cahaya' => $cahaya,           // sudah dinormalisasi 0-100
            'cahaya_asli' => $cahayaAsli,  // nilai asli, dipakai untuk tooltip
            'lembab_udara' => $lembabUdara,
            'lembab_tanah' => $lembabTanah,
        ];
    }

    public function getProporsiKategoriAdmin() {
        $query = "SELECT hasil_clustering as kategori, COUNT(*) as total
                FROM simulasi
                GROUP BY hasil_clustering";
        $result = mysqli_query($this->conn, $query);

        $dataKategori = [
            'Xerofit'  => 0,
            'Mesofit'  => 0,
            'Hidrofit' => 0,
            'Higrofit' => 0,
        ];
        while ($row = mysqli_fetch_assoc($result)) {
            $kategori = trim($row['kategori']);
            if (array_key_exists($kategori, $dataKategori)) {
                $dataKategori[$kategori] = (int)$row['total'];
            }
        }
        return [
            'labels' => array_keys($dataKategori),
            'data'   => array_values($dataKategori),
        ];
    }
}
?>