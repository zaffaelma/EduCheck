<?php
session_start();
if (!isset($_SESSION['email']) || $_SESSION['role'] != 'siswa') {
    header("Location: login.php");
    exit;
}

// Ambil data dari form
$status = isset($_POST['status']) ? $_POST['status'] : null;

// Validasi input
if (!$status) {
    echo "Status absensi tidak valid.";
    exit;
}

// Simpan status absensi ke session
$_SESSION['absen_status'] = 'sudah';

// Redirect kembali ke dashboard
header("Location: dashboard.php");
exit;
?>