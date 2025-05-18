<?php
$con = mysqli_connect('127.0.0.1', 'root', '', 'WebTech');
if (!$con) {
    die('Connection failed: ' . mysqli_connect_error());
}

// Insert new recurring income record if POST data is present
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['recurringSource'], $_POST['recurringAmount'], $_POST['recurringDate'])) {
    $recurringSource = mysqli_real_escape_string($con, $_POST['recurringSource']);
    $recurringAmount = floatval($_POST['recurringAmount']);
    $recurringDate = mysqli_real_escape_string($con, $_POST['recurringDate']);
    $sqlInsert = "INSERT INTO recurring_income (recurringSource, recurringAmount, recurringDate) VALUES ('$recurringSource', $recurringAmount, '$recurringDate')";
    if (!mysqli_query($con, $sqlInsert)) {
        die('Insert Error: ' . mysqli_error($con));
    }
    // Redirect to avoid form resubmission
    header('Location: ../view/Income.php');
    exit();
}

// Fetch all recurring income records
$sql = "SELECT * FROM recurring_income ORDER BY recurringDate DESC";
$recurringIncomeResults = mysqli_query($con, $sql);
?> 