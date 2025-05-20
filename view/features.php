<?php
    session_start();
    if(isset($_SESSION['status'])){
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>FinanceFlow - Features</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&family=Open+Sans:wght@300;400;600;700&family=Roboto+Mono&display=swap"
      rel="stylesheet"
    />
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
    <link rel="stylesheet" href="../assets/css/feature.css" />
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
            <a href="##########"><i data-feather="home"></i> Dashboard</a>
          </li>
          <li class="active" data-page="features">
            <a href="features.php"><i data-feather="grid"></i> Features</a>
          </li>
          <li class="activ" data-page="features">
            <a href="../controller/logout.php">
              <i data-feather="log-out"></i> Log Out
            </a>
          </li>
        </ul>
      </nav>

      <main class="main-content">
        <header class="page-header">
          <h1 id="page-title">Financial Features</h1>
          <div class="date-display" id="current-date"></div>
        </header>

        <div class="features-grid">
          <div
            class="feature-card"
            onclick="window.location.href='Expense.php'"
          >
            <div class="feature-icon">
              <i data-feather="tag"></i>
            </div>
            <h3>Expense Categories</h3>
            <p>Organize and track spending across different categories</p>
          </div>

          <div
            class="feature-card"
            onclick="window.location.href='Income.php'"
          >
            <div class="feature-icon">
              <i data-feather="trending-up"></i>
            </div>
            <h3>Income Recording</h3>
            <p>Record and analyze your various income sources</p>
          </div>

          <div
            class="feature-card"
            onclick="window.location.href='budget-goals.php'"
          >
            <div class="feature-icon">
              <i data-feather="target"></i>
            </div>
            <h3>Budget Goals</h3>
            <p>Set and track your financial budget goals</p>
          </div>

          <div
            class="feature-card"
            onclick="window.location.href='billReminders.php'"
          >
            <div class="feature-icon">
              <i data-feather="bell"></i>
            </div>
            <h3>Bill Reminders</h3>
            <p>Never miss a payment with scheduled bill reminders</p>
          </div>

          <div
            class="feature-card"
            onclick="window.location.href='reports-graphs.php'"
          >
            <div class="feature-icon">
              <i data-feather="bar-chart-2"></i>
            </div>
            <h3>Reports/Graphs</h3>
            <p>Visualize your financial data through interactive graphs</p>
          </div>

          <div
            class="feature-card"
            onclick="window.location.href='account-linking.php'"
          >
            <div class="feature-icon">
              <i data-feather="link"></i>
            </div>
            <h3>Account Linking</h3>
            <p>Connect your bank accounts for automatic tracking</p>
          </div>

          <div
            class="feature-card"
            onclick="window.location.href='Debts.php'"
          >
            <div class="feature-icon">
              <i data-feather="trending-down"></i>
            </div>
            <h3>Debt Tracking</h3>
            <p>Monitor and plan your debt repayment strategy</p>
          </div>

          <div
            class="feature-card"
            onclick="window.location.href='savingsGoals.php'"
          >
            <div class="feature-icon">
              <i data-feather="dollar-sign"></i>
            </div>
            <h3>Savings Goals</h3>
            <p>Set and track progress toward your savings targets</p>
          </div>

          <div
            class="feature-card"
            onclick="window.location.href='tax-categories.php'"
          >
            <div class="feature-icon">
              <i data-feather="file-text"></i>
            </div>
            <h3>Tax Categories</h3>
            <p>Organize transactions for simplified tax preparation</p>
          </div>

          <div
            class="feature-card"
            onclick="window.location.href='export-data.php'"
          >
            <div class="feature-icon">
              <i data-feather="download"></i>
            </div>
            <h3>Export Data</h3>
            <p>Export your financial data in various formats</p>
          </div>
        </div>
      </main>
    </div>

    <div id="notification-container" class="notification-container"></div>
    <script src="../assets/js/features.js"></script>
  </body>
</html>

<?php
    }else{
        header('location: login.html');
    }

?>
