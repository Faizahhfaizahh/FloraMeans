<?php
require_once 'auth.php';

class Profil extends Database {
    
    public function __construct(){
        parent::__construct(); // Memanggil constructor kelas Database untuk mengaktifkan koneksi
    }

    public function handleRequest() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $action = isset($_POST['action']) ? $_POST['action'] : '';

            if ($action === 'updateProfile') {
                $this->updateProfile();
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Aksi tidak valid.']);
            }
        }
    }

    public function getProfileUsername() {
        $role = isset($_SESSION['role']) ? $_SESSION['role'] : '';
        if ($role === 'admin') {
            return isset($_SESSION['admin_username']) ? $_SESSION['admin_username'] : '';
        } elseif ($role === 'user') {
            return isset($_SESSION['user_username']) ? $_SESSION['user_username'] : '';
        }
        return '';
    }

    private function updateProfile() {
        // Mengecek role
        $role = isset($_POST['role_form']) ? $_POST['role_form'] : '';
        
        if ($role === 'admin') {
            $current_username = $_SESSION['admin_username'];
            $id_kolom = 'id_admin';
            $id_value = $_SESSION['id_admin'];
            $tabel = 'admin';
            $session_key = 'admin_username';
        } elseif ($role === 'user') {
            $current_username = $_SESSION['user_username'];
            $id_kolom = 'id_user';
            $id_value = $_SESSION['id_user'];
            $tabel = 'user';
            $session_key = 'user_username';
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Sesi tidak valid, silakan login kembali.']);
            return;
        }

        // Mengambil dan bersihkan data inputan
        $new_username = $this->escape(trim($_POST['username']));
        $new_password = $_POST['password'];

        if (empty($new_username)) {
            echo json_encode(['status' => 'error', 'message' => 'Username tidak boleh kosong.']);
            return;
        }

        // Cek duplikasi username (jika username diubah)
        if ($new_username !== $current_username) {
            $cek = mysqli_query($this->conn, "SELECT * FROM $tabel WHERE username = '$new_username' AND $id_kolom != '$id_value'");
            if (mysqli_num_rows($cek) > 0) {
                echo json_encode(['status' => 'error', 'message' => 'Username sudah digunakan oleh akun lain.']);
                return;
            }
        }

        // Logika Update ke Database
        if (!empty($new_password)) {
            $password_md5 = md5($new_password);
            $query = "UPDATE $tabel SET username = '$new_username', password = '$password_md5' WHERE $id_kolom = '$id_value'";
        } else {
            $query = "UPDATE $tabel SET username = '$new_username' WHERE $id_kolom = '$id_value'";
        }

        if (mysqli_query($this->conn, $query)) {
            $_SESSION[$session_key] = $new_username;
            echo json_encode(['status' => 'success', 'message' => 'Profil berhasil diperbarui.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Gagal memperbarui database.']);
        }
    }
}

if (isset($_POST['action']) && $_POST['action'] === 'updateProfile') {
    $profil = new Profil();
    $profil->handleRequest();
    exit;
}
?>