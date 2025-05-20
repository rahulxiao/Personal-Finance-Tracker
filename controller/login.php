<?php
session_start();
require_once 'validate_login.php';

if (isset($_POST['submit'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $validationErrors = validateLoginInput($username, $password);

    if (!empty($validationErrors)) {
        $_SESSION['login_errors'] = $validationErrors;
        $_SESSION['form_data'] = $_POST;
        header('Location: ../view/login.php');
        exit();
    }

    $con = mysqli_connect('127.0.0.1', 'root', '', 'finance');
    if (!$con) {
        die("Database connection failed: " . mysqli_connect_error());
    }

    $sql = "SELECT * FROM login WHERE uname = '$username' AND pass = '$password'";
    $result = mysqli_query($con, $sql);

    if (mysqli_num_rows($result) === 1) {
        $_SESSION['status'] = true;
        $_SESSION['username'] = $username;
        header('Location: ../view/features.php');
        exit();
    } else {
        $_SESSION['login_errors']['login'] = "Invalid username or password.";
        $_SESSION['form_data'] = $_POST;
        header('Location: ../view/login.php');
    }

    mysqli_close($con);
} else {
    $_SESSION['login_errors']['login'] = "Invalid request! Please submit the form.";
    header('Location: ../view/login.php');
}
?>