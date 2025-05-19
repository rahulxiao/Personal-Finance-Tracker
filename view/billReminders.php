<?php
    session_start();
    if(isset($_SESSION['status'])){
        $errors = [];
        $success = false;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validate bill name
            if (empty($_POST['billName'])) {
                $errors[] = "Bill name is required";
            } elseif (strlen($_POST['billName']) > 100) {
                $errors[] = "Bill name must be less than 100 characters";
            }

            
            if (empty($_POST['billAmount'])) {
                $errors[] = "Bill amount is required";
            } elseif (!is_numeric($_POST['billAmount']) || $_POST['billAmount'] <= 0) {
                $errors[] = "Bill amount must be a positive number";
            }

            
            if (empty($_POST['dueDate'])) {
                $errors[] = "Due date is required";
            } else {
                $dueDate = strtotime($_POST['dueDate']);
                if ($dueDate === false) {
                    $errors[] = "Invalid date format";
                } elseif ($dueDate < strtotime('today')) {
                    $errors[] = "Due date cannot be in the past";
                }
            }

            // Validate bill category
            if (empty($_POST['billCategory'])) {
                $errors[] = "Bill category is required";
            } elseif (!in_array($_POST['billCategory'], ['Utilities', 'Rent/Mortgage', 'Insurance', 'Subscription', 'Loan Payment', 'Other'])) {
                $errors[] = "Invalid bill category selected";
            }

          
            if (empty($_POST['paymentStatus'])) {
                $errors[] = "Payment status is required";
            } elseif (!in_array($_POST['paymentStatus'], ['Pending', 'Paid', 'Overdue'])) {
                $errors[] = "Invalid payment status selected";
            }

            // If no errors, process the form
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
    <title>Bill Reminders</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
    <link rel="stylesheet" href="../assets/css/billReminders.css" />
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
        <p><a href="billReminders.php" class="active"><i data-feather="bell"></i> Bill Reminders</a></p>
        <p><a href="savingsGoals.php"><i data-feather="dollar-sign"></i> Savings Goals</a></p>
        <p><a href="reports-graphs.php"><i data-feather="bar-chart-2"></i> Reports</a></p>
        <p><a href="../index.html"><i data-feather="log-out"></i> Log Out</a></p>
    </div>

    <main class="main-content">
        <header class="page-header">
            <h1>Bill Reminders</h1>
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <div class="date-display" id="current-date"></div>
                <div id="upcomingBills" style="font-size: 1.2rem; font-weight: 600; color: var(--primary-color); margin-left: auto;">
                    Upcoming Bills: 0
                </div>
            </div>
        </header>

        <!-- Add Bill Form -->
        <div class="bill-container">
            <div class="header">
                <div id="addBillInfo">
                    <p>Add New Bill</p>
                </div>
            </div>
            <div id="addBill">
                <?php if (!empty($errors)): ?>
                    <div class="error-messages">
                        <?php foreach ($errors as $error): ?>
                            <p class="error"><?php echo htmlspecialchars($error); ?></p>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <?php if ($success): ?>
                    <div class="success-message">
                        <p>Bill added successfully!</p>
                    </div>
                <?php endif; ?>

                <form id="billForm" action="../controller/billDB.php" method="POST">
                    <input type="text" id="billName" name="billName" placeholder="Bill Name" required />
                    <input type="number" id="billAmount" name="billAmount" placeholder="Amount" step="0.01" required />
                    <input type="date" id="dueDate" name="dueDate" required />
                    <select id="billCategory" name="billCategory" required>
                        <option value="">Select Category</option>
                        <option value="Utilities">Utilities</option>
                        <option value="Rent">Rent</option>
                        <option value="Insurance">Insurance</option>
                        <option value="Subscription">Subscription</option>
                        <option value="Other">Other</option>
                    </select>
                    <div class="auto-pay-toggle">
                        <label for="autoPay">Auto-Pay</label>
                        <input type="checkbox" id="autoPay" name="autoPay" />
                    </div>
                    <input type="submit" value="Add Bill" />
                </form>
            </div>
        </div>

        <!-- Bill History Section -->
        <div class="bill-container">
            <div class="header">
                <div id="billHistoryInfo">
                    <p>Bill History</p>
                </div>
            </div>
            <div class="filter-section">
                <select id="statusFilter" onchange="filterBills()">
                    <option value="all">All Bills</option>
                    <option value="pending">Pending</option>
                    <option value="paid">Paid</option>
                    <option value="overdue">Overdue</option>
                </select>
            </div>
            <div id="billHistoryTable">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Bill Name</th>
                            <th>Amount</th>
                            <th>Due Date</th>
                            <th>Category</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="billHistoryTableBody">
                        <!-- Bill history will be populated by JavaScript -->
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Bill Calendar Section -->
        <div class="bill-container">
            <div class="header">
                <div id="calendarInfo">
                    <p>Bill Calendar</p>
                </div>
            </div>
            <div id="billCalendar" class="calendar-grid">
                <!-- Calendar will be populated by JavaScript -->
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="../assets/js/billReminders.js"></script>
</body>
</html>
<?php
    }else{
        header('location: login.html');
    }
?>
