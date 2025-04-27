<?php
session_start();

// Fungsi untuk membatasi akses berdasarkan peran
function restrict_access($allowed_roles) {
    if (!isset($_SESSION['role']) || !in_array($_SESSION['role'], $allowed_roles)) {
        header("Location:login.php");
    }
}
?>