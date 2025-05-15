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
$jurusan = $_POST['jurusan'];

$query = "INSERT INTO guru (nama, jenis_kelamin, email, password, jurusan) 
          VALUES ('$nama', '$jenis_kelamin', '$email', '$password', '$jurusan')";

if (mysqli_query($conn, $query)) {
  header("Location: data-guru.php?status=sukses");
} else {
  echo "Gagal menambahkan guru: " . mysqli_error($conn);
}
?>
