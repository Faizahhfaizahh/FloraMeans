 <?php
// session_start();

// // Menghapus semua variabel session
// $_SESSION = array();

// if (ini_get("session.use_cookies")) {
//     $params = session_get_cookie_params();
//     setcookie(session_name(), '', time() - 42000,
//         $params["path"], $params["domain"],
//         $params["secure"], $params["httponly"]
//     );
// }

// session_destroy();

// header("Location: login.php");
// exit;


session_start();
$role = isset($_SESSION['role']) ? $_SESSION['role'] : 'user';


$_SESSION = array();

if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

session_destroy();

if ($role === 'admin') {
    header("Location: admin_login.php?pesan=logout_berhasil");
} else {
    header("Location: login.php?pesan=logout_berhasil");
}
exit;

?> 