<?php
$con = mysqli_connect('127.0.0.1', 'root', '', 'finance');

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fname = $_POST['firstname'];
    $lname = $_POST['lastname'];
    $uname = $_POST['username'];
    $email = $_POST['email'];
    $pass = $_POST['password'];

    // Insert into signup table
    $sql1 = "INSERT INTO singup (u_fname, u_lname, u_username, u_email, u_password) 
             VALUES ('$fname', '$lname', '$uname', '$email', '$pass')";
    // Insert into login table
    $sql2 = "INSERT INTO login (uname, pass) 
             VALUES ('$uname', '$pass')";

    if (mysqli_query($con, $sql1) && mysqli_query($con, $sql2)) {
        echo "User registered successfully!";
    } else {
        echo "Error: " . mysqli_error($con);
    }
}

mysqli_close($con);
?>
