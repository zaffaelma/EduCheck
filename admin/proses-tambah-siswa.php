<?php
include '../database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  echo "<pre>";
  print_r($_POST); // ← untuk debugging
  echo "</pre>";

  $nis = $_POST['nis'] ?? '';
  $nama = $_POST['nama'] ?? '';
  $jk = $_POST['jenis_kelamin'] ?? '';
  $kelas_id = $_POST['kelas_id'] ?? '';
  $jurusan_id = $_POST['jurusan_id'] ?? '';
  $email = $_POST['email'] ?? '';
  $password = password_hash($_POST['password'] ?? '', PASSWORD_DEFAULT);

  $query = "INSERT INTO siswa (nis, nama_siswa, jenis_kelamin, kelas_id, jurusan_id, email, password)
            VALUES ('$nis', '$nama', '$jk', '$kelas_id', '$jurusan_id', '$email', '$password')";

  if (mysqli_query($conn, $query)) {
    header("Location: data-siswa.php?success=1");
    exit;
  } else {
    echo "Gagal menambahkan siswa: " . mysqli_error($conn);
  }
}
?>
