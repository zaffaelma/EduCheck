<?php
include '../database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $nis = $_POST['nis'] ?? '';
  $nama = $_POST['nama'] ?? '';
  $jk = $_POST['jenis_kelamin'] ?? '';
  $id_kelas = $_POST['id_kelas'] ?? '';
  $id_jurusan = $_POST['id_jurusan'] ?? '';
  $email = $_POST['email'] ?? '';
  $password = password_hash($_POST['password'] ?? '', PASSWORD_DEFAULT);

  $query = "INSERT INTO siswa (nis, nama, jenis_kelamin, Id_Kelas, Id_Jurusan, email, password)
            VALUES ('$nis', '$nama', '$jk', '$id_kelas', '$id_jurusan', '$email', '$password')";

  if (mysqli_query($koneksi, $query)) {
    header("Location: data-siswa.php?success=1");
    exit;
  } else {
    echo "Gagal menambahkan siswa: " . mysqli_error($koneksi);
  }
}
?>
