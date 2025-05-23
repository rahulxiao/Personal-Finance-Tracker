<?php
require_once 'db.php';

function login($user) {
    $con = getConnection();
    $username = $user['username'];
    $password = $user['password'];

    $sql = "SELECT * FROM login WHERE uname = '$username' AND pass = '$password'";
    $result = mysqli_query($con, $sql);
    $count = mysqli_num_rows($result);

    mysqli_close($con);

    return $count === 1;
}

function register($user) {
    $con = getConnection();

    $fname = $user['firstname'];
    $lname = $user['lastname'];
    $uname = $user['username'];
    $email = $user['email'];
    $pass  = $user['password'];

    // Check if username or email already exists
    $checkSql = "SELECT * FROM singup WHERE u_username = '$uname' OR u_email = '$email'";
    $checkResult = mysqli_query($con, $checkSql);

    if (mysqli_num_rows($checkResult) > 0) {
        mysqli_close($con);
        return "exists"; // Username/email already exists
    }

    $sql1 = "INSERT INTO singup (u_fname, u_lname, u_username, u_email, u_password)
             VALUES ('$fname', '$lname', '$uname', '$email', '$pass')";

    $sql2 = "INSERT INTO login (uname, pass)
             VALUES ('$uname', '$pass')";

    $success1 = mysqli_query($con, $sql1);
    $success2 = mysqli_query($con, $sql2);

    mysqli_close($con);

    return ($success1 && $success2) ? "success" : "fail";
}
?>
