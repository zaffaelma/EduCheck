<?php
$host = "localhost"; 
$user = "root";      
$pass = "";          
$db   = "db_educheck";  

// Membuat koneksi
$conn = mysqli_connect($host, $user, $pass, $db);

// Cek koneksi
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

