<?php
session_start();
require_once 'validate_login.php';
require_once '../model/user_model.php';

if (isset($_POST['submit'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $master_username = "admin";
    $master_password = "master123";

    $validationErrors = validateLoginInput($username, $password);

    if (!empty($validationErrors)) {
        $_SESSION['login_errors'] = $validationErrors;
        $_SESSION['form_data'] = $_POST;
        header('Location: ../view/login.php');
        exit();
    }

    if ($username === $master_username && $password === $master_password) {
        $_SESSION['status'] = true;
        $_SESSION['username'] = $username;
        $_SESSION['user_type'] = 'admin'; 
        header('Location: ../view/admin.php'); 
        exit();
    }

    $user = ['username' => $username, 'password' => $password];

    if (login($user)) {
        $_SESSION['status'] = true;
        $_SESSION['username'] = $username;
        $_SESSION['user_type'] = 'user'; 
        header('Location: ../view/features.php'); 
        exit();
    } else {
        $_SESSION['login_errors']['login'] = "Invalid username or password.";
        $_SESSION['form_data'] = $_POST;
        header('Location: ../view/login.php');
        exit();
    }

} else {
    $_SESSION['login_errors']['login'] = "Invalid request! Please submit the form.";
    header('Location: ../view/login.php');
    exit();
}
?>