<?php
function validateDebt($postData) {
    $errors = [];
    $success = false;

    // Validate debt source
    if (empty($postData['debtSource'])) {
        $errors[] = "Debt source is required";
    } elseif (strlen($postData['debtSource']) > 100) {
        $errors[] = "Debt source must be less than 100 characters";
    }

    // Validate loan amount
    if (empty($postData['loanAmount'])) {
        $errors[] = "Loan amount is required";
    } elseif (!is_numeric($postData['loanAmount']) || $postData['loanAmount'] <= 0) {
        $errors[] = "Loan amount must be a positive number";
    }

    // Validate interest rate
    if (empty($postData['interestRate'])) {
        $errors[] = "Interest rate is required";
    } elseif (!is_numeric($postData['interestRate']) || $postData['interestRate'] < 0) {
        $errors[] = "Interest rate must be a non-negative number";
    }

    // Validate monthly payment
    if (empty($postData['monthlyPayment'])) {
        $errors[] = "Monthly payment is required";
    } elseif (!is_numeric($postData['monthlyPayment']) || $postData['monthlyPayment'] <= 0) {
        $errors[] = "Monthly payment must be a positive number";
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