<?php
    session_start();
    if(isset($_SESSION['status'])){
        require_once('../controller/billRemindersCheck.php');
        
        $errors = [];
        $success = false;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $validationResult = validateBillReminder($_POST);
            $errors = $validationResult['errors'];
            $success = $validationResult['success'];
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
                <div id="upcomingBills" style="font-size: 1.5rem; font-weight: 700; color: var(--primary-color); background: var(--card-bg); border: 2px solid var(--primary-color); border-radius: 10px; padding: 12px 28px; box-shadow: 0 2px 8px rgba(99, 102, 241, 0.08); margin-left: auto;">Upcoming Bills: 0</div>
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
                    <div class="message error-message">
                        <?php echo implode('<br>', array_map('htmlspecialchars', $errors)); ?>
                    </div>
                <?php endif; ?>

                <?php if ($success): ?>
                    <div class="message success-message">
                        Bill reminder added successfully!
                    </div>
                <?php endif; ?>

                <form id="billForm" action="../controller/billRemindersDB.php" method="POST">
                    <input type="hidden" name="type" value="bill" />
                    <input type="text" id="billName" name="billName" placeholder="Bill Name" required />
                    <input type="number" id="billAmount" name="billAmount" min="0.01" placeholder="Amount" step="0.01" required />
                    <input type="date" id="dueDate" name="dueDate" required />
                    <select id="billCategory" name="billCategory" required>
                        <option value="">Select Category</option>
                        <?php
                            $con = mysqli_connect('127.0.0.1', 'root', '', 'finance');
                            $sql = "SHOW COLUMNS FROM billreminders LIKE 'bCategories'";
                            $result = mysqli_query($con, $sql);
                            $row = mysqli_fetch_array($result);
                            $type = $row['Type'];
                            preg_match("/^enum\(\'(.*)\'\)$/", $type, $matches);
                            $values = explode("','", $matches[1]);
                            foreach($values as $value) {
                                echo "<option value='$value'>$value</option>";
                            }
                            mysqli_close($con);
                        ?>
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
            <div id="billHistoryTable">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Bill Name</th>
                            <th>Amount</th>
                            <th>Due Date</th>
                            <th>Category</th>
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
