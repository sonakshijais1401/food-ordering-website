<?php
session_start();
if (!isset($_SESSION['admin'])) {
    $_SESSION['no-login-message'] = "Please log in to access Admin Panel";
    header("Location: login.php");
    exit();
}
?>
