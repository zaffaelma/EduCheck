<?php
session_start();
include 'database.php';

$email = $_POST['email'];
$password = $_POST['password'];

// Cek admin
$admin = mysqli_query($koneksi, "SELECT * FROM admin WHERE email='$email' LIMIT 1");
if ($row = mysqli_fetch_assoc($admin)) {
    if ($row['password'] === $password) { // Jika sudah hash, gunakan password_verify()
        $_SESSION['email'] = $row['email'];
        $_SESSION['role'] = 'admin';
        $_SESSION['nama'] = $row['nama'];
        header('Location: admin/dashboard.php');
        exit;
    }
}

// Cek guru
$guru = mysqli_query($koneksi, "SELECT * FROM gurubk WHERE email='$email' LIMIT 1");
if ($row = mysqli_fetch_assoc($guru)) {
    if ($row['password'] === $password) {
        $_SESSION['email'] = $row['email'];
        $_SESSION['role'] = 'guru';
        $_SESSION['nama'] = $row['nama'];
        $_SESSION['id_gurubk'] = $row['Id_GuruBK'];
        header('Location: guru/dashboard.php');
        exit;
    }
}

// Cek siswa
$siswa = mysqli_query($koneksi, "SELECT * FROM siswa WHERE email='$email' LIMIT 1");
if ($row = mysqli_fetch_assoc($siswa)) {
    if ($row['password'] === $password) {
        $_SESSION['id_siswa'] = $row['Id_Siswa'];
        $_SESSION['email'] = $row['email'];
        $_SESSION['role'] = 'siswa';
        $_SESSION['nama'] = $row['nama'];
        header('Location: siswa/dashboard.php');
        exit;
    }
}

// Jika login gagal
header('Location: login.php?error=invalid_credentials');
exit;
?>