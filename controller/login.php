<?php
session_start();
require_once 'validate_login.php';
require_once '../model/user_model.php'; // <-- use the login() function here

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

    $user = ['username' => $username, 'password' => $password];

    if (login($user)) {
        $_SESSION['status'] = true;
        $_SESSION['username'] = $username;
        header('Location: ../view/features.php');
        exit();
    } else {
        $_SESSION['login_errors']['login'] = "Invalid username or password.";
        $_SESSION['form_data'] = $_POST;
        header('Location: ../view/login.php');
    }

} else {
    $_SESSION['login_errors']['login'] = "Invalid request! Please submit the form.";
    header('Location: ../view/login.php');
}
?>
