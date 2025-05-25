<?php
$koneksi = mysqli_connect("localhost", "root", "root", "db_educheck");

if (!$koneksi) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}
?>
