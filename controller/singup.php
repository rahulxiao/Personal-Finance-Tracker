<?php
session_start();
require_once 'validate_register.php';

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

    $con = mysqli_connect('127.0.0.1', 'root', '', 'finance');
    if (!$con) {
        die("Database connection failed: " . mysqli_connect_error());
    }

    // Check if username or email already exists
    $checkSql = "SELECT * FROM singup WHERE u_username = '$uname' OR u_email = '$email'";
    $checkResult = mysqli_query($con, $checkSql);
    
    if (mysqli_num_rows($checkResult) > 0) {
        $_SESSION['register_errors']['username'] = "Username or email already exists";
        $_SESSION['form_data'] = $_POST;
        header('Location: ../view/register.php');
        exit();
    }

    // Insert user data using prepared statements
    $sql1 = "INSERT INTO singup (u_fname, u_lname, u_username, u_email, u_password)
             VALUES (?, ?, ?, ?, ?)";
             
    $sql2 = "INSERT INTO login (uname, pass)
             VALUES (?, ?)";

    $stmt1 = mysqli_prepare($con, $sql1);
    mysqli_stmt_bind_param($stmt1, "sssss", $fname, $lname, $uname, $email, $pass);
    
    $stmt2 = mysqli_prepare($con, $sql2);
    mysqli_stmt_bind_param($stmt2, "ss", $uname, $pass);

    if (mysqli_stmt_execute($stmt1) && mysqli_stmt_execute($stmt2)) {
        $_SESSION['status'] = true;
        $_SESSION['username'] = $uname;
        header("Location: ../view/features.php");
        exit();
    } else {
        $_SESSION['register_errors']['database'] = "Registration failed. Please try again.";
        $_SESSION['form_data'] = $_POST;
        header('Location: ../view/register.php');
    }

    mysqli_close($con);
} else {
    $_SESSION['register_errors']['request'] = "Invalid request! Please submit the form.";
    header('Location: ../view/register.php');
}
?>