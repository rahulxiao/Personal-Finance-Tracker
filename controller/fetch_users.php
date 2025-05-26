<?php
require_once '../model/db.php'; // Make sure this path is correct for your db connection

header('Content-Type: application/json'); // Set header to indicate JSON response

function getUsers() {
    $con = getConnection();
    // Select the fields you need from your 'singup' table.
    // NOTE: NEVER fetch or expose the raw 'password' field directly to the client-side.
    // I'm including u_password here because your admin.php explicitly has a 'Password' column,
    // but in a real application, you would not send it to the client.
    $sql = "SELECT u_fname, u_lname, u_username, u_email, u_password FROM singup";
    $result = mysqli_query($con, $sql);

    $users = [];
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            // Add default role and status if they are not in your database table
            // You might have a 'role' or 'status' column in 'singup' or a related table
            $row['role'] = 'Regular User'; // Example default role
            $row['status'] = 'Active'; // Example default status
            $users[] = $row;
        }
    }
    mysqli_close($con);
    return $users;
}

echo json_encode(getUsers());
?>