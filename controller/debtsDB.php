<?php
// Database connection
$con = mysqli_connect('127.0.0.1', 'root', '', 'finance');
if (!$con) {
    die('Connection failed: ' . mysqli_connect_error());
}

// Include validation
require_once('debtsCheck.php');

// Add new debt
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['type']) && $_POST['type'] === 'debt') {
    $validationResult = validateDebt($_POST);
    
    if ($validationResult['success']) {
        $debtSource = mysqli_real_escape_string($con, $_POST['debtSource']);
        $loanAmount = floatval($_POST['loanAmount']);
        $interestRate = floatval($_POST['interestRate']);
        $monthlyPayment = floatval($_POST['monthlyPayment']);
        
        $sql = "INSERT INTO debts (dId, dSource, dAmount, dInterest, dMonthlyPayment) 
                VALUES (NULL, '$debtSource', '$loanAmount', '$interestRate', '$monthlyPayment')";
        
        if (mysqli_query($con, $sql)) {
            $newId = mysqli_insert_id($con);
            echo json_encode([
                'success' => true,
                'message' => 'Debt added successfully',
                'debt' => [
                    'id' => $newId,
                    'source' => $debtSource,
                    'amount' => $loanAmount,
                    'interest' => $interestRate,
                    'monthlyPayment' => $monthlyPayment
                ]
            ]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error adding debt: ' . mysqli_error($con)]);
        }
    } else {
        echo json_encode(['success' => false, 'errors' => $validationResult['errors']]);
    }
    exit();
}

// Fetch all debts
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['type']) && $_GET['type'] === 'debts') {
    $sql = "SELECT * FROM debts ORDER BY dId DESC";
    $result = mysqli_query($con, $sql);
    
    if ($result === false) {
        echo json_encode(['error' => 'Database error: ' . mysqli_error($con)]);
        exit();
    }
    
    $debts = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $debts[] = [
            'id' => $row['dId'],
            'source' => $row['dSource'],
            'amount' => $row['dAmount'],
            'interest' => $row['dInterest'],
            'monthlyPayment' => $row['dMonthlyPayment']
        ];
    }
    
    echo json_encode($debts);
    exit();
}

// Delete debt
if ($_SERVER['REQUEST_METHOD'] === 'DELETE' && isset($_GET['type']) && $_GET['type'] === 'debt') {
    $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
    
    if ($id > 0) {
        $sql = "DELETE FROM debts WHERE dId = $id";
        if (mysqli_query($con, $sql)) {
            echo json_encode(['success' => true, 'message' => 'Debt deleted successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error deleting debt: ' . mysqli_error($con)]);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid debt ID']);
    }
    exit();
}

mysqli_close($con);
?>
