<?php
require_once 'auth.php';
require_once 'dashboard_controller.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Tentukan $id_user berdasarkan role
$id_user = null;

if (isset($_SESSION['role'])) {
    if ($_SESSION['role'] === 'admin') {
        $id_user = null;
    } elseif ($_SESSION['role'] === 'user') {
        if (!isset($_SESSION['id_user'])) {
            echo json_encode(['error' => 'User tidak ditemukan di session']);
            exit;
        }
        $id_user = $_SESSION['id_user'];
    } else {
        echo json_encode(['error' => 'Role tidak dikenali']);
        exit;
    }
} else {
    echo json_encode(['error' => 'Silakan login terlebih dahulu']);
    exit;
}

// Ambil parameter nama_tanaman
$nama_tanaman = isset($_GET['nama_tanaman']) ? trim($_GET['nama_tanaman']) : '';
if (empty($nama_tanaman)) {
    echo json_encode(['error' => 'Nama tanaman tidak boleh kosong']);
    exit;
}

// Ambil data tren
$dashboard = new Dashboard();
$data = $dashboard->getTrenSensorTanaman($id_user, $nama_tanaman);

header('Content-Type: application/json');
echo json_encode($data);
exit;