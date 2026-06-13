<?php
require_once 'database.php';

class Riwayat extends Database {
    public function __construct() {
        parent::__construct();
    }

    // Menampilkan riwayat user sendiri
    public function cariRiwayatUser($id_user, $keyword = null, $limit = 10, $offset = 0) {
        $id_user = $this->escape($id_user);
        
        // Tambahkan CASE WHEN di bawah ini agar format array-nya sama persis dengan yang dibutuhkan eksekusiDanFormat
        $query = "SELECT s.id_simulasi, s.nama_tanaman_input, s.hasil_clustering, s.status_lingkungan, 
                         s.suhu_input, s.lembab_udara_input, s.cahaya_input, s.lembab_tanah_input, 
                         s.waktu_simulasi, NULL as username,
                         CASE WHEN s.id_tanaman IS NOT NULL THEN 'ada' ELSE 'tidak' END as status_tanaman
                  FROM simulasi s
                  WHERE s.id_user = '$id_user'";

        if (!empty($keyword)) {
            $keyword = $this->escape($keyword);
            $query .= " AND s.nama_tanaman_input LIKE '%$keyword%'";
        }

        $query .= " ORDER BY s.id_simulasi DESC LIMIT $limit OFFSET $offset";
        return $this->eksekusiDanFormat($query);
    }

    // Menghitung total riwayat clustering user
    public function hitungTotalRiwayatUser($id_user, $keyword = '') {
        $id_user = $this->escape($id_user);
        
        if (!empty($keyword)) {
            $keyword = $this->escape($keyword);
            $query = "SELECT COUNT(*) as total FROM simulasi 
                      WHERE id_user = '$id_user' AND nama_tanaman_input LIKE '%$keyword%'";
        } else {
            $query = "SELECT COUNT(*) as total FROM simulasi WHERE id_user = '$id_user'";
        }
        
        $result = mysqli_query($this->conn, $query);
        $row    = mysqli_fetch_assoc($result);
        return (int)$row['total'];
    }

    //Menampilkan semua riwayat dari semua user + JOIN ke tabel user untuk mengambil username
    public function tampilSemuaRiwayatAdmin($keyword = null, $limit = 10, $offset = 0) {
        $query = "SELECT s.id_simulasi, s.nama_tanaman_input, s.hasil_clustering, s.status_lingkungan, 
                        s.suhu_input, s.lembab_udara_input, s.cahaya_input, s.lembab_tanah_input, 
                        s.waktu_simulasi, u.username,
                        CASE WHEN s.id_tanaman IS NOT NULL THEN 'ada' ELSE 'tidak' END as status_tanaman
                FROM simulasi s
                LEFT JOIN user u ON s.id_user = u.id_user";

        if (!empty($keyword)) {
            $keyword = $this->escape($keyword);
            $query .= " WHERE s.nama_tanaman_input LIKE '%$keyword%' 
                        OR u.username LIKE '%$keyword%' 
                        OR s.hasil_clustering LIKE '%$keyword%'";
        }

        $query .= " ORDER BY s.id_simulasi DESC LIMIT $limit OFFSET $offset";
        return $this->eksekusiDanFormat($query);
    }

    public function hitungTotalRiwayatAdmin($keyword = '') {
        if (!empty($keyword)) {
            $keyword = $this->escape($keyword);
            $query = "SELECT COUNT(*) as total FROM simulasi s
                    LEFT JOIN user u ON s.id_user = u.id_user
                    WHERE s.nama_tanaman_input LIKE '%$keyword%' 
                        OR u.username LIKE '%$keyword%'
                        OR s.hasil_clustering LIKE '%$keyword%'";
        } else {
            $query = "SELECT COUNT(*) as total FROM simulasi";
        }
        $result = mysqli_query($this->conn, $query);
        $row    = mysqli_fetch_assoc($result);
        return (int)$row['total'];
    }

    public function hapus($id_simulasi) {
        $id_simulasi = $this->escape($id_simulasi);
        $query = "DELETE FROM simulasi WHERE id_simulasi = '$id_simulasi'";
        return mysqli_query($this->conn, $query);
    }

    private function eksekusiDanFormat($query) {
        $result = mysqli_query($this->conn, $query);
        $riwayat_list = [];
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $riwayat_list[] = [
                    'id_riwayat'        => $row['id_simulasi'],
                    'username'          => $row['username'] ?? 'Akun dihapus',
                    'nama_tanaman'      => $row['nama_tanaman_input'],
                    'hasil_cluster'     => $row['hasil_clustering'],
                    'status_lingkungan' => $row['status_lingkungan'],
                    'status_tanaman'    => $row['status_tanaman'],
                    'waktu'             => date('d M Y, H:i', strtotime($row['waktu_simulasi'])),
                    'suhu'              => $row['suhu_input'] . ' °C',
                    'kelembapan_udara'  => $row['lembab_udara_input'] . ' %',
                    'intensitas_cahaya' => $row['cahaya_input'] . ' Lux',
                    'kelembapan_tanah'  => $row['lembab_tanah_input'] . ' %'
                ];
            }
        }
        return $riwayat_list;
    }
}

if (isset($_GET['action']) && $_GET['action'] === 'hapus') {
    $riwayat = new Riwayat();
    $from = isset($_GET['from']) ? $_GET['from'] : 'admin';
    
    if ($riwayat->hapus($_GET['id'])) {
        if ($from === 'user') {
            header("Location: riwayat_clustering_user.php?pesan=sukses_hapus");
        } else {
            header("Location: riwayat_clustering_admin.php?pesan=sukses_hapus");
        }
    } else {
        if ($from === 'user') {
            header("Location: riwayat_clustering_user.php?pesan=gagal_hapus");
        } else {
            header("Location: riwayat_clustering_admin.php?pesan=gagal_hapus");
        }
    }
    exit;
}
?>