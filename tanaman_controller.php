<?php
require_once 'database.php'; //Mengambil atau membaca file/isi file database.php

class Tanaman extends Database {
    public function __construct(){
        parent::__construct();
    }

    // Function untuk menampilkan semua tanaman yang ada
    public function tampilSemua(){
        $query = "SELECT tanaman.*, kategori.nama_kategori
                    FROM tanaman
                    LEFT JOIN kategori ON tanaman.id_kategori = kategori.id_kategori
                    ORDER BY tanaman.id_tanaman DESC";
        return mysqli_query($this->conn, $query);
    }

    //Fuction untuk menambah tanaman baru
    public function tambah($nama_tanaman, $sinonim, $id_kategori){
        $nama_tanaman = $this->escape($nama_tanaman);
        $sinonim = $this->escape($sinonim);
        $id_kategori = $this->escape($id_kategori);

        //Mengecek apakah nama tanaman sudah ada
        $cek = mysqli_query($this->conn, "SELECT * FROM tanaman WHERE nama_tanaman = '$nama_tanaman'");
        if (mysqli_num_rows($cek) > 0){
            return "duplikat";
        }

        $query = "INSERT INTO tanaman (nama_tanaman, sinonim, id_kategori) VALUES ('$nama_tanaman', '$sinonim', '$id_kategori')";
        if (mysqli_query($this->conn, $query)){
            return "sukses";
        } else {
            return "gagal";
        }
    }

    public function hapus($id_tanaman){
        $id_tanaman = $this->escape($id_tanaman);
        $query = "DELETE FROM tanaman WHERE id_tanaman = '$id_tanaman'";
        return mysqli_query($this->conn, $query);
    }

    //Mengambil satu data untuk modal edit
    public function ambilData ($id_tanaman){
        $id_tanaman = $this->escape($id_tanaman);
        $query = "SELECT * FROM tanaman WHERE id_tanaman = '$id_tanaman'";
        $result = mysqli_query($this->conn, $query);
        return mysqli_fetch_assoc($result);
    }

    public function edit($id_tanaman, $nama_tanaman, $sinonim, $id_kategori){
        $id_tanaman = $this->escape($id_tanaman);
        $nama_tanaman = $this->escape($nama_tanaman);
        $sinonim = $this->escape($sinonim);
        $id_kategori = $this->escape($id_kategori);

        $query = "UPDATE tanaman SET 
                    nama_tanaman = '$nama_tanaman', 
                    sinonim = '$sinonim', 
                    id_kategori = '$id_kategori' 
                    WHERE id_tanaman = '$id_tanaman'";
        return mysqli_query($this->conn, $query);
    }

    public function cari($keyword = null) {
        $query = "SELECT tanaman.*, kategori.nama_kategori 
                FROM tanaman 
                LEFT JOIN kategori ON tanaman.id_kategori = kategori.id_kategori";
        
        if ($keyword) {
            $keyword = $this->escape($keyword);
            $query .= " WHERE tanaman.nama_tanaman LIKE '%$keyword%' 
                        OR tanaman.sinonim LIKE '%$keyword%'";
        }
        
        $query .= " ORDER BY tanaman.id_tanaman DESC";
        return mysqli_query($this->conn, $query);
    }
}

if (isset($_POST['btn_simpan_tanaman'])) {
    $tanaman = new Tanaman();
    $hasil = $tanaman->tambah($_POST['nama_tanaman'], $_POST['sinonim'], $_POST['id_kategori']);

    if ($hasil === 'sukses') {
        header("Location: daftar_tanaman.php?pesan=sukses_tambah");
    } elseif ($hasil === 'duplikat') {
        header("Location: daftar_tanaman.php?pesan=duplikat");
    } else {
        header("Location: daftar_tanaman.php?pesan=gagal");
    }
    exit;

}

if (isset($_GET['action']) && $_GET['action'] === 'hapus') {
    $tanaman = new Tanaman();
    $id_tanaman = $tanaman->escape($_GET['id_tanaman']);
    
    if ($tanaman->hapus($id_tanaman)) {
        header("Location: daftar_tanaman.php?pesan=sukses_hapus");
    } else {
        header("Location: daftar_tanaman.php?pesan=gagal_hapus");
    }
    exit;
}

if (isset($_POST['btn_edit_tanaman'])) {
    $tanaman = new Tanaman();
    $id = $_POST['id_tanaman'];
    $nama = $_POST['nama_tanaman'];
    $sinonim = $_POST['sinonim'];
    $id_kategori = $_POST['id_kategori'];

    if ($tanaman->edit($id, $nama, $sinonim, $id_kategori)) {
        header("Location: daftar_tanaman.php?pesan=sukses_edit");
    } else {
        header("Location: daftar_tanaman.php?pesan=gagal_edit");
    }
    exit;
}
?>