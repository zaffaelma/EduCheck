<?php
include '../test-koneksi.php';

$id = $_GET['id'];
$aksi = $_GET['aksi'];

if ($aksi == 'setuju') {
  $status = 'Disetujui';
} elseif ($aksi == 'tolak') {
  $status = 'Ditolak';
} else {
  header("Location: persetujuan-izin.php");
  exit;
}

mysqli_query($koneksi, "UPDATE absensi SET status_absensi='$status' WHERE id_absensi='$id'");
header("Location: persetujuan-izin.php");
exit;
?>
