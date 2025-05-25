<?php
session_start();
if (!isset($_SESSION['email']) || $_SESSION['role'] != 'admin') {
  header("Location: login.php");
  exit;
}

include '../database.php';

$nama = $_POST['nama'];
$jenis_kelamin = $_POST['jenis_kelamin'];
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash password

// Jika Id_User ingin diisi otomatis, misal default 2:
$id_user = 2;

$query = "INSERT INTO gurubk (Id_User, nama, jenis_kelamin, email, password) 
          VALUES ('$id_user', '$nama', '$jenis_kelamin', '$email', '$password')";

if (mysqli_query($koneksi, $query)) {
  header("Location: data-guru.php?status=sukses");
  exit;
} else {
  echo "Gagal menambahkan guru: " . mysqli_error($koneksi);
}
?>
