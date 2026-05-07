<?php
require_once 'database.php'; //Mengambil atau membaca file/isi file database.php

class Kategori extends Database {
    public function __construct(){
        parent::__construct();
    }

    // Function untuk menampilkan semua kategori yang ada
    public function tampilSemua(){
        $query = "SELECT * FROM kategori";
        return mysqli_query($this->conn, $query);
    }

    //Fuction untuk menambah kategori baru
    public function tambah($nama_kategori){
        $nama_kategori = $this->escape($nama_kategori);

        //Mengecek apakah kategori sudah ada
        $cek = mysqli_query($this->conn, "SELECT * FROM kategori WHERE nama_kategori = '$nama_kategori'");
        if (mysqli_num_rows($cek) > 0){
            return "duplikat";
        }

        $query = "INSERT INTO kategori (nama_kategori) VALUES ('$nama_kategori')";
        if (mysqli_query($this->conn, $query)){
            return "sukses";
        } else {
            return "gagal";
        }
    }

    public function hapus($id_kategori){
        $id_kategori = $this->escape($id_kategori);
        $query = "DELETE FROM kategori WHERE id_kategori = '$id_kategori'";
        return mysqli_query($this->conn, $query);
    }

    public function ambilData ($id_kategori){
        $id_kategori = $this->escape($id_kategori);
        $query = "SELECT * FROM kategori WHERE id_kategori = '$id_kategori'";
        $result = mysqli_query($this->conn, $query);
        return mysqli_fetch_assoc($result);
    }

    public function edit($id_kategori, $nama_kategori){
        $id_kategori = $this->escape($id_kategori);
        $nama_kategori = $this->escape($nama_kategori);

        $query = "UPDATE kategori SET nama_kategori = '$nama_kategori' WHERE id_kategori = '$id_kategori'";
        return mysqli_query($this->conn, $query);
    }
}

if (isset($_POST['btn_simpan_kategori'])) {
    $kat = new Kategori();
    $hasil = $kat->tambah($_POST['nama_kategori']);

    if ($hasil === 'sukses') {
        header("Location: kelola_kategori.php?pesan=sukses_tambah");
    } elseif ($hasil === 'duplikat') {
        header("Location: kelola_kategori.php?pesan=duplikat");
    } else {
        header("Location: kelola_kategori.php?pesan=gagal");
    }
    exit;

}

if (isset($_GET['action']) && $_GET['action'] === 'hapus') {
    $kat = new Kategori();
    $id_kategori = $kat->escape($_GET['id_kategori']);
    
    if ($kat->hapus($id_kategori)) {
        header("Location: kelola_kategori.php?pesan=sukses_hapus");
    } else {
        header("Location: kelola_kategori.php?pesan=gagal_hapus");
    }
    exit;
}

if (isset($_POST['btn_edit_kategori'])) {
    $kat = new Kategori();
    $id = $_POST['id_kategori'];
    $nama = $_POST['nama_kategori'];

    if ($kat->edit($id, $nama)) {
        header("Location: kelola_kategori.php?pesan=sukses_edit");
    } else {
        header("Location: kelola_kategori.php?pesan=gagal_edit");
    }
    exit;
}
?>