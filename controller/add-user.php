<?php
session_start(); // Start session to access CSRF token
require_once '../model/db.php';         // Your database connection
require_once '../model/user_model.php'; // Contains the addUser function

header('Content-Type: application/json'); // Always respond with JSON

$response = ['success' => false, 'message' => 'An unknown error occurred.'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf_token']) || !isset($_SESSION['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        // If tokens don't match, or if session token is missing
        $response = ['success' => false, 'message' => 'CSRF token mismatch.'];
        echo json_encode($response);
        exit(); // Stop script execution
    }

    // 2. Input Collection: Prioritize JSON if sent via fetch with 'application/json'
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);

    // If JSON decoding fails, or if it's not JSON, fall back to $_POST for form-urlencoded
    if (json_last_error() !== JSON_ERROR_NONE || !is_array($data) || empty($data)) {
        $data = $_POST; // This will catch traditional form submissions and form-urlencoded AJAX
    }

    // Extract and trim data
    $firstname = trim($data['firstname'] ?? '');
    $lastname = trim($data['lastname'] ?? '');
    $username = trim($data['username'] ?? '');
    $email = trim($data['email'] ?? '');
    $password = $data['password'] ?? '';

    // 3. Validation
    if (empty($firstname) || empty($lastname) || empty($username) || empty($email) || empty($password)) {
        $response = ['success' => false, 'message' => 'All fields are required.'];
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $response = ['success' => false, 'message' => 'Invalid email format.'];
    } else {
        // 4. Password Hashing (CRITICAL!)
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        if ($hashedPassword === false) {
            $response = ['success' => false, 'message' => 'Password hashing failed.'];
            echo json_encode($response);
            exit();
        }

        // Build user array for the model
        $user = [
            'firstname' => $firstname,
            'lastname'  => $lastname,
            'username'  => $username,
            'email'     => $email,
            'password'  => $hashedPassword // Pass the HASHED password
        ];

        // 5. Call model function and handle results (user_model.php needs update too)
        $result = addUser($user); // The addUser function itself needs to use prepared statements or mysqli_real_escape_string

        if ($result === "success") {
            $response = ['success' => true, 'message' => 'User added successfully.'];
        } elseif ($result === "exists") {
            $response = ['success' => false, 'message' => 'Username or Email already exists.'];
        } else {
            $response = ['success' => false, 'message' => 'Failed to add user to database.'];
        }
    }
} else {
    $response = ['success' => false, 'message' => 'Invalid request method. Only POST allowed.'];
}

echo json_encode($response);
?>