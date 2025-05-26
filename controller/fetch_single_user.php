<?php
require_once '../model/user_model.php'; // Adjust path as needed

header('Content-Type: application/json'); // Ensure the response is JSON

// Check if the 'id' parameter is set in the GET request
if (isset($_GET['id'])) {
    $userId = $_GET['id'];
    
    // Call the getUserById function from user_model.php
    $user = getUserById($userId); 

    // Check if a user was found
    if ($user) {
        // Return success with user data
        echo json_encode(['success' => true, 'data' => $user]);
    } else {
        // Return failure if user not found
        echo json_encode(['success' => false, 'message' => 'User not found.']);
    }
} else {
    // Return failure if user ID is missing from the request
    echo json_encode(['success' => false, 'message' => 'User ID is missing.']);
}
?>