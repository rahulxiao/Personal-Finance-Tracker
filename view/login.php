<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Fitness Tracker - Register</title>
    <link rel="stylesheet" href="../assets/css/register.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        .error-message {
            color: red;
            font-size: 0.8rem;
            margin-top: 5px;
        }
        .input-box {
            position: relative;
        }
        .terms-check .error-message {
            display: block;
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <?php
    session_start();
    $errors = $_SESSION['register_errors'] ?? [];
    $formData = $_SESSION['form_data'] ?? [];
    unset($_SESSION['register_errors']);
    unset($_SESSION['form_data']);
    ?>
    
    <div class="main-container">
        <!-- Register Container -->
        <div class="register-container">
            <div class="register-card">
                <div class="back-button">
                    <a href="../index.html" class="back-link">
                        <ion-icon name="arrow-back-outline"></ion-icon>
                    </a>
                </div>
                
                <div class="card-header">
                    <div class="logo">
                        <ion-icon name="card"></ion-icon>
                        <h4>MoneyFin</h4>
                    </div>
                    <h1>Create Account</h1>
                    <p>Please fill in your information to get started</p>
                </div>
                
                <form action="../controller/singup.php" method="POST" id="register-form" novalidate>
                    <div class="form-row">
                        <div class="input-group">
                            <label for="firstname">First Name</label>
                            <div class="input-box">
                                <span class="icon"><ion-icon name="person-outline"></ion-icon></span>
                                <input type="text" name="firstname" id="firstname" 
                                       value="<?= htmlspecialchars($formData['firstname'] ?? '') ?>" 
                                       placeholder="Enter your first name" required />
                            </div>
                            <?php if (isset($errors['firstname'])): ?>
                                <div class="error-message"><?= $errors['firstname'] ?></div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="input-group">
                            <label for="lastname">Last Name</label>
                            <div class="input-box">
                                <span class="icon"><ion-icon name="person-outline"></ion-icon></span>
                                <input type="text" name="lastname" id="lastname" 
                                       value="<?= htmlspecialchars($formData['lastname'] ?? '') ?>" 
                                       placeholder="Enter your last name" required />
                            </div>
                            <?php if (isset($errors['lastname'])): ?>
                                <div class="error-message"><?= $errors['lastname'] ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <div class="input-group">
                        <label for="username">Username</label>
                        <div class="input-box">
                            <span class="icon"><ion-icon name="at-outline"></ion-icon></span>
                            <input type="text" name="username" id="username" 
                                   value="<?= htmlspecialchars($formData['username'] ?? '') ?>" 
                                   placeholder="Choose a username" required />
                        </div>
                        <?php if (isset($errors['username'])): ?>
                            <div class="error-message"><?= $errors['username'] ?></div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="input-group">
                        <label for="email">Email Address</label>
                        <div class="input-box">
                            <span class="icon"><ion-icon name="mail-outline"></ion-icon></span>
                            <input type="email" name="email" id="email" 
                                   value="<?= htmlspecialchars($formData['email'] ?? '') ?>" 
                                   placeholder="Enter your email" required />
                        </div>
                        <?php if (isset($errors['email'])): ?>
                            <div class="error-message"><?= $errors['email'] ?></div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="input-group">
                        <label for="password">Password</label>
                        <div class="input-box">
                            <span class="icon"><ion-icon name="lock-closed-outline"></ion-icon></span>
                            <input type="password" name="password" id="password" placeholder="Create a password" required />
                            <span class="toggle-password">
                                <ion-icon name="eye-outline"></ion-icon>
                            </span>
                        </div>
                        <?php if (isset($errors['password'])): ?>
                            <div class="error-message"><?= $errors['password'] ?></div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="input-group">
                        <label for="confirm-password">Confirm Password</label>
                        <div class="input-box">
                            <span class="icon"><ion-icon name="lock-closed-outline"></ion-icon></span>
                            <input type="password" name="confirm-password" id="confirm-password" 
                                   placeholder="Confirm your password" required />
                        </div>
                        <?php if (isset($errors['confirm_password'])): ?>
                            <div class="error-message"><?= $errors['confirm_password'] ?></div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="terms-privacy">
                        <label for="terms" class="terms-check">
                            <input type="checkbox" name="terms" id="terms" <?= isset($formData['terms']) ? 'checked' : '' ?> required />
                            <span class="checkmark"></span>
                            <span>I agree to the <a href="terms.html">Terms of Service</a> and <a href="privacy.html">Privacy Policy</a></span>
                        </label>
                        <?php if (isset($errors['terms'])): ?>
                            <div class="error-message"><?= $errors['terms'] ?></div>
                        <?php endif; ?>
                    </div>
                    
                    <button type="submit" name="submit" class="btn-primary">Create Account</button>                 
                    
                     <div class="alternative-login">
                        <span class="divider">Or continue with</span>
                        <div class="social-logins">
                            <button type="button" class="btn-social">
                                <ion-icon name="logo-google"></ion-icon>
                            </button>
                            <button type="button" class="btn-social">
                                <ion-icon name="logo-facebook"></ion-icon>
                            </button>
                            <button type="button" class="btn-social">
                                <ion-icon name="logo-apple"></ion-icon>
                            </button>
                        </div>
                    </div>
                    
                    <div class="login-register">
                        <p>
                            Don't have an account?
                            <a href="register.php">Create Account</a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>

     <!-- Ionicons for icons -->
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <!-- Custom JavaScript -->
    <!-- <script src="../assets/js/login.js"></script> -->
</body>
</html>