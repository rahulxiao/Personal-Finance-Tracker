<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if ($username === "" || $password === "") {
        echo "Username and password cannot be empty.";
    } elseif ($username === $password) { 
        $_SESSION['status'] = true;
        header('Location: features.php');
        exit;
    } else {
        echo "Invalid username or password.";
    }
} else {
    echo "Invalid request. Please submit the login form.";
}
?>
