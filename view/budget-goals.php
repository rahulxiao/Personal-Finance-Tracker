<?php
    session_start();
    if(isset($_SESSION['status'])){
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>FinanceFlow - Budget Goals</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&family=Open+Sans:wght@300;400;600;700&family=Roboto+Mono&display=swap"
        rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
    <link rel="stylesheet" href="../assets/css/feature.css" />
    <link rel="stylesheet" href="../assets/css/budget-goals.css" />
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
                    <a href="index.html"><i data-feather="home"></i> Dashboard</a>
                </li>
                <li data-page="features">
                    <a href="features.php"><i data-feather="grid"></i> Features</a>
                </li>
                <li class="active" data-page="budget-goals">
                    <a href="budget-goals.php"><i data-feather="target"></i> Budget Goals</a>
                </li>
            </ul>
        </nav>

        <main class="main-content">
            <header class="page-header">
                <h1 id="page-title">Budget Goals</h1>
                <div class="date-display" id="current-date"></div>
            </header>

            <div class="feature-content">
                <div class="page-actions">
                    <button class="back-button" onclick="window.location.href='../pages/features.php'">
                        <i data-feather="arrow-left"></i> Back to Features
                    </button>
                </div>

                <div class="feature-description">
                    <div class="feature-icon large">
                        <i data-feather="target"></i>
                    </div>
                    <h2>Set and Track Your Financial Budget Goals</h2>
                    <p>
                        Budget goals help you manage your spending and savings to achieve your financial objectives.
                        Set monthly spending limits for various categories and track your progress throughout the month.
                    </p>
                </div>

                <div id="empty-state" class="empty-state">
                    <div class="empty-state-icon"><i data-feather="target"></i></div>
                    <h3>No Budget Goals Yet</h3>
                    <p>Create your first budget goal to start tracking your financial progress</p>
                </div>

                <div class="budget-goals-container">
                    <button class="add-budget-btn">
                        <i data-feather="plus"></i> Add New Budget Goal
                    </button>
                </div>

                <div class="feature-tips">
                    <h3>Tips for Effective Budgeting</h3>
                    <ul>
                        <li><strong>Be realistic</strong> - Set attainable goals based on your actual spending habits
                        </li>
                        <li><strong>Review regularly</strong> - Check your progress weekly to stay on track</li>
                        <li><strong>Adjust as needed</strong> - Life changes, so should your budget goals</li>
                        <li><strong>Prioritize needs</strong> - Focus on essential expenses before wants</li>
                        <li><strong>Celebrate success</strong> - Acknowledge when you meet or beat your budget goals
                        </li>
                    </ul>
                </div>
            </div>
        </main>
    </div>

    <!-- Budget Goal Modal -->
    <div id="budget-goal-modal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Add New Budget Goal</h2>
                <button class="close-modal">&times;</button>
            </div>
            <form id="budget-goal-form">
                <div class="form-group">
                    <label for="goal-name">Goal Name</label>
                    <input type="text" id="goal-name" required>
                    <span class="error-message" id="goal-name-error"></span>
                </div>
                <div class="form-group">
                    <label for="goal-type">Goal Type</label>
                    <select id="goal-type" required>
                        <option value="savings">Savings</option>
                        <option value="expense">Expense</option>
                        <option value="debt">Debt Repayment</option>
                        <option value="income">Income</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="target-amount">Target Amount</label>
                    <div class="input-with-icon">
                        <span class="currency-symbol">$</span>
                        <input type="number" id="target-amount" step="0.01" min="0" required>
                        <span class="error-message" id="amount-error"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label for="current-amount">Current Amount</label>
                    <div class="input-with-icon">
                        <span class="currency-symbol">$</span>
                        <input type="number" id="current-amount" step="0.01" min="0" required>
                        <span class="error-message" id="current-amount-error"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label for="target-date">Target Date</label>
                    <input type="date" id="target-date" required>
                    <span class="error-message" id="date-error"></span>
                </div>
                <div class="form-group">
                    <label for="goal-notes">Notes (Optional)</label>
                    <textarea id="goal-notes" rows="3"></textarea>
                </div>
                <div class="form-actions">
                    <button type="button" class="btn-secondary close-modal">Cancel</button>
                    <button type="submit" class="btn-primary">Save Goal</button>
                </div>
            </form>
        </div>
    </div>

    <div id="notification-container" class="notification-container"></div>
    <script src="../assets/js/features.js"></script>
    <script src="../assets/js/budget-goal.js"></script>
</body>

</html>
<?php
    }else{
        header('location: login.html');
    }

?>