<?php
require_once '../model/user_model.php';

// Check if form is submitted properly
if (!isset($_POST['submit'])) {
    die("No data submitted");
}

// Sanitize input (basic level)
$fname = trim($_POST['firstname']);
$lname = trim($_POST['lastname']);
$uname = trim($_POST['username']);
$email = trim($_POST['email']);
$pass  = trim($_POST['password']);

// Validate required fields
if (empty($fname) || empty($lname) || empty($uname) || empty($email) || empty($pass)) {
    die("All fields are required.");
}

// Optional: Validate email format
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die("Invalid email format.");
}


// Build user array
$user = [
    'firstname' => $fname,
    'lastname'  => $lname,
    'username'  => $uname,
    'email'     => $email,
    'password'  => $hashedPassword
];

// Call model function
$result = addUser($user);

if ($result === "exists") {
    die("Username or email already exists.");
} elseif ($result === "success") {
    echo "User added successfully.";
} else {
    die("Failed to add user.");
}

?>