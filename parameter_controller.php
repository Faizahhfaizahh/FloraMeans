<?php
require_once 'database.php';

class Parameter extends Database {
    public function __construct(){
        parent::__construct();
    }

    // Mengambil semua data kategori (beserta nilai parameternya)
    public function tampilSemua(){
        $query = "SELECT * FROM kategori 
        WHERE suhu_udara_max > 0
        OR lembab_udara_max > 0
        OR lembab_tanah_max > 0
        OR cahaya_max > 0
        ORDER BY id_kategori DESC";
        return mysqli_query($this->conn, $query);
    }

    public function tampilKategoriKosong(){
        $query = "SELECT * FROM kategori WHERE suhu_udara_max = 0";
        return mysqli_query($this->conn, $query);
    }

    public function edit($id, $s_min, $s_max, $lu_min, $lu_max, $lt_min, $lt_max, $c_min, $c_max){
        $id     = $this->escape($id);
        $s_min  = $this->escape($s_min);
        $s_max  = $this->escape($s_max);
        $lu_min = $this->escape($lu_min);
        $lu_max = $this->escape($lu_max);
        $lt_min = $this->escape($lt_min);
        $lt_max = $this->escape($lt_max);
        $c_min  = $this->escape($c_min);
        $c_max  = $this->escape($c_max);

        $query = "UPDATE kategori SET 
                    suhu_udara_min = '$s_min', 
                    suhu_udara_max = '$s_max', 
                    lembab_udara_min = '$lu_min', 
                    lembab_udara_max = '$lu_max',
                    lembab_tanah_min = '$lt_min', 
                    lembab_tanah_max = '$lt_max',
                    cahaya_min = '$c_min', 
                    cahaya_max = '$c_max' 
                  WHERE id_kategori = '$id'";
        
        return mysqli_query($this->conn, $query);
    }
}

$paramObj = new Parameter();

if (isset($_POST['btn_edit_parameter'])) {
    $id     = $_POST['id_kategori'];
    $s_min  = $_POST['suhu_udara_min'];
    $s_max  = $_POST['suhu_udara_max'];
    $lu_min = $_POST['lembab_udara_min'];
    $lu_max = $_POST['lembab_udara_max'];
    $lt_min = $_POST['lembab_tanah_min'];
    $lt_max = $_POST['lembab_tanah_max'];
    $c_min  = $_POST['cahaya_min'];
    $c_max  = $_POST['cahaya_max'];

    if ($paramObj->edit($id, $s_min, $s_max, $lu_min, $lu_max, $lt_min, $lt_max, $c_min, $c_max)) {
        header("Location: parameter.php?pesan=sukses_edit");
    } else {
        header("Location: parameter.php?pesan=gagal_edit");
    }
    exit;
}
?>