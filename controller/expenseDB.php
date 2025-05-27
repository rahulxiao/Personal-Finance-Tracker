<?php
// Database connection
$con = mysqli_connect('127.0.0.1', 'root', '', 'finance');
if (!$con) {
    die('Connection failed: ' . mysqli_connect_error());
}

// Include validation
require_once('expenseCheck.php');

// ==========================================
// EXPENSE CATEGORIES OPERATIONS
// ==========================================

// Fetch all expense categories
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['type']) && $_GET['type'] === 'categories') {
    $sql = "SELECT * FROM expensecategories ORDER BY exCategory ASC";
    $result = mysqli_query($con, $sql);
    
    $categories = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $categories[] = [
            'id' => $row['excId'],
            'name' => $row['exCategory'],
            'budget' => $row['excBudget']
        ];
    }
    
    echo json_encode($categories);
    exit();
}

// Add new expense category
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['type']) && $_POST['type'] === 'category') {
    $categoryName = mysqli_real_escape_string($con, $_POST['categoryName']);
    $budget = floatval($_POST['categoryLimit']);
    
    // Check if category already exists
    $checkSql = "SELECT excId FROM expensecategories WHERE exCategory = '$categoryName'";
    $checkResult = mysqli_query($con, $checkSql);
    
    if (mysqli_num_rows($checkResult) > 0) {
        echo json_encode(['success' => false, 'message' => 'Category already exists']);
        exit();
    }
    
    $sql = "INSERT INTO expensecategories (excId, exCategory, excBudget) VALUES (NULL, '$categoryName', '$budget')";
    
    if (mysqli_query($con, $sql)) {
        $newId = mysqli_insert_id($con);
        echo json_encode([
            'success' => true,
            'message' => 'Category added successfully',
            'category' => [
                'id' => $newId,
                'name' => $categoryName,
                'budget' => $budget
            ]
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error adding category: ' . mysqli_error($con)]);
    }
    exit();
}

// ==========================================
// EXPENSE OPERATIONS
// ==========================================

// Add new expense
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['type']) && $_POST['type'] === 'expense') {
    $validationResult = validateExpense($_POST);
    
    if ($validationResult['success']) {
        $amount = floatval($_POST['expenseAmount']);
        $categoryId = intval($_POST['category']); // This should be the category ID from the select
        $description = mysqli_real_escape_string($con, $_POST['description']);
        $date = mysqli_real_escape_string($con, $_POST['expenseDate']);
        
        $sql = "INSERT INTO expense (exId, exAmount, exCategory, exDesc, exDate, exCreatedAt) 
                VALUES (NULL, '$amount', '$categoryId', '$description', '$date', current_timestamp())";
        
        if (mysqli_query($con, $sql)) {
            $newId = mysqli_insert_id($con);
            
            // Fetch the category name for the response
            $catSql = "SELECT exCategory FROM expensecategories WHERE excId = '$categoryId'";
            $catResult = mysqli_query($con, $catSql);
            $category = mysqli_fetch_assoc($catResult);
            
            echo json_encode([
                'success' => true,
                'message' => 'Expense added successfully',
                'expense' => [
                    'id' => $newId,
                    'amount' => $amount,
                    'category' => $category['exCategory'],
                    'description' => $description,
                    'date' => $date
                ]
            ]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error adding expense: ' . mysqli_error($con)]);
        }
    } else {
        echo json_encode(['success' => false, 'errors' => $validationResult['errors']]);
    }
    exit();
}

// Fetch all expenses with category names
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['type']) && $_GET['type'] === 'expenses') {
    $sql = "SELECT e.*, ec.exCategory as categoryName 
            FROM expense e 
            JOIN expensecategories ec ON e.exCategory = ec.excId 
            ORDER BY e.exDate DESC";
    
    $result = mysqli_query($con, $sql);
    
    $expenses = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $expenses[] = [
            'id' => $row['exId'],
            'amount' => $row['exAmount'],
            'category' => $row['categoryName'],
            'description' => $row['exDesc'],
            'date' => $row['exDate'],
            'createdAt' => $row['exCreatedAt']
        ];
    }
    
    echo json_encode($expenses);
    exit();
}

// Delete expense
if ($_SERVER['REQUEST_METHOD'] === 'DELETE' && isset($_GET['type']) && $_GET['type'] === 'expense') {
    $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
    
    if ($id > 0) {
        $sql = "DELETE FROM expense WHERE exId = $id";
        if (mysqli_query($con, $sql)) {
            echo json_encode(['success' => true, 'message' => 'Expense deleted successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error deleting expense: ' . mysqli_error($con)]);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid expense ID']);
    }
    exit();
}

mysqli_close($con);
?>
