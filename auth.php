<?php
if (session_status() === PHP_SESSION_NONE){
    session_start();
}
require_once 'database.php';

class Auth extends Database{
    public function __construct(){
        parent::__construct();
    }

    public static function cekLoginAdmin() {
        if (!isset($_SESSION['id_admin']) || $_SESSION['role'] !== 'admin') {
            header("Location: login_admin.php");
            exit();
        }
    }
    
    public function loginAdmin($username, $password) {
        $username = $this->escape($username); //Membersihkan input dari karakter aneh agar db tidak rusak
        
        $query = "SELECT * FROM admin WHERE username = '$username'";
        $result = mysqli_query($this->conn, $query);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            
            if (md5($password) === $row['password']) {
                $_SESSION['id_admin'] = $row['id_admin'];
                $_SESSION['admin_username'] = $row['username'];
                $_SESSION['role'] = 'admin';
                return 'success';
            } else {
                return 'wrong_password';
            }
        } else {
            return 'not_found';
        }
    }

    public function registerUser($username, $password){
        $username = $this->escape($username); //Membersihkan input dari karakter aneh agar db tidak rusak

        $cek = mysqli_query($this->conn, "SELECT * FROM user WHERE username = '$username'");
        if (mysqli_num_rows($cek) > 0){
            return 'username_terpakai';
        }

        $password_md5 = md5($password);
        $query = "INSERT INTO user (username, password) VALUES ('$username', '$password_md5')";

        if (mysqli_query($this->conn, $query)){
            return 'success';
        } else {
            return 'error';
        }
    }

    public static function cekLoginUser() {
        if (!isset($_SESSION['id_user']) || $_SESSION['role'] !== 'user') {
            header("Location: login.php");
            exit();
        }
    }

    public function loginUser($username, $password) {
        $username = $this->escape($username); //Membersihkan input dari karakter aneh agar db tidak rusak
        
        $query = "SELECT * FROM user WHERE username = '$username'";
        $result = mysqli_query($this->conn, $query);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            
            if (md5($password) === $row['password']) {
                $_SESSION['id_user'] = $row['id_user'];
                $_SESSION['user_username'] = $row['username'];
                $_SESSION['role'] = 'user';
                return 'success';
            } else {
                return 'wrong_password';
            }
        } else {
            return 'not_found';
        }
    }

}

if (isset($_POST['action'])) {
    $auth = new Auth();
    $action = $_POST['action'];

    if ($action === 'loginAdmin') { 
        echo json_encode(['status' => $auth->loginAdmin($_POST['username'], $_POST['password'])]);
        exit;
    }

    if ($action === 'register'){
        $result = $auth->registerUser($_POST['username'], $_POST['password']);
        echo json_encode(['status' => $result]);
        exit;
    }

    if ($action === 'loginUser') {
        echo json_encode(['status' => $auth->loginUser($_POST['username'], $_POST['password'])]);
        exit;
    }
}
?>