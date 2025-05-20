<?php
session_start();
if (!isset($_SESSION['email']) || $_SESSION['role'] != 'guru') {
  header("Location: login.php");
  exit;
}

include '../test-koneksi.php';

$id = $_GET['id'] ?? null;
$aksi = $_GET['aksi'] ?? null;

if ($id && in_array($aksi, ['setuju', 'tolak'])) {
  $status = ($aksi == 'setuju') ? 'Disetujui' : 'Ditolak';

  $stmt = $conn->prepare("UPDATE absensi SET status_absensi = ? WHERE id_absensi = ?");
  $stmt->bind_param("si", $status, $id);

  if ($stmt->execute()) {
    $_SESSION['message'] = "Status persetujuan berhasil diperbarui.";
  } else {
    $_SESSION['message'] = "Gagal memperbarui status persetujuan.";
  }

  $stmt->close();
} else {
  $_SESSION['message'] = "Data tidak valid.";
}

header("Location: persetujuan-izin.php");
exit;
?>


//belom zaf