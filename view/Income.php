<?php
    session_start();
    if(isset($_SESSION['status'])){
        $errors = [];
        $success = false;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (empty($_POST['incomeSource'])) {
                $errors[] = "Income source is required";
            } elseif (strlen($_POST['incomeSource']) > 100) {
                $errors[] = "Income source must be less than 100 characters";
            }

            if (empty($_POST['incomeAmount'])) {
                $errors[] = "Income amount is required";
            } if (!isset($_POST['incomeAmount']) || !is_numeric($_POST['incomeAmount']) || floatval($_POST['incomeAmount']) <= 0) {
                $errors[] = "Income amount must be a positive number";
            }          


            if (empty($_POST['incomeDate'])) {
                $errors[] = "Income date is required";
            } else {
                $incomeDate = strtotime($_POST['incomeDate']);
                if ($incomeDate === false) {
                    $errors[] = "Invalid date format";
                } elseif ($incomeDate > strtotime('today')) {
                    $errors[] = "Income date cannot be in the future";
                }
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
    <title>Income Tracker</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
    <link rel="stylesheet" href="../assets/css/income.css" />
</head>

<body>
    <div class="sidebar">
        <div class="title">
            <p>FinanceFlow</p>
        </div>
        <p><a href="dashboard.php"><i data-feather="home"></i> Dashboard</a></p>
        <p><a href="features.php"><i data-feather="grid"></i> Features</a></p>
        <p><a href="income.php" class="active"><i data-feather="trending-up"></i> Income</a></p>
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
            <h1>Income Management</h1>
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <div class="date-display" id="current-date"></div>
                <div id="grandTotalIncome" style="font-size: 1.2rem; font-weight: 600; color: var(--primary-color); margin-left: auto;">Total Income: $0.00</div>
            </div>
        </header>

        <div class="income-container">
            <div class="header">
                <div id="incomeInfo">
                    <p id="totalIncome">Total Paycheck: $0.00</p>
                </div>
            </div>

            <div id="addIncome">
                <?php if (!empty($errors)): ?>
                    <div class="error-messages">
                        <?php foreach ($errors as $error): ?>
                            <p class="error"><?php echo htmlspecialchars($error); ?></p>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <?php if ($success): ?>
                    <div class="success-message">
                        <p>Income added successfully!</p>
                    </div>
                <?php endif; ?>

                <form id="incomeForm" action="../controller/incomeDB.php" method="POST">
                    <input type="text" id="source" name="incomeSource" placeholder="Income Source" required />
                    <input type="number" id="income" name="incomeAmount" min= "0.01" placeholder="Amount" step="0.01" required />
                    <input type="date" id="incomeDate" name="incomeDate" required />
                    <input type="submit" value="Add Income" />
                </form>
            </div>

            <div id="Table">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Source</th>
                            <th>Amount</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="incomeTableBody">
                        <!-- Income entries will be dynamically loaded here -->
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Recurring Income Section -->
        <div class="income-container" style="margin-top: 40px;">
            <div class="header">
                <div id="recurringIncomeInfo">
                    <p id="recurringTotalIncome">Recurring Income: $0.00</p>
                </div>
            </div>
            <div id="addRecurringIncome">
                <form id="recurringIncomeForm" action="../controller/incomeDB.php" method="POST">
                    <input type="text" id="recurringSource" name="recurringSource" placeholder="Income Source" required />
                    <input type="number" id="recurringAmount" name="recurringAmount" placeholder="Amount" step="0.01" required />
                    <input type="date" id="recurringDate" name="recurringDate" required />
                    <input type="submit" value="Add Recurring Income" />
                </form>
            </div>
            <div id="RecurringTable">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Source</th>
                            <th>Amount</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="recurringIncomeTableBody">
                        <!-- Recurring income entries will be dynamically loaded here -->
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Side Hustle Tracker Section -->
        <div class="income-container" style="margin-top: 40px;">
            <div class="header">
                <div id="sideHustleIncomeInfo">
                    <p id="sideHustleTotalIncome">Side Hustle Income: $0.00</p>
                </div>
            </div>
            <div id="addSideHustleIncome">
                <form id="sideHustleIncomeForm">
                    <input type="text" id="sideHustleSource" name="sideHustleSource" placeholder="Income Source" required />
                    <input type="number" id="sideHustleAmount" name="sideHustleAmount" placeholder="Amount" step="0.01" required />
                    <input type="date" id="sideHustleDate" name="sideHustleDate" required />
                    <input type="submit" value="Add Side Hustle Income" />
                </form>
            </div>
            <div id="SideHustleTable">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Source</th>
                            <th>Amount</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="sideHustleIncomeTableBody">
                        <!-- Side hustle income entries will be dynamically loaded here -->
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- <script src="../assets/js/income.js"></script> -->
</body>
</html>
<?php
    }else{
        header('location: login.html');
    }
?>