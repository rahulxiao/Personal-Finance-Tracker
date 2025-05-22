<?php
    session_start();
    if(isset($_SESSION['status'])){
        $errors = [];
        $success = false;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validate goal name
            if (empty($_POST['goalName'])) {
                $errors[] = "Goal name is required";
            } elseif (strlen($_POST['goalName']) > 100) {
                $errors[] = "Goal name must be less than 100 characters";
            }

            // Validate target amount
            if (empty($_POST['targetAmount'])) {
                $errors[] = "Target amount is required";
            } elseif (!is_numeric($_POST['targetAmount']) || $_POST['targetAmount'] <= 0) {
                $errors[] = "Target amount must be a positive number";
            }

            // Validate current amount
            if (empty($_POST['currentAmount'])) {
                $errors[] = "Current amount is required";
            } elseif (!is_numeric($_POST['currentAmount']) || $_POST['currentAmount'] < 0) {
                $errors[] = "Current amount must be a non-negative number";
            }

            // Validate target date
            if (empty($_POST['targetDate'])) {
                $errors[] = "Target date is required";
            } else {
                $targetDate = strtotime($_POST['targetDate']);
                if ($targetDate === false) {
                    $errors[] = "Invalid target date format";
                } elseif ($targetDate < strtotime('today')) {
                    $errors[] = "Target date cannot be in the past";
                }
            }

            // Validate category
            if (empty($_POST['category'])) {
                $errors[] = "Category is required";
            } elseif (!in_array($_POST['category'], ['Emergency Fund', 'Vacation', 'Home', 'Car', 'Education', 'Retirement', 'Other'])) {
                $errors[] = "Invalid category selected";
            }

            // Validate monthly contribution
            if (empty($_POST['monthlyContribution'])) {
                $errors[] = "Monthly contribution is required";
            } elseif (!is_numeric($_POST['monthlyContribution']) || $_POST['monthlyContribution'] <= 0) {
                $errors[] = "Monthly contribution must be a positive number";
            }

            // If no errors, process the form
            if (empty($errors)) {
                $success = true;
                // Here you would typically save to database
                // For now, we'll just show success message
            }
        }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Savings Goals</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
    <link rel="stylesheet" href="../assets/css/savingsGoals.css" />
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
        <p><a href="savingsGoals.php" class="active"><i data-feather="dollar-sign"></i> Savings Goals</a></p>
        <p><a href="reports-graphs.php"><i data-feather="bar-chart-2"></i> Reports</a></p>
        <p><a href="../index.html"><i data-feather="log-out"></i> Log Out</a></p>
    </div>

    <main class="main-content">
        <header class="page-header">
            <h1>Savings Goals</h1>
            <div class="header-stats">
                <div class="stat-card">
                    <i data-feather="target"></i>
                    <div class="stat-info">
                        <span class="stat-value" id="totalGoals">0</span>
                        <span class="stat-label">Active Goals</span>
                    </div>
                </div>
                <div class="stat-card">
                    <i data-feather="dollar-sign"></i>
                    <div class="stat-info">
                        <span class="stat-value" id="totalSaved">$0</span>
                        <span class="stat-label">Total Saved</span>
                    </div>
                </div>
                <div class="stat-card">
                    <i data-feather="award"></i>
                    <div class="stat-info">
                        <span class="stat-value" id="completedGoals">0</span>
                        <span class="stat-label">Completed Goals</span>
                    </div>
                </div>
            </div>
        </header>

        <!-- Goal Visualizer Section -->
        <div class="goal-container">
            <div class="header">
                <div class="section-title">
                    <i data-feather="target"></i>
                    <h2>Goal Visualizer</h2>
                </div>
                <button class="add-goal-btn" onclick="showAddGoalModal()">
                    <i data-feather="plus"></i> Add New Goal
                </button>
            </div>
            <div class="goals-grid" id="goalsGrid">
                <!-- Goals will be populated by JavaScript -->
            </div>
        </div>

        <!-- Milestone Tracker Section -->
        <div class="goal-container">
            <div class="header">
                <div class="section-title">
                    <i data-feather="award"></i>
                    <h2>Milestone Tracker</h2>
                </div>
            </div>
            <div class="milestones-container" id="milestonesContainer">
                <!-- Milestones will be populated by JavaScript -->
            </div>
        </div>
    </main>

    <!-- Add Goal Modal -->
    <div class="modal" id="addGoalModal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Add New Savings Goal</h2>
                <button class="close-btn" onclick="hideAddGoalModal()">
                    <i data-feather="x"></i>
                </button>
            </div>
            <form id="addGoalForm">
                <div class="form-group">
                    <label for="goalName">Goal Name</label>
                    <input type="text" id="goalName" name="goalName" required>
                </div>
                <div class="form-group">
                    <label for="targetAmount">Target Amount</label>
                    <input type="number" id="targetAmount" name="targetAmount" min= "0.01" step="0.01" required>
                </div>
                <div class="form-group">
                    <label for="currentAmount">Current Amount</label>
                    <input type="number" id="currentAmount" name="currentAmount" min= "0" step="0.01" required>
                </div>
                <div class="form-group">
                    <label for="targetDate">Target Date</label>
                    <input type="date" id="targetDate" name="targetDate" required>
                </div>
                <div class="form-group">
                    <label for="category">Category</label>
                    <select id="category" name="category" required>
                        <option value="">Select Category</option>
                        <option value="Emergency Fund">Emergency Fund</option>
                        <option value="Vacation">Vacation</option>
                        <option value="Home">Home</option>
                        <option value="Car">Car</option>
                        <option value="Education">Education</option>
                        <option value="Retirement">Retirement</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="monthlyContribution">Monthly Contribution</label>
                    <input type="number" id="monthlyContribution" name="monthlyContribution" min="0" step="0.01" required>
                </div>
                <button type="submit" class="submit-btn">Create Goal</button>
            </form>
        </div>
    </div>

    <!-- Celebration Modal -->
    <div class="modal" id="celebrationModal">
        <div class="modal-content celebration">
            <div class="celebration-content">
                <i data-feather="award" class="celebration-icon"></i>
                <h2>Goal Achieved!</h2>
                <p id="celebrationMessage"></p>
                <button class="celebration-btn" onclick="hideCelebrationModal()">Continue</button>
            </div>
        </div>
    </div>

    <script src="../assets/js/savingsGoals.js"></script>
</body>
</html>
<?php
    }else{
        header('location: login.html');
    }
?>
