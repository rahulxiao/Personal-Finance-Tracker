<?php
function validateSavingsGoal($postData) {
    $errors = [];
    $success = false;

    // Validate goal name
    if (empty($postData['goalName'])) {
        $errors[] = "Goal name is required";
    } elseif (strlen($postData['goalName']) > 100) {
        $errors[] = "Goal name must be less than 100 characters";
    }

    // Validate target amount
    if (empty($postData['targetAmount'])) {
        $errors[] = "Target amount is required";
    } elseif (!is_numeric($postData['targetAmount']) || $postData['targetAmount'] <= 0) {
        $errors[] = "Target amount must be a positive number";
    }

    // Validate current amount
    if (empty($postData['currentAmount'])) {
        $errors[] = "Current amount is required";
    } elseif (!is_numeric($postData['currentAmount']) || $postData['currentAmount'] < 0) {
        $errors[] = "Current amount must be a non-negative number";
    }

    // Validate target date
    if (empty($postData['targetDate'])) {
        $errors[] = "Target date is required";
    } else {
        $targetDate = strtotime($postData['targetDate']);
        if ($targetDate === false) {
            $errors[] = "Invalid target date format";
        } elseif ($targetDate < strtotime('today')) {
            $errors[] = "Target date cannot be in the past";
        }
    }

    // Validate category
    if (empty($postData['category'])) {
        $errors[] = "Category is required";
    } elseif (!in_array($postData['category'], ['Emergency Fund', 'Vacation', 'Home', 'Car', 'Education', 'Retirement', 'Other'])) {
        $errors[] = "Invalid category selected";
    }

    // Validate monthly contribution
    if (empty($postData['monthlyContribution'])) {
        $errors[] = "Monthly contribution is required";
    } elseif (!is_numeric($postData['monthlyContribution']) || $postData['monthlyContribution'] <= 0) {
        $errors[] = "Monthly contribution must be a positive number";
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