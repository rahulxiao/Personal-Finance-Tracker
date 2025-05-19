<?php
    session_start();
    if(isset($_SESSION['status'])){
        $errors = [];
        $success = false;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (empty($_POST['firstName'])) {
                $errors[] = "First name is required";
            } elseif (strlen($_POST['firstName']) > 50) {
                $errors[] = "First name must be less than 50 characters";
            }

            if (empty($_POST['lastName'])) {
                $errors[] = "Last name is required";
            } elseif (strlen($_POST['lastName']) > 50) {
                $errors[] = "Last name must be less than 50 characters";
            }

            if (empty($_POST['email'])) {
                $errors[] = "Email is required";
            } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                $errors[] = "Invalid email format";
            }

            if (!empty($_POST['phone'])) {
                if (!preg_match('/^[0-9]{10,15}$/', $_POST['phone'])) {
                    $errors[] = "Phone number must be between 10 and 15 digits";
                }
            }

            if (!empty($_POST['newPassword'])) {
                if (empty($_POST['currentPassword'])) {
                    $errors[] = "Current password is required to set a new password";
                }
            }

            if (!empty($_POST['newPassword'])) {
                if (strlen($_POST['newPassword']) < 8) {
                    $errors[] = "New password must be at least 8 characters long";
                } elseif (!preg_match('/[A-Z]/', $_POST['newPassword'])) {
                    $errors[] = "New password must contain at least one uppercase letter";
                } elseif (!preg_match('/[a-z]/', $_POST['newPassword'])) {
                    $errors[] = "New password must contain at least one lowercase letter";
                } elseif (!preg_match('/[0-9]/', $_POST['newPassword'])) {
                    $errors[] = "New password must contain at least one number";
                }
            }

            if (empty($_POST['currency'])) {
                $errors[] = "Preferred currency is required";
            } elseif (!in_array($_POST['currency'], ['USD', 'EUR', 'GBP', 'JPY', 'CAD', 'AUD'])) {
                $errors[] = "Invalid currency selected";
            }

            if (empty($_POST['language'])) {
                $errors[] = "Preferred language is required";
            } elseif (!in_array($_POST['language'], ['English', 'Spanish', 'French', 'German', 'Chinese', 'Japanese'])) {
                $errors[] = "Invalid language selected";
            }

            if (empty($_POST['timezone'])) {
                $errors[] = "Timezone is required";
            } elseif (!in_array($_POST['timezone'], ['UTC', 'EST', 'CST', 'PST', 'GMT', 'IST'])) {
                $errors[] = "Invalid timezone selected";
            }

           
            if (empty($errors)) {
                $success = true;

            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Profile Management</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
    <link rel="stylesheet" href="../assets/css/profileManagement.css" />
</head>

<body>
    <div class="sidebar">
        <div class="title">
            <p>FinanceFlow</p>
        </div>
        <p><a href="dashboard.php"><i data-feather="home"></i> Dashboard</a></p>
        <p><a href="features.php"><i data-feather="grid"></i> Features</a></p>
        <p><a href="income.php"><i data-feather="trending-up"></i> Income</a></p>
        <p><a href="expense.php"><i data-feather="trending-down"></i> Expense</a></p>
        <p><a href="Debts.php"><i data-feather="credit-card"></i> Debt Tracking</a></p>
        <p><a href="budget-goals.php"><i data-feather="target"></i> Budget Goals</a></p>
        <p><a href="billReminders.php"><i data-feather="bell"></i> Bill Reminders</a></p>
        <p><a href="savingsGoals.php"><i data-feather="dollar-sign"></i> Savings Goals</a></p>
        <p><a href="reports-graphs.php"><i data-feather="bar-chart-2"></i> Reports</a></p>
        <p><a href="../index.html"><i data-feather="log-out"></i> Log Out</a></p>
    </div>

    <main class="main-content">
        <header class="page-header">
            <h1>Profile Management</h1>
            <div class="header-actions">
                <button class="view-profile-btn" onclick="toggleViewMode()">
                    <i data-feather="eye"></i>
                    View Profile
                </button>
            </div>
        </header>

        <div class="profile-container">
            <div class="profile-header">
                <div class="profile-avatar">
                    <img src="../assets/images/default-avatar.png" alt="Profile Picture" id="profilePicture">
                    <button class="change-avatar-btn" onclick="document.getElementById('avatarInput').click()">
                        <i data-feather="camera"></i>
                        Change Photo
                    </button>
                    <input type="file" id="avatarInput" accept="image/*" style="display: none;" onchange="handleAvatarChange(event)">
                </div>
                <div class="profile-name">
                    <h2 id="displayName">John Doe</h2>
                    <p id="displayEmail">john.doe@example.com</p>
                </div>
            </div>

            <form class="profile-form" id="profileForm">
                <div class="form-section">
                    <h3>Personal Information</h3>
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="firstName">First Name</label>
                            <input type="text" id="firstName" name="firstName" required>
                        </div>
                        <div class="form-group">
                            <label for="lastName">Last Name</label>
                            <input type="text" id="lastName" name="lastName" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone Number</label>
                            <input type="tel" id="phone" name="phone">
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <h3>Security</h3>
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="currentPassword">Current Password</label>
                            <input type="password" id="currentPassword" name="currentPassword">
                        </div>
                        <div class="form-group">
                            <label for="newPassword">New Password</label>
                            <input type="password" id="newPassword" name="newPassword">
                        </div>
                        <div class="form-group">
                            <label for="confirmPassword">Confirm New Password</label>
                            <input type="password" id="confirmPassword" name="confirmPassword">
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <h3>Preferences</h3>
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="currency">Preferred Currency</label>
                            <input type="text" id="currency" name="currency" value="USD">
                        </div>
                        <div class="form-group">
                            <label for="language">Language</label>
                            <input type="text" id="language" name="language" value="English">
                        </div>
                        <div class="form-group">
                            <label for="timezone">Timezone</label>
                            <input type="text" id="timezone" name="timezone" value="UTC">
                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="save-btn">
                        <i data-feather="save"></i>
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </main>

    <script src="../assets/js/profile.js"></script>
</body>
</html>
<?php
    else{
        header('location: login.html');
    }
?> 