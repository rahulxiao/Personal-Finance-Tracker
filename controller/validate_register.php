<?php
function validateRegisterInput($firstname, $lastname, $username, $email, $password, $confirmPassword, $terms)
{
    $errors = [];

    // First name validation
    if (empty($firstname)) {
        $errors['firstname'] = "First name is required.";
    } elseif (strlen($firstname) < 2) {
        $errors['firstname'] = "First name must be at least 2 characters.";
    } elseif (!ctype_alpha(str_replace(' ', '', $firstname))) {
        $errors['firstname'] = "First name can only contain letters and spaces.";
    }

    // Last name validation
    if (empty($lastname)) {
        $errors['lastname'] = "Last name is required.";
    } elseif (strlen($lastname) < 2) {
        $errors['lastname'] = "Last name must be at least 2 characters.";
    } elseif (!ctype_alpha(str_replace(' ', '', $lastname))) {
        $errors['lastname'] = "Last name can only contain letters and spaces.";
    }

    // Username validation
    if (empty($username)) {
        $errors['username'] = "Username is required.";
    } elseif (strlen($username) < 3) {
        $errors['username'] = "Username must be at least 3 characters.";
    } elseif (strpos($username, ' ') !== false) {
        $errors['username'] = "Username cannot contain spaces.";
    }

    // Email validation
    if (empty($email)) {
        $errors['email'] = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Please enter a valid email address.";
    }

    // Password validation
    if (empty($password)) {
        $errors['password'] = "Password is required.";
    } else {
        if (strlen($password) < 8) {
            $errors['password'] = "Password must be at least 8 characters.";
        }
        
        // Check for uppercase letter
        if (strtolower($password) === $password) {
            $errors['password'] = "Password must contain at least one uppercase letter.";
        }
        
        // Check for number
        $hasNumber = false;
        for ($i = 0; $i < strlen($password); $i++) {
            if (is_numeric($password[$i])) {
                $hasNumber = true;
                break;
            }
        }
        if (!$hasNumber) {
            $errors['password'] = "Password must contain at least one number.";
        }
        
        // Check for special character
        $specialChars = '!@#$%^&*()-_=+[]{}|;:,.<>?';
        $hasSpecial = false;
        for ($i = 0; $i < strlen($password); $i++) {
            if (strpos($specialChars, $password[$i]) !== false) {
                $hasSpecial = true;
                break;
            }
        }
        if (!$hasSpecial) {
            $errors['password'] = "Password must contain at least one special character.";
        }
    }

    // Confirm password validation
    if (empty($confirmPassword)) {
        $errors['confirm_password'] = "Please confirm your password.";
    } elseif ($confirmPassword !== $password) {
        $errors['confirm_password'] = "Passwords do not match.";
    }

    // Terms and conditions
    if (!$terms) {
        $errors['terms'] = "You must agree to the Terms and Privacy Policy.";
    }

    return $errors;
}
?>