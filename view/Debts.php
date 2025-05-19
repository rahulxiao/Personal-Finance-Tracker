<?php
    session_start();
    if(isset($_SESSION['status'])){
        $errors = [];
        $success = false;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (empty($_POST['debtSource'])) {
                $errors[] = "Debt source is required";
            } elseif (strlen($_POST['debtSource']) > 100) {
                $errors[] = "Debt source must be less than 100 characters";
            }

            if (empty($_POST['loanAmount'])) {
                $errors[] = "Loan amount is required";
            } elseif (!is_numeric($_POST['loanAmount']) || $_POST['loanAmount'] <= 0) {
                $errors[] = "Loan amount must be a positive number";
            }

            // Validate interest rate
            if (empty($_POST['interestRate'])) {
                $errors[] = "Interest rate is required";
            } elseif (!is_numeric($_POST['interestRate']) || $_POST['interestRate'] < 0) {
                $errors[] = "Interest rate must be a non-negative number";
            }

            if (empty($_POST['monthlyPayment'])) {
                $errors[] = "Monthly payment is required";
            } elseif (!is_numeric($_POST['monthlyPayment']) || $_POST['monthlyPayment'] <= 0) {
                $errors[] = "Monthly payment must be a positive number";
            }

            
            if (empty($errors)) {
                $success = true;
            
            }
        }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Debt Tracker</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
    <link rel="stylesheet" href="../assets/css/debts.css" />
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
        <p><a href="Debts.php" class="active"><i data-feather="credit-card"></i> Debt Tracking</a></p>
        <p><a href="budget-goals.php"><i data-feather="target"></i> Budget Goals</a></p>
        <p><a href="billReminders.php"><i data-feather="bell"></i> Bill Reminders</a></p>
        <p><a href="savingsGoals.php"><i data-feather="dollar-sign"></i> Savings Goals</a></p>
        <p><a href="reports-graphs.php"><i data-feather="bar-chart-2"></i> Reports</a></p>
        <p><a href="../index.html"><i data-feather="log-out"></i> Log Out</a></p>
    </div>
    <main class="main-content">
        <header class="page-header">
            <h1>Debt Tracking</h1>
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <div class="date-display" id="current-date"></div>
                <div id="grandTotalDebt" style="font-size: 1.2rem; font-weight: 600; color: var(--primary-color); margin-left: auto;">Total Debt: $0.00</div>
            </div>
        </header>
        <div class="debts-container">
            <div class="header">
                <div id="debtInfo">
                    <p id="totalDebt">Loan Payoff Calculator</p>
                </div>
            </div>
            <div id="addDebt">
                <?php if (!empty($errors)): ?>
                    <div class="error-messages">
                        <?php foreach ($errors as $error): ?>
                            <p class="error"><?php echo htmlspecialchars($error); ?></p>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <?php if ($success): ?>
                    <div class="success-message">
                        <p>Debt added successfully!</p>
                    </div>
                <?php endif; ?>

                <form id="debtForm">
                    <input type="text" id="debtSource" name="debtSource" placeholder="Debt Source" required />
                    <input type="number" id="loanAmount" name="loanAmount" placeholder="Loan Amount" min="0" step="0.01" required />
                    <input type="number" id="interestRate" name="interestRate" placeholder="Interest Rate (%)" min="0" step="0.01" required />
                    <input type="number" id="monthlyPayment" name="monthlyPayment" placeholder="Monthly Payment" min="0" step="0.01" required />
                    <input type="submit" value="Add Debt" />
                </form>
            </div>
            <div id="payoffResults" class="payoff-results" style="display:none;">
                <h2>Payoff Summary</h2>
                <p id="payoffTime"></p>
                <p id="totalInterest"></p>
                <p id="totalRepayment"></p>
            </div>
            <!-- Debts Table -->
            <div id="debtsTableSection">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Debt Source</th>
                            <th>Loan Amount</th>
                            <th>Interest Rate (%)</th>
                            <th>Monthly Payment</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="debtsTableBody">
                        <!-- Debt entries will be dynamically loaded here -->
                    </tbody>
                </table>
            </div>
            <!-- Payoff Modal -->
            <div id="payoffModal" class="payoff-modal" style="display:none;">
                <div class="payoff-modal-content">
                    <span id="closePayoffModal" class="close-modal">&times;</span>
                    <h2>Payoff Summary</h2>
                    <p id="modalPayoffTime"></p>
                    <p id="modalTotalInterest"></p>
                    <p id="modalTotalRepayment"></p>
                </div>
            </div>
        </div>
    </main>
    <script src="../assets/js/debts.js"></script>
    <script>if(window.feather) feather.replace();</script>
</body>
</html>
<?php
    }else{
        header('location: login.html');
    }

?>