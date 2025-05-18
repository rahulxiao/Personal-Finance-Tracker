<?php
session_start();

$con = mysqli_connect('127.0.0.1', 'root', '', 'finance');

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $uname = $_POST['username'];
    $pass = $_POST['password'];

    $sql = "SELECT * FROM login WHERE uname = '$uname' AND pass = '$pass'";
    $result = mysqli_query($con, $sql);

    if (mysqli_num_rows($result) == 1) {
        $_SESSION['username'] = $uname;
        header("Location: ../view/feature.php"); // make sure this path is correct!
        exit();
    } else {
        echo "Invalid username or password.";
    }
}

mysqli_close($con);
?>
