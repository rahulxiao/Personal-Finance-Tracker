<?php
    session_start();
    if(isset($_SESSION['status'])){
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Dashboard</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
    <link rel="stylesheet" href="../assets/css/dashboard.css" />
</head>

<body>
    <div class="sidebar">
        <div class="title">
            <p>FinanceFlow</p>
        </div>
        <p><a href="dashboard.php" class="active"><i data-feather="home"></i> Dashboard</a></p>
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
            <h1>Dashboard</h1>
            <div class="date-display" id="current-date"></div>
        </header>

        <!-- Summary Cards -->
        <div class="summary-cards">
            <div class="summary-card income">
                <div class="card-icon">
                    <i data-feather="trending-up"></i>
                </div>
                <div class="card-content">
                    <h3>Total Income</h3>
                    <div class="amount" id="totalIncome">$0.00</div>
                    <a href="income.php" class="view-details">
                        View Details <i data-feather="arrow-right"></i>
                    </a>
                </div>
            </div>

            <div class="summary-card expense">
                <div class="card-icon">
                    <i data-feather="trending-down"></i>
                </div>
                <div class="card-content">
                    <h3>Total Expenses</h3>
                    <div class="amount" id="totalExpense">$0.00</div>
                    <a href="expense.php" class="view-details">
                        View Details <i data-feather="arrow-right"></i>
                    </a>
                </div>
            </div>

            <div class="summary-card debt">
                <div class="card-icon">
                    <i data-feather="credit-card"></i>
                </div>
                <div class="card-content">
                    <h3>Total Debt</h3>
                    <div class="amount" id="totalDebt">$0.00</div>
                    <a href="Debts.php" class="view-details">
                        View Details <i data-feather="arrow-right"></i>
                    </a>
                </div>
            </div>

            <div class="summary-card savings">
                <div class="card-icon">
                    <i data-feather="dollar-sign"></i>
                </div>
                <div class="card-content">
                    <h3>Total Savings</h3>
                    <div class="amount" id="totalSavings">$0.00</div>
                    <a href="savingsGoals.php" class="view-details">
                        View Details <i data-feather="arrow-right"></i>
                    </a>
                </div>
            </div>

            <div class="summary-card bills">
                <div class="card-icon">
                    <i data-feather="bell"></i>
                </div>
                <div class="card-content">
                    <h3>Upcoming Bills</h3>
                    <div class="amount" id="upcomingBills">$0.00</div>
                    <a href="billReminders.php" class="view-details">
                        View Details <i data-feather="arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="quick-actions">
            <h2>Quick Actions</h2>
            <div class="action-buttons">
                <a href="income.php" class="action-btn">
                    <i data-feather="plus"></i>
                    Add Income
                </a>
                <a href="expense.php" class="action-btn">
                    <i data-feather="minus"></i>
                    Add Expense
                </a>
                <a href="savingsGoals.php" class="action-btn">
                    <i data-feather="target"></i>
                    Set Savings Goal
                </a>
                <a href="billReminders.php" class="action-btn">
                    <i data-feather="bell"></i>
                    Add Bill
                </a>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="recent-activity">
            <h2>Recent Activity</h2>
            <div class="activity-list" id="activityList">
                <!-- Activity from JavaScript -->
            </div>
        </div>
    </main>

    <script src="../assets/js/dashboard.js"></script>
</body>
</html>
<?php
    }else{
        header('location: login.html');
    }
?> 