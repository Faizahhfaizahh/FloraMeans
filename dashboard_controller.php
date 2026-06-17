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

    public function getTotalClustering() {
        $result = mysqli_query($this->conn, "SELECT COUNT(*) as total FROM simulasi");
        return mysqli_fetch_assoc($result)['total'];
    }

    public function getTotalKategoriTerisi() {
        $result = mysqli_query($this->conn, 
            "SELECT COUNT(*) as total FROM kategori WHERE suhu_udara_max > 0");
        return mysqli_fetch_assoc($result)['total'];
    }

    public function getLingkunganSesuai() {
        $result = mysqli_query($this->conn, "SELECT COUNT(*) as total FROM simulasi WHERE status_lingkungan = 'Sesuai'");
        return mysqli_fetch_assoc($result)['total'];
    }

    public function getLingkunganTidakSesuai() {
        $result = mysqli_query($this->conn, "SELECT COUNT(*) as total FROM simulasi WHERE status_lingkungan = 'Tidak Sesuai'");
        return mysqli_fetch_assoc($result)['total'];
    }

    public function getAktivitas7HariDetail() {
            $dataset = [
                'Sesuai' => [2 => 0, 3 => 0, 4 => 0, 5 => 0, 6 => 0, 7 => 0, 1 => 0],
                'Tidak Sesuai' => [2 => 0, 3 => 0, 4 => 0, 5 => 0, 6 => 0, 7 => 0, 1 => 0],
                'Tidak Diketahui' => [2 => 0, 3 => 0, 4 => 0, 5 => 0, 6 => 0, 7 => 0, 1 => 0]
            ];

            $query = "SELECT 
                        DAYOFWEEK(waktu_simulasi) as no_hari, 
                        status_lingkungan,
                        COUNT(*) as total 
                    FROM simulasi 
                    WHERE waktu_simulasi >= DATE_SUB(CURDATE(), INTERVAL 6 DAY)
                    GROUP BY DAYOFWEEK(waktu_simulasi), status_lingkungan";
                    
            $result = mysqli_query($this->conn, $query);
            
            while ($row = mysqli_fetch_assoc($result)) {
                $noHari = (int)$row['no_hari'];
                $statusRaw = $row['status_lingkungan'];
                
                if ($statusRaw == 'Sesuai') {
                    $dataset['Sesuai'][$noHari] = (int)$row['total'];
                } elseif ($statusRaw == 'Tidak Sesuai') {
                    $dataset['Tidak Sesuai'][$noHari] = (int)$row['total'];
                } else {
                    $dataset['Tidak Diketahui'][$noHari] = (int)$row['total'];
                }
            }

            return [
                'sesuai' => [
                    $dataset['Sesuai'][2], $dataset['Sesuai'][3], $dataset['Sesuai'][4], 
                    $dataset['Sesuai'][5], $dataset['Sesuai'][6], $dataset['Sesuai'][7], $dataset['Sesuai'][1]
                ],
                'tidak_sesuai' => [
                    $dataset['Tidak Sesuai'][2], $dataset['Tidak Sesuai'][3], $dataset['Tidak Sesuai'][4], 
                    $dataset['Tidak Sesuai'][5], $dataset['Tidak Sesuai'][6], $dataset['Tidak Sesuai'][7], $dataset['Tidak Sesuai'][1]
                ],
                'tidak_diketahui' => [
                    $dataset['Tidak Diketahui'][2], $dataset['Tidak Diketahui'][3], $dataset['Tidak Diketahui'][4], 
                    $dataset['Tidak Diketahui'][5], $dataset['Tidak Diketahui'][6], $dataset['Tidak Diketahui'][7], $dataset['Tidak Diketahui'][1]
                ]
            ];
        }

        public function getAktivitasMingguanAdmin() {
            $hariTemplate = [
                2 => 0, //Senin
                3 => 0, //Selasa
                4 => 0, //Rabu
                5 => 0, //Kamis
                6 => 0, //Jumat
                7 => 0, //Sabtu
                1 => 0  //Minggu
            ];

            $query = "SELECT DAYOFWEEK(waktu_simulasi) as no_hari, COUNT(*) as total 
                    FROM simulasi 
                    WHERE waktu_simulasi >= DATE_SUB(CURDATE(), INTERVAL 6 DAY)
                    GROUP BY DAYOFWEEK(waktu_simulasi)";
                    
            $result = mysqli_query($this->conn, $query);
            
            while ($row = mysqli_fetch_assoc($result)) {
                $hariTemplate[(int)$row['no_hari']] = (int)$row['total'];
            }
            
            return [
                $hariTemplate[2], 
                $hariTemplate[3], 
                $hariTemplate[4], 
                $hariTemplate[5], 
                $hariTemplate[6], 
                $hariTemplate[7], 
                $hariTemplate[1]  
            ];
        }
}
?>