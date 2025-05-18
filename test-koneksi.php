<?php
include 'database.php';

$koneksi = $conn; 

if ($conn) {
    echo "";
} else {
    echo "Koneksi gagal!";
}
?>