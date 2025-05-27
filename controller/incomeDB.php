<?php
// Database connection
$con = mysqli_connect('127.0.0.1', 'root', '', 'finance');
if (!$con) {
    die('Connection failed: ' . mysqli_connect_error());
}

// Include validation
require_once('incomeCheck.php');

// ==========================================
// PAYCHECK TABLE OPERATIONS
// ==========================================

// Insert new paycheck record
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['type']) && $_POST['type'] === 'paycheck') {
    $validationResult = validateIncome($_POST);
    
    if ($validationResult['success']) {
        $pSource = mysqli_real_escape_string($con, $_POST['incomeSource']);
        $pAmount = floatval($_POST['incomeAmount']);
        $pDate = mysqli_real_escape_string($con, $_POST['incomeDate']);
        
        $sqlInsert = "INSERT INTO `paycheck` (`pId`, `pSource`, `pAmount`, `pDate`) VALUES (NULL, '$pSource', '$pAmount', '$pDate')";
        
        if (!mysqli_query($con, $sqlInsert)) {
            echo json_encode(['success' => false, 'message' => 'Error inserting paycheck: ' . mysqli_error($con)]);
            exit();
        }
        
        echo json_encode(['success' => true, 'message' => 'Paycheck added successfully']);
        exit();
    } else {
        echo json_encode(['success' => false, 'errors' => $validationResult['errors']]);
        exit();
    }
}

// Fetch paycheck records
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['type']) && $_GET['type'] === 'paycheck') {
    $sql = "SELECT * FROM paycheck ORDER BY pDate DESC";
    $result = mysqli_query($con, $sql);
    
    $incomes = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $incomes[] = [
            'id' => $row['pId'],
            'source' => $row['pSource'],
            'amount' => $row['pAmount'],
            'date' => $row['pDate']
        ];
    }
    
    echo json_encode($incomes);
    exit();
}

// Delete paycheck record
if ($_SERVER['REQUEST_METHOD'] === 'DELETE' && isset($_GET['type']) && $_GET['type'] === 'paycheck') {
    $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
    if ($id > 0) {
        $sql = "DELETE FROM paycheck WHERE pId = $id";
        if (mysqli_query($con, $sql)) {
            echo json_encode(['success' => true, 'message' => 'Paycheck deleted successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error deleting paycheck']);
        }
        exit();
    }
}

// ==========================================
// RECURRING INCOME TABLE OPERATIONS
// ==========================================

// Insert new recurring income record
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['type']) && $_POST['type'] === 'recurring') {
    $validationResult = validateIncome($_POST);
    
    if ($validationResult['success']) {
        $recSource = mysqli_real_escape_string($con, $_POST['incomeSource']);
        $recAmount = floatval($_POST['incomeAmount']);
        $recDate = mysqli_real_escape_string($con, $_POST['incomeDate']);
        
        $sqlInsert = "INSERT INTO `recurringincome` (`recId`, `recSource`, `recAmount`, `recDate`) VALUES (NULL, '$recSource', '$recAmount', '$recDate')";
        
        if (!mysqli_query($con, $sqlInsert)) {
            echo json_encode(['success' => false, 'message' => 'Error inserting recurring income: ' . mysqli_error($con)]);
            exit();
        }
        
        echo json_encode(['success' => true, 'message' => 'Recurring income added successfully']);
        exit();
    } else {
        echo json_encode(['success' => false, 'errors' => $validationResult['errors']]);
        exit();
    }
}

// Fetch recurring income records
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['type']) && $_GET['type'] === 'recurring') {
    $sql = "SELECT * FROM recurringincome ORDER BY recDate DESC";
    $result = mysqli_query($con, $sql);
    
    $incomes = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $incomes[] = [
            'id' => $row['recId'],
            'source' => $row['recSource'],
            'amount' => $row['recAmount'],
            'date' => $row['recDate']
        ];
    }
    
    echo json_encode($incomes);
    exit();
}

// Delete recurring income record
if ($_SERVER['REQUEST_METHOD'] === 'DELETE' && isset($_GET['type']) && $_GET['type'] === 'recurring') {
    $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
    if ($id > 0) {
        $sql = "DELETE FROM recurringincome WHERE recId = $id";
        if (mysqli_query($con, $sql)) {
            echo json_encode(['success' => true, 'message' => 'Recurring income deleted successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error deleting recurring income']);
        }
        exit();
    }
}

// ==========================================
// SIDE HUSTLE INCOME TABLE OPERATIONS
// ==========================================

// Insert new side hustle income record
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['type']) && $_POST['type'] === 'sidehustle') {
    $validationResult = validateIncome($_POST);
    
    if ($validationResult['success']) {
        $shSource = mysqli_real_escape_string($con, $_POST['incomeSource']);
        $shAmount = floatval($_POST['incomeAmount']);
        $shDate = mysqli_real_escape_string($con, $_POST['incomeDate']);
        
        $sqlInsert = "INSERT INTO `sidehustleincome` (`shId`, `shSource`, `shAmount`, `shDate`) VALUES (NULL, '$shSource', '$shAmount', '$shDate')";
        
        if (!mysqli_query($con, $sqlInsert)) {
            echo json_encode(['success' => false, 'message' => 'Error inserting side hustle income: ' . mysqli_error($con)]);
            exit();
        }
        
        echo json_encode(['success' => true, 'message' => 'Side hustle income added successfully']);
        exit();
    } else {
        echo json_encode(['success' => false, 'errors' => $validationResult['errors']]);
        exit();
    }
}

// Fetch side hustle income records
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['type']) && $_GET['type'] === 'sidehustle') {
    $sql = "SELECT * FROM sidehustleincome ORDER BY shDate DESC";
    $result = mysqli_query($con, $sql);
    
    $incomes = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $incomes[] = [
            'id' => $row['shId'],
            'source' => $row['shSource'],
            'amount' => $row['shAmount'],
            'date' => $row['shDate']
        ];
    }
    
    echo json_encode($incomes);
    exit();
}

// Delete side hustle income record
if ($_SERVER['REQUEST_METHOD'] === 'DELETE' && isset($_GET['type']) && $_GET['type'] === 'sidehustle') {
    $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
    if ($id > 0) {
        $sql = "DELETE FROM sidehustleincome WHERE shId = $id";
        if (mysqli_query($con, $sql)) {
            echo json_encode(['success' => true, 'message' => 'Side hustle income deleted successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error deleting side hustle income']);
        }
        exit();
    }
}

mysqli_close($con);
?>