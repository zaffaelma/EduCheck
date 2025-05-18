<?php
session_start();
if (!isset($_SESSION['email']) || $_SESSION['role'] != 'siswa') {
    header("Location: login.php");
    exit;
}

include '../database.php';

$id_siswa = $_SESSION['id_siswa'];
$status = isset($_POST['status']) ? $_POST['status'] : null;
$tanggal = date('Y-m-d');
$bukti = null;

// Proses upload file jika sakit/izin
if (($status == 'sakit' || $status == 'izin') && isset($_FILES['file']) && $_FILES['file']['name'] != '') {
    $bukti = uniqid().'_'.$_FILES['file']['name'];
    move_uploaded_file($_FILES['file']['tmp_name'], "uploads/".$bukti);
}

// Cek apakah sudah absen hari ini
$cek = mysqli_query($conn, "SELECT * FROM absensi WHERE id_siswa='$id_siswa' AND tanggal_absensi='$tanggal'");
if (mysqli_num_rows($cek) > 0) {
    $_SESSION['absen_status'] = 'sudah';
    header("Location: dashboard.php");
    exit;
}

// Simpan ke database
$query = "INSERT INTO absensi (id_siswa, tanggal_absensi, keterangan_absensi, status_absensi, bukti_absensi)
          VALUES ('$id_siswa', '$tanggal', '$status', '$status', '$bukti')";
mysqli_query($conn, $query);

$_SESSION['absen_status'] = 'sudah';
header("Location: dashboard.php");
exit;
?>