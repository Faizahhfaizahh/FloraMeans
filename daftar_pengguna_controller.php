<?php
require_once 'database.php'; // Mengambil kelas Database

class Pengguna extends Database {
    public function __construct(){
        parent::__construct();
    }

    public function tampilSemua(){
        $query = "SELECT * FROM user ORDER BY id_user DESC";
        return mysqli_query($this->conn, $query);
    }

    public function cari($keyword = null) {
        $query = "SELECT * FROM user";
        
        if ($keyword) {
            $keyword = $this->escape($keyword);
            $query .= " WHERE username LIKE '%$keyword%'";
        }
        
        $query .= " ORDER BY id_user DESC";
        return mysqli_query($this->conn, $query);
    }

    public function hapus($id_user){
        $id_user = $this->escape($id_user);
        $query = "DELETE FROM user WHERE id_user = '$id_user'";
        return mysqli_query($this->conn, $query);
    }
}


if (isset($_GET['action']) && $_GET['action'] === 'hapus') {
    $user = new Pengguna();
    $id_user = $user->escape($_GET['id_user']);
    
    if ($user->hapus($id_user)) {
        header("Location: daftar_pengguna.php?pesan=sukses_hapus");
    } else {
        header("Location: daftar_pengguna.php?pesan=gagal_hapus");
    }
    exit;
}
?>