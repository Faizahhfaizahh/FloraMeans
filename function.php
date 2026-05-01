<?php
include 'koneksi.php';
session_start();

$action   = mysqli_real_escape_string($conn, $_POST['action']); //Agar tidak kena SQL Injection
$username = mysqli_real_escape_string($conn, $_POST['username']); //Agar tidak kena SQL Injection
$password = $_POST['password'];

// ========LOGIN=======
if ($action === 'login') {
    $query = "SELECT * FROM user WHERE username = '$username'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        
        if ($password === $row['password']) {
            $_SESSION['id_user'] = $row['id_user'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['role'] = 'user'; //Menambahkan role
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'wrong_password']);
        }
    } else {
        echo json_encode(['status' => 'not_found']);
    }
}

// ========REGISTRASI=======
else if ($action === 'register') {
    $query_cek = "SELECT * FROM user WHERE username = '$username'";
    $result_cek = mysqli_query($conn, $query_cek);

    // Cek panjang password di server
    if (strlen($password) < 8) {
        echo json_encode(['status' => 'password_terlalu_pendek']);
        exit;
    }
    
    // Cek apakah mengandung angka (opsional tapi bagus)
    if (!preg_match('/[0-9]/', $password) || !preg_match('/[A-Za-z]/', $password)) {
        echo json_encode(['status' => 'password_tidak_valid']);
        exit;
    }

    if (mysqli_num_rows($result_cek) > 0){
        echo json_encode(['status' => 'username_terpakai']);
    } else {
        $password_safe = mysqli_real_escape_string($conn, $password);
        if (mysqli_query($conn, "INSERT  INTO user (username, password) VALUES ('$username', '$password_safe')")){
            echo json_encode(['status'=>'success']);
        } else {
            echo json_encode(['status' => 'error']);
        }
    }
}

// ========LOGIN ADMIN=======
else if ($action === 'loginAdmin') {
    $result = mysqli_query($conn, "SELECT * FROM admin WHERE username = '$username'");
    if ($row = mysqli_fetch_assoc($result)) {
        if ($password === $row['password']) {
            $_SESSION['id_admin'] = $row['id_admin'];
            $_SESSION['admin_username'] = $row['username'];
            $_SESSION['role'] = 'admin';
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'wrong_password']);
        }
    } else {
        echo json_encode(['status' => 'not_found']);
    }
}

//==========UPDATE PROFILE==========
else if ($action === 'updateProfile') {
    if (!isset($_SESSION['username'])){
        echo json_encode(['status' => 'not_logged_in']);
        exit;
    }
    $current_username = $_SESSION['username'];
    $new_username = mysqli_real_escape_string($conn, $_POST['username']);
    $new_password = $_POST['password'];
    //Cek apakah ganti password baru atau ganti username saja
    if (!empty($new_password)) {
        if (strlen($new_password) < 8 || !preg_match('/[0-9]/', $new_password) || !preg_match('/[A-Za-z]/', $new_password)) {
            echo json_encode(['status' => 'password_tidak_valid']);
            exit;
        }
        $query = "UPDATE user SET username='$new_username', password='$new_password' WHERE username='$current_username'";
    } else {
        $query = "UPDATE user SET username='$new_username' WHERE username='$current_username'";
    }

    if (mysqli_query($conn, $query)) {
        $_SESSION['username'] = $new_username; // Update session dengan username baru
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error']);
    }
}

?>