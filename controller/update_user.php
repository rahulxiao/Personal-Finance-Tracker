<?php
session_start();
require_once '../model/user_model.php'; 

header('Content-Type: application/x-www-form-urlencoded');


if (isset($_POST['user_id']) && isset($_POST['firstname']) && isset($_POST['lastname']) && isset($_POST['username']) && isset($_POST['email'])) {
    $userData = [
        'user_id'   => $_POST['user_id'],
        'firstname' => $_POST['firstname'],
        'lastname'  => $_POST['lastname'],
        'username'  => $_POST['username'],
        'email'     => $_POST['email']
    ];

    if (isset($_POST['password']) && !empty($_POST['password'])) {
        $userData['password'] = $_POST['password'];
    }

    $result = updateUser($userData); 

    if ($result === "success") {
        echo json_encode(['success' => true, 'message' => 'User updated successfully!']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update user.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Missing required fields for update.']);
}
?>