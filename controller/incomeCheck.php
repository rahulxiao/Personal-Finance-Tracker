<?php
function validateIncome($postData) {
    $errors = [];
    $success = false;

    // Validate income source
    if (empty($postData['incomeSource'])) {
        $errors[] = "Income source is required";
    } elseif (strlen($postData['incomeSource']) > 100) {
        $errors[] = "Income source must be less than 100 characters";
    } elseif (preg_match('/[0-9]/', $postData['incomeSource'])) {
        $errors[] = "Income source cannot contain numbers";
    }

    // Validate income amount
    if (empty($postData['incomeAmount'])) {
        $errors[] = "Income amount is required";
    } if (!isset($postData['incomeAmount']) || !is_numeric($postData['incomeAmount']) || floatval($postData['incomeAmount']) <= 0) {
        $errors[] = "Income amount must be a positive number";
    }          

    // Validate income date
    if (empty($postData['incomeDate'])) {
        $errors[] = "Income date is required";
    } else {
        $incomeDate = strtotime($postData['incomeDate']);
        if ($incomeDate === false) {
            $errors[] = "Invalid date format";
        } elseif ($incomeDate > strtotime('today')) {
            $errors[] = "Income date cannot be in the future";
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