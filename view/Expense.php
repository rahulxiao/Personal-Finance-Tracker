<?php
    session_start();
    if(isset($_SESSION['status'])){
        require_once('../controller/expenseCheck.php');
        
        $errors = [];
        $success = false;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $validationResult = validateExpense($_POST);
            $errors = $validationResult['errors'];
            $success = $validationResult['success'];
        }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Expense Tracker</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
    <link rel="stylesheet" href="../assets/css/expense.css" />
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            
            let totalExpense = 5000;

            const form = document.getElementById('expenseForm');
            const expenseInput = document.getElementById('expense');
            const sourceInput = document.getElementById('source');
            const totalExpenseElem = document.getElementById('totalExpense');
            const expenseTableBody = document.getElementById('expenseTableBody');

            function addExpense(event) {
                event.preventDefault();

                const expenseValRaw = expenseInput.value.trim();
                const sourceVal = sourceInput.value.trim();

                
                const expenseVal = parseFloat(expenseValRaw);
                if (!expenseValRaw || isNaN(expenseVal) || expenseVal <= 0) {
                    alert('Please enter a valid positive expense amount.');
                    expenseInput.focus();
                    return;
                }

                
                if (!sourceVal) {
                    alert('Please enter the source of expense.');
                    sourceInput.focus();
                    return;
                }

                
                totalExpense += expenseVal;
                totalExpenseElem.textContent = `Total Expense: $${totalExpense.toFixed(2)}`;

                
                const newRow = document.createElement('tr');
                const today = new Date();
                const formattedDate = today.toLocaleDateString('en-US', {
                    day: 'numeric',
                    month: 'long',
                    year: 'numeric',
                });
                newRow.innerHTML = `<td>$${expenseVal.toFixed(2)}</td><td>${formattedDate}</td><td>${sourceVal}</td>`;
                expenseTableBody.appendChild(newRow);

                
                expenseInput.value = '';
                sourceInput.value = '';
                expenseInput.focus();
            }

            if (form) {
                form.addEventListener('submit', addExpense);
            }
        });
    </script>
</head>

<body>
    <div class="sidebar">
        <div class="title">
            <p>FinanceFlow</p>
        </div>
        <p><a href="dashboard.php"><i data-feather="home"></i> Dashboard</a></p>
        <p><a href="features.php"><i data-feather="grid"></i> Features</a></p>
        <p><a href="income.php"><i data-feather="trending-up"></i> Income</a></p>
        <p><a href="expense.php" class="active"><i data-feather="trending-down"></i> Expense</a></p>
        <p><a href="Debts.php"><i data-feather="credit-card"></i> Debt Tracking</a></p>
        <p><a href="budget-goals.php"><i data-feather="target"></i> Budget Goals</a></p>
        <p><a href="billReminders.php"><i data-feather="bell"></i> Bill Reminders</a></p>
        <p><a href="savingsGoals.php"><i data-feather="dollar-sign"></i> Savings Goals</a></p>
        <p><a href="reports-graphs.php"><i data-feather="bar-chart-2"></i> Reports</a></p>
        <p><a href="../index.html"><i data-feather="log-out"></i> Log Out</a></p>
    </div>

    <main class="main-content">
        <header class="page-header">
            <h1>Expense Management</h1>
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <div class="date-display" id="current-date"></div>
                <div id="grandTotalExpense" style="font-size: 1.2rem; font-weight: 600; color: var(--error-color); margin-left: auto;">Total Expense: $0.00</div>
            </div>
        </header>

        <!-- Add Expense Form -->
        <div class="expense-container">
            <div class="header">
                <div id="expenseInfo">
                    <p>Add New Expense</p>
                </div>
            </div>

            <div id="addExpense">
                <?php if (!empty($errors)): ?>
                    <div class="error-messages">
                        <?php foreach ($errors as $error): ?>
                            <p class="error"><?php echo htmlspecialchars($error); ?></p>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <?php if ($success): ?>
                    <div class="success-message">
                        <p>Expense added successfully!</p>
                    </div>
                <?php endif; ?>

                <form id="expenseForm" action="../controller/expenseDB.php" method="POST">
                    <input type="hidden" name="type" value="expense" />
                    <input type="number" id="expense" name="expenseAmount" min= "0.01" placeholder="Amount" step="0.01" required />
                    <select id="category" name="category" required>
                        <option value="">Select Category</option>
                        <!-- Categories will be populated by JavaScript -->
                    </select>
                    <input type="text" id="description" name="description" placeholder="Description" required />
                    <input type="date" id="expenseDate" name="expenseDate" required />
                    <input type="submit" value="Add Expense" />
                </form>
            </div>
        </div>

        <!-- Recent Expenses Table -->
        <div class="expense-container">
            <div class="header">
                <div id="tableInfo">
                    <p>Recent Expenses</p>
                </div>
            </div>
            <div id="Table">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Amount</th>
                            <th>Category</th>
                            <th>Description</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="expenseTableBody">
                        <!-- Expense entries will be dynamically loaded here -->
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Category Manager -->
        <div class="expense-container">
            <div class="header">
                <div id="categoryInfo">
                    <p>Category Manager</p>
                </div>
            </div>
            <div class="category-list">
                <!-- Categories will be populated by JavaScript -->
            </div>
            <!-- Add Category Button -->
            <div class="add-category-section">
                <button id="addCategoryBtn" class="add-category-btn">
                    <i data-feather="plus"></i> Add New Category
                </button>
            </div>
        </div>
    </main>

    <!-- Add Category Modal -->
    <div id="addCategoryModal" class="modal">
        <div class="modal-content">
            <span class="close-modal">&times;</span>
            <h2>Add New Category</h2>
            <form id="addCategoryForm">
                <div class="form-group">
                    <label for="categoryName">Category Name:</label>
                    <input type="text" id="categoryName" name="categoryName" required />
                </div>
                <div class="form-group">
                    <label for="categoryLimit">Monthly Limit ($):</label>
                    <input type="number" id="categoryLimit" name="categoryLimit" step="0.01" required />
                </div>
                <button type="submit" class="submit-btn">Add Category</button>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="../assets/js/expense.js"></script>
</body>
</html>
<?php
    }else{
        header('location: login.html');
    }
?>
