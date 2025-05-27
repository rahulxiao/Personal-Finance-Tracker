<?php
// Database connection
$con = mysqli_connect('127.0.0.1', 'root', '', 'finance');
if (!$con) {
    die('Connection failed: ' . mysqli_connect_error());
}

// Include validation
require_once('savingsGoalsCheck.php');

// Add new savings goal
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['type']) && $_POST['type'] === 'savingsGoal') {
    $validationResult = validateSavingsGoal($_POST);
    
    if ($validationResult['success']) {
        $goalName = mysqli_real_escape_string($con, $_POST['goalName']);
        $targetAmount = floatval($_POST['targetAmount']);
        $currentAmount = floatval($_POST['currentAmount']);
        $targetDate = mysqli_real_escape_string($con, $_POST['targetDate']);
        $category = mysqli_real_escape_string($con, $_POST['category']);
        $monthlyContribution = floatval($_POST['monthlyContribution']);
        
        $sql = "INSERT INTO savingsgoals (sgId, sgName, sgTAmount, sgCAmount, sgDate, sgCategory, sgMonthlyContribution) 
                VALUES (NULL, '$goalName', '$targetAmount', '$currentAmount', '$targetDate', '$category', '$monthlyContribution')";
        
        if (mysqli_query($con, $sql)) {
            $newId = mysqli_insert_id($con);
            echo json_encode([
                'success' => true,
                'message' => 'Savings goal added successfully',
                'goal' => [
                    'id' => $newId,
                    'name' => $goalName,
                    'targetAmount' => $targetAmount,
                    'currentAmount' => $currentAmount,
                    'targetDate' => $targetDate,
                    'category' => $category,
                    'monthlyContribution' => $monthlyContribution
                ]
            ]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error adding savings goal: ' . mysqli_error($con)]);
        }
    } else {
        echo json_encode(['success' => false, 'errors' => $validationResult['errors']]);
    }
    exit();
}

// Fetch all savings goals
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['type']) && $_GET['type'] === 'savingsGoals') {
    $sql = "SELECT * FROM savingsgoals ORDER BY sgId DESC";
    $result = mysqli_query($con, $sql);
    
    if ($result === false) {
        echo json_encode(['error' => 'Database error: ' . mysqli_error($con)]);
        exit();
    }
    
    $goals = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $goals[] = [
            'id' => $row['sgId'],
            'name' => $row['sgName'],
            'targetAmount' => $row['sgTAmount'],
            'currentAmount' => $row['sgCAmount'],
            'targetDate' => $row['sgDate'],
            'category' => $row['sgCategory'],
            'monthlyContribution' => $row['sgMonthlyContribution']
        ];
    }
    
    echo json_encode($goals);
    exit();
}

// Delete savings goal
if ($_SERVER['REQUEST_METHOD'] === 'DELETE' && isset($_GET['type']) && $_GET['type'] === 'savingsGoal') {
    $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
    
    if ($id > 0) {
        $sql = "DELETE FROM savingsgoals WHERE sgId = $id";
        if (mysqli_query($con, $sql)) {
            echo json_encode(['success' => true, 'message' => 'Savings goal deleted successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error deleting savings goal: ' . mysqli_error($con)]);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid savings goal ID']);
    }
    exit();
}

mysqli_close($con);
?>
