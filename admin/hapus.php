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
      $query = "DELETE FROM siswa WHERE id = $id";
      $redirect = "data-siswa.php";
      break;
    case 'jurusan':
      $query = "DELETE FROM jurusan WHERE id = $id";
      $redirect = "data-jurusan.php";
      break;
    case 'guru':
      $query = "DELETE FROM guru WHERE id = $id";
      $redirect = "data-guru.php";
      break;
    case 'kelas':
      $query = "DELETE FROM kelas WHERE id = $id";
      $redirect = "data-kelas.php";
      break;
    default:
      die("Tipe data tidak valid.");
  }

  if (mysqli_query($conn, $query)) {
    header("Location: $redirect");
  } else {
    echo "Gagal menghapus data: " . mysqli_error($conn);
  }
} else {
  echo "Parameter tidak lengkap.";
}
?>
