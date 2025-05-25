<?php
session_start();
include '../database.php';

if (!isset($_SESSION['email']) || $_SESSION['role'] != 'admin') {
  header("Location: login.php");
  exit;
}

if (isset($_GET['id']) && isset($_GET['type'])) {
  $id = intval($_GET['id']);
  $type = $_GET['type'];

  switch ($type) {
    case 'siswa':
      $query = "DELETE FROM siswa WHERE Id_Siswa = $id";
      $redirect = "data-siswa.php";
      break;
    case 'jurusan':
      $cek_kelas = mysqli_query($koneksi, "SELECT 1 FROM kelas WHERE Id_Jurusan = $id LIMIT 1");
      if (mysqli_num_rows($cek_kelas) > 0) {
        echo "Gagal menghapus data: Masih ada kelas yang menggunakan jurusan ini. Hapus dulu kelas terkait!";
        exit;
      }
      $query = "DELETE FROM jurusan WHERE Id_Jurusan = $id";
      $redirect = "data-jurusan.php";
      break;
    case 'guru':
      $query = "DELETE FROM gurubk WHERE Id_GuruBK = '$id'";
      $redirect = "data-guru.php?msg=delete-success";
      break;
    case 'kelas':
      $query = "DELETE FROM kelas WHERE Id_Kelas = $id";
      $redirect = "data-kelas.php";
      break;
    default:
      die("Tipe data tidak valid.");
  }

  if (mysqli_query($koneksi, $query)) {
    header("Location: $redirect");
  } else {
    echo "Gagal menghapus data: " . mysqli_error($koneksi);
  }
} else {
  echo "Parameter tidak lengkap.";
}
?>
