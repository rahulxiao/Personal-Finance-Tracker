<?php
session_start();

// If form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if ($username === '' || $password === '') {
        // Return to login page with error message
        header('Location: ../view/login.html?error=empty');
        exit;
    } else if ($username === $password) { // Simple validation logic - username equals password
        // Set session status to authenticate user
        $_SESSION['status'] = true;
        $_SESSION['username'] = $username;
        
        // Redirect to features page
        header('Location: ../view/features.php');
        exit;
    } else {
        // Return to login page with error message
        header('Location: ../view/login.html?error=invalid');
        exit;
    }
} else {
    // If someone tries to access this file directly without POST data
    header('Location: ../view/login.html');
    exit;
}
?>