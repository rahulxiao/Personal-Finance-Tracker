<?php

$con = mysqli_connect('127.0.0.1', 'root', '', 'WebTech');
if (!$con) {
    die('Connection failed: ' . mysqli_connect_error());
}

// Insert new income record if POST data is present
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['incomeSource'], $_POST['incomeAmount'], $_POST['incomeDate'])) {
    $incomeSource = mysqli_real_escape_string($con, $_POST['incomeSource']);
    $incomeAmount = floatval($_POST['incomeAmount']);
    $incomeDate = mysqli_real_escape_string($con, $_POST['incomeDate']);
    $sqlInsert = "INSERT INTO income (incomeSource, incomeAmount, incomeDate) VALUES ('$incomeSource', $incomeAmount, '$incomeDate')";
    if (!mysqli_query($con, $sqlInsert)) {
        die('Insert Error: ' . mysqli_error($con));
    }
    // Redirect to avoid form resubmission
    header('Location: ../view/Income.php');
    exit();
}

// Fetch all income records
$sql = "SELECT * FROM income ORDER BY incomeDate DESC";
$incomeResults = mysqli_query($con, $sql);

?>