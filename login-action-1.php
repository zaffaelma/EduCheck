<?php
// start session
session_start();

if ($_POST['email'] == 'zaffa@gmail.com' && $_POST['password']== 'zaffa'){
    $_SESSION['email'] = $_POST['email'];
    header('Location:admin/dashboard.php');
} else {
    header('Location:login.php');
}