<?php
session_start();

// Data untuk authentikasi user
$users = [
    'admin' => ['email' => 'admin@gmail.com', 'password' => 'admin', 'role' => 'admin'],
    'guru' => ['email' => 'guru@gmail.com', 'password' => 'guru', 'role' => 'guru'],
    'siswa' => ['email' => 'siswa@gmail.com', 'password' => 'siswa', 'role' => 'siswa'],
];

// Mengambil input dari form login
$email = $_POST['email'];
$password = $_POST['password'];

// Memeriksa kredensial pengguna
foreach ($users as $user) {
    if ($user['email'] === $email && $user['password'] === $password) {
        $_SESSION['email'] = $email;
        $_SESSION['role'] = $user['role'];

        // Redirect berdasarkan role
        if ($user['role'] === 'admin') {
            header('Location:admin/dashboard.php');
            exit; // Hentikan eksekusi setelah redirect
        } elseif ($user['role'] === 'guru') {
            header('Location:guru/dashboard.php');
            exit;
        } elseif ($user['role'] === 'siswa') {
            header('Location:siswa/dashboard.php');
            exit;
        }
    }
}

// Jika login gagal
header('Location: login.php?error=invalid_credentials');
exit;
?>