<?php
    session_start();
    if(isset($_SESSION['status'])){
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FinanceFlow - Account Linking</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
    <link rel="stylesheet" href="../assets/css/feature.css">
    <link rel="stylesheet" href="../assets/css/account-linking.css">
</head>
<body>
    <div class="app-container">
        <nav class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <h1>FinanceFlow</h1>
                <button id="sidebar-toggle" class="sidebar-toggle mobile-only">
                    <i data-feather="menu"></i>
                </button>
            </div>
            <ul class="sidebar-menu">
                <li data-page="dashboard">
                    <a href="###########"><i data-feather="home"></i> Dashboard</a>
                </li>
                <li class="actt" data-page="features">
                    <a href="features.php"><i data-feather="grid"></i> Features</a>
                </li>
                <li class="active" data-page="features">
                    <a href="account-linking.php"><i data-feather="link"></i> Account Linking</a>
                </li>
            </ul>
        </nav>

        <main class="main-content">
            <header class="page-header">
                <h1 id="page-title">Account Linking</h1>
                <div class="date-display" id="current-date"></div>
            </header>

            <div class="feature-content">
                <div class="page-actions">
                    <button class="back-button" onclick="window.location.href='features.php'">
                        <i data-feather="arrow-left"></i> Back to Features
                    </button>
                </div>

                <div class="connection-form" id="connection-form">
                    <div class="feature-description">
                        <div class="feature-icon">
                            <i data-feather="link"></i>
                        </div>
                        <h2>Connect Your Bank</h2>
                        <p>Securely connect your bank account to track transactions.</p>
                    </div>

                    <form id="bank-connect-form">
                        <div class="form-group">
                            <label for="bank-select">Select Bank</label>
                            <select id="bank-select" required>
                                <option value="">Choose a bank</option>
                                <option value="chase">Chase</option>
                                <option value="bankofamerica">Bank of America</option>
                                <option value="wellsfargo">Wells Fargo</option>
                                <option value="citibank">Citibank</option>
                            </select>
                            <div class="error-message" id="bank-select-error"></div>
                        </div>
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" id="username" required>
                            <div class="error-message" id="username-error"></div>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <div class="password-input">
                                <input type="password" id="password" required>
                                <button type="button" class="toggle-password">
                                    <i data-feather="eye"></i>
                                </button>
                            </div>
                            <div class="error-message" id="password-error"></div>
                        </div>
                        <div class="security-info">
                            <i data-feather="lock"></i>
                            <span>Credentials are encrypted.</span>
                        </div>
                        <button type="submit" class="connect-btn">Connect</button>
                    </form>
                </div>

                <div class="bank-details" id="bank-details" style="display: none;">
                    <div class="feature-description">
                        <div class="feature-icon">
                            <i data-feather="dollar-sign"></i>
                        </div>
                        <h2>Bank Details</h2>
                        <p>View your account balance, transactions, and statements.</p>
                    </div>
                    <div class="account-summary">
                        <h3>Account Summary</h3>
                        <p><strong>Bank:</strong> <span id="bank-name"></span></p>
                        <p><strong>Total Balance:</strong> <span id="total-balance">$0.00</span></p>
                    </div>
                    <div class="transaction-history">
                        <h3>Transaction History</h3>
                        <table>
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Description</th>
                                    <th>Amount</th>
                                    <th>Type</th>
                                </tr>
                            </thead>
                            <tbody id="transaction-table"></tbody>
                        </table>
                    </div>
                    <div class="dps-section">
                        <h3>Deposits</h3>
                        <ul id="deposits-list"></ul>
                        <h3>Payments</h3>
                        <ul id="payments-list"></ul>
                        <h3>Statements</h3>
                        <ul id="statements-list"></ul>
                    </div>
                    <button class="logout-btn">Disconnect</button>
                </div>
            </div>
        </main>
    </div>

    <div id="notification-container" class="notification-container"></div>
    <script src="../assets/js/features.js"></script>
    <script src="../assets/js/account-linking.js"></script>
</body>
</html> 

<?php
    }else{
        header('location: login.html');
    }

?>