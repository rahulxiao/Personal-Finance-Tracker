<?php
session_start();
require_once 'validate_register.php';
require_once '../model/user_model.php';

if (isset($_POST['submit'])) {
    $fname  = trim($_POST['firstname']);
    $lname  = trim($_POST['lastname']);
    $uname  = trim($_POST['username']);
    $email  = trim($_POST['email']);
    $pass   = trim($_POST['password']);
    $cpass  = trim($_POST['confirm-password']);
    $terms  = isset($_POST['terms']) ? true : false;

    $validationErrors = validateRegisterInput($fname, $lname, $uname, $email, $pass, $cpass, $terms);

    if (!empty($validationErrors)) {
        $_SESSION['register_errors'] = $validationErrors;
        $_SESSION['form_data'] = $_POST;
        header('Location: ../view/register.php');
        exit();
    }

    $user = [
        'firstname' => $fname,
        'lastname'  => $lname,
        'username'  => $uname,
        'email'     => $email,
        'password'  => $pass
    ];

    $result = register($user);

    if ($result === "exists") {
        $_SESSION['register_errors']['username'] = "Username or email already exists";
    } elseif ($result === "fail") {
        $_SESSION['register_errors']['database'] = "Registration failed. Please try again.";
    } else {
        $_SESSION['status'] = true;
        $_SESSION['username'] = $uname;
        header("Location: ../view/login.php");
        exit();
    }

    $_SESSION['form_data'] = $_POST;
    header('Location: ../view/register.php');
} else {
    $_SESSION['register_errors']['request'] = "Invalid request! Please submit the form.";
    header('Location: ../view/register.php?error=invalid_request');
}
