<?php
require_once '../model/user_model.php'; // Adjust path as needed

header('Content-Type: application/x-www-form-urlencoded'); // Ensure the response is JSON

if (isset($_GET['id'])) {
    $userId = $_GET['id'];
    
    $user = getUserById($userId); 
    if ($user) {
        echo json_encode(['success' => true, 'data' => $user]);
    } else {
        echo json_encode(['success' => false, 'message' => 'User not found.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'User ID is missing.']);
}
?>