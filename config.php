<?php


ob_start(); // Mulai Output Buffering



define('DB_HOST', 'localhost');
define('DB_USER', 'root');       // Ganti sesuai username MySQL
define('DB_PASS', '');              
define('DB_NAME', 'simpkl_2'); 

$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);


mysqli_set_charset($conn, 'utf8mb4');
date_default_timezone_set('Asia/Jakarta');

// --- Helper functions ---

function clean($data) {
    global $conn;
    return mysqli_real_escape_string($conn, trim(htmlspecialchars($data)));
}

function redirect($url) {
    header("Location: $url");
    exit;
}

function setFlash($type, $msg) {
    if (session_status() === PHP_SESSION_NONE) session_start();
    $_SESSION['flash'] = ['type' => $type, 'msg' => $msg];
}

function getFlash() {
    if (isset($_SESSION['flash'])) {
        $f = $_SESSION['flash'];
        unset($_SESSION['flash']);
        $cls = $f['type'] === 'success' ? 'alert-success' : 'alert-error';
        $ico = $f['type'] === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle';
        echo "<div class='alert {$cls}'><i class='fas {$ico}'></i> {$f['msg']}</div>";
    }
}

// Cek apakah admin sudah login
function requireAdmin() {
    if (session_status() === PHP_SESSION_NONE) session_start();
    if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
        redirect('login.php');
    }
}

function catatLog($conn, $pesan) {
    // Mengambil ID dari array 'user' sesuai penggunaan di dashboard & user_aksi
    $id_user = $_SESSION['user']['id_users'] ?? 0; 
    
    // Pastikan kolom di query sesuai dengan struktur tabel log_aktivitas kamu
    // Berdasarkan log-aktivitas.php, kolomnya adalah 'id_users'
    $pesan_safe = mysqli_real_escape_string($conn, $pesan);
    $sql = "INSERT INTO log_aktivitas (id_users, aktivitas, waktu) VALUES ('$id_user', '$pesan_safe', NOW())";
    mysqli_query($conn, $sql);
}
?>
