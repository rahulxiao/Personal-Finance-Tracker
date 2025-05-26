<?php
require_once '../model/db.php'; // Make sure this path is correct for your db connection

header('Content-Type: application/json'); // Set header to indicate JSON response

function getUsers($searchTerm = '') {
    $con = getConnection();
    
    $searchTerm = mysqli_real_escape_string($con, $searchTerm);
    
    // Prepare SQL query to fetch users
    $sql = "SELECT u_fname, u_lname, u_username, u_email, u_password FROM singup";

    // If a search term is provided, add a WHERE clause to filter results
    if (!empty($searchTerm)) {
        // Use LIKE operator for partial matches
        $sql .= " WHERE u_fname LIKE '%$searchTerm%' 
                  OR u_lname LIKE '%$searchTerm%' 
                  OR u_username LIKE '%$searchTerm%' 
                  OR u_email LIKE '%$searchTerm%'";
    }

    $result = mysqli_query($con, $sql);

    $users = [];
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            // Add additional fields to the user data if needed
            $row['role'] = 'Regular User'; // Example default role
            $row['status'] = 'Active'; // Example default status
            $users[] = $row;
        }
    } else {
        // Handle database query error
        error_log("Database query failed: " . mysqli_error($con));
    }
    mysqli_close($con);
    return $users;
}

// Get the search term from the query parameters
$searchTerm = isset($_GET['query']) ? $_GET['query'] : '';

echo json_encode(getUsers($searchTerm));
?>