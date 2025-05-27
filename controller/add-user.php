<?php
session_start();
require_once '../model/user_model.php'; // Adjust path as needed

header('Content-Type: application/x-www-form-urlencoded'); // Ensure the response is JSON

if (isset($_POST['firstname']) && isset($_POST['lastname']) && isset($_POST['username']) && isset($_POST['email']) && isset($_POST['password'])) {
    $userData = [
        'firstname' => $_POST['firstname'],
        'lastname'  => $_POST['lastname'],
        'username'  => $_POST['username'],
        'email'     => $_POST['email'],
        'password'  => $_POST['password']
    ];

    $result = addUser($userData); // Call the simplified addUser function

    if ($result === "success") {
        echo json_encode(['success' => true, 'message' => 'User added successfully!']);
    } elseif ($result === "exists") {
        echo json_encode(['success' => false, 'message' => 'Username or email already exists.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to add user.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Missing required fields.']);
}
?>