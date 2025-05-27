<?php
function validateExpense($postData) {
    $errors = [];
    $success = false;

    // Validate expense amount
    if (empty($postData['expenseAmount'])) {
        $errors[] = "Expense amount is required";
    } elseif (!is_numeric($postData['expenseAmount']) || $postData['expenseAmount'] <= 0) {
        $errors[] = "Expense amount must be a positive number";
    }

    // Validate category
    if (empty($postData['category'])) {
        $errors[] = "Category is required";
    } elseif (!is_numeric($postData['category'])) {
        $errors[] = "Invalid category selected";
    }

    // Validate description
    if (empty($postData['description'])) {
        $errors[] = "Description is required";
    } elseif (strlen($postData['description']) > 200) {
        $errors[] = "Description must be less than 200 characters";
    }

    // Validate expense date
    if (empty($postData['expenseDate'])) {
        $errors[] = "Expense date is required";
    } else {
        $expenseDate = strtotime($postData['expenseDate']);
        if ($expenseDate === false) {
            $errors[] = "Invalid date format";
        } elseif ($expenseDate > strtotime('today')) {
            $errors[] = "Expense date cannot be in the future";
        }
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