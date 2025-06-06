<?php
session_start();
require_once '../model/user_model.php'; // Adjust path as needed

header('Content-Type: application/x-www-form-urlencoded'); // Ensure the response is JSON


if (isset($_POST['user_id'])) {
    $userId = $_POST['user_id'];
    $result = deleteUser($userId); 

    if ($result === "success") {
        echo json_encode(['success' => true, 'message' => 'User deleted successfully!']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to delete user.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'User ID is missing.']);
}
?>