<?php
class Database {
    private $host = "localhost";
    private $user = "root";
    private $pass = "";
    private $db = "florameans_db";
    protected $conn;

    public function __construct(){
        $this->conn = mysqli_connect($this->host, $this->user, $this->pass, $this->db);

        if (!$this->conn){
            die("Koneksi database gagal: ".mysqli_connect_error());
        }
    }
    //Fungsi untuk mencegah SQL Injection
    public function escape($data) {
        return mysqli_real_escape_string($this->conn, $data);
    }
}
?>