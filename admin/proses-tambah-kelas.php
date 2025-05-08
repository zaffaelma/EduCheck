<?php
session_start();

include '../database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_kelas = $_POST['nama'];
    $jurusan_id = $_POST['jurusan'];

    if (!empty($nama_kelas) && !empty($jurusan_id)) {
        $query = "INSERT INTO kelas (nama_kelas, jurusan_id) VALUES (?, ?)";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, 'si', $nama_kelas, $jurusan_id);

        if (mysqli_stmt_execute($stmt)) {
            header("Location: data-kelas.php?success=1");
            exit;
        } else {
            echo "Gagal menambahkan kelas: " . mysqli_error($conn);
        }
    } else {
        echo "Nama kelas dan jurusan harus diisi.";
    }
} else {
    // Tambahkan ini agar tidak muncul output aneh
    header("Location: data-kelas.php");
    exit;
}
