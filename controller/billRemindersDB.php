<?php
// Database connection
$con = mysqli_connect('127.0.0.1', 'root', '', 'finance');
if (!$con) {
    die('Connection failed: ' . mysqli_connect_error());
}

// Include validation
require_once('billRemindersCheck.php');

// Add new bill reminder
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['type']) && $_POST['type'] === 'bill') {
    $validationResult = validateBillReminder($_POST);
    
    if ($validationResult['success']) {
        $billName = mysqli_real_escape_string($con, $_POST['billName']);
        $amount = floatval($_POST['billAmount']);
        $dueDate = mysqli_real_escape_string($con, $_POST['dueDate']);
        $category = mysqli_real_escape_string($con, $_POST['billCategory']);
        
        $sql = "INSERT INTO billreminders (bId, bName, bAmount, bDate, bCategories) 
                VALUES (NULL, '$billName', '$amount', '$dueDate', '$category')";
        
        if (mysqli_query($con, $sql)) {
            $newId = mysqli_insert_id($con);
            echo json_encode([
                'success' => true,
                'message' => 'Bill reminder added successfully',
                'bill' => [
                    'id' => $newId,
                    'name' => $billName,
                    'amount' => $amount,
                    'dueDate' => $dueDate,
                    'category' => $category
                ]
            ]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error adding bill reminder: ' . mysqli_error($con)]);
        }
    } else {
        echo json_encode(['success' => false, 'errors' => $validationResult['errors']]);
    }
    exit();
}

// Fetch all bill reminders
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['type']) && $_GET['type'] === 'bills') {
    $sql = "SELECT * FROM billreminders ORDER BY bDate DESC";
    $result = mysqli_query($con, $sql);
    
    if ($result === false) {
        echo json_encode(['error' => 'Database error: ' . mysqli_error($con)]);
        exit();
    }
    
    $bills = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $bills[] = [
            'id' => $row['bId'],
            'name' => $row['bName'],
            'amount' => $row['bAmount'],
            'dueDate' => $row['bDate'],
            'category' => $row['bCategories']
        ];
    }
    
    echo json_encode($bills);
    exit();
}

// Delete bill reminder
if ($_SERVER['REQUEST_METHOD'] === 'DELETE' && isset($_GET['type']) && $_GET['type'] === 'bill') {
    $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
    
    if ($id > 0) {
        $sql = "DELETE FROM billreminders WHERE bId = $id";
        if (mysqli_query($con, $sql)) {
            echo json_encode(['success' => true, 'message' => 'Bill reminder deleted successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error deleting bill reminder: ' . mysqli_error($con)]);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid bill ID']);
    }
    exit();
}

mysqli_close($con);
?>
