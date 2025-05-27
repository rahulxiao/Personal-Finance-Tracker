<?php
function validateBillReminder($postData) {
    $errors = [];
    $success = false;

    // Validate bill name
    if (empty($postData['billName'])) {
        $errors[] = "Bill name is required";
    } elseif (strlen($postData['billName']) > 100) {
        $errors[] = "Bill name must be less than 100 characters";
    }

    // Validate bill amount
    if (empty($postData['billAmount'])) {
        $errors[] = "Bill amount is required";
    } elseif (!is_numeric($postData['billAmount']) || $postData['billAmount'] <= 0) {
        $errors[] = "Bill amount must be a positive number";
    }

    // Validate due date
    if (empty($postData['dueDate'])) {
        $errors[] = "Due date is required";
    } else {
        $dueDate = strtotime($postData['dueDate']);
        if ($dueDate === false) {
            $errors[] = "Invalid date format";
        }
    }

    // Validate bill category
    if (empty($postData['billCategory'])) {
        $errors[] = "Bill category is required";
    }

    // If no errors, set success to true
    if (empty($errors)) {
        $success = true;
    }

    return [
        'errors' => $errors,
        'success' => $success
    ];
}
?> 