<?php
// Letakkan ob_start di paling atas untuk mencegah error "Headers already sent"
ob_start();
session_start();
include "config.php";

// 1. Ambil data dari POST/GET
if (isset($_GET['hapus'])) {
    $id = clean($_GET['hapus']);
    
    // Ambil username untuk keperluan log
    $res = mysqli_query($conn, "SELECT username FROM users WHERE id_users = '$id'");
    $data = mysqli_fetch_assoc($res);
    $nama = $data['username'] ?? 'Unknown';

    // Soft Delete (is_deleted = 1)
    if (mysqli_query($conn, "UPDATE users SET is_deleted = 1 WHERE id_users = '$id'")) {
        catatLog($conn, "Menghapus user: $nama");
        setFlash('success', 'User berhasil dihapus.');
    }
    redirect('admin-users.php');
}

if (isset($_POST['simpan'])) {
    $id       = clean($_POST['id']);
    $username = clean($_POST['username']);
    $role     = clean($_POST['role']);
    $password = $_POST['password'];

    if ($id == "0") {
        // Tambah User Baru
        $query = "INSERT INTO users (username, password, role, is_deleted) VALUES ('$username', '$password', '$role', 0)";
        if (mysqli_query($conn, $query)) {
            catatLog($conn, "Menambah user baru: $username");
            setFlash('success', 'User baru ditambahkan.');
        }
    } else {
        // Edit User
        if (!empty($password)) {
            $query = "UPDATE users SET username='$username', role='$role', password='$password' WHERE id_users='$id'";
        } else {
            $query = "UPDATE users SET username='$username', role='$role' WHERE id_users='$id'";
        }
        
        if (mysqli_query($conn, $query)) {
            catatLog($conn, "Mengubah data user: $username");
            setFlash('success', 'Data user diperbarui.');
        }
    }
    redirect('admin-users.php');
}

// Kalau nyasar
header("Location: admin-users.php");
exit(); 