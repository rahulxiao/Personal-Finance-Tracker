<?php
    session_start();
    if(isset($_SESSION['status'])){
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>FinanceFlow - Reports & Graphs</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&family=Open+Sans:wght@300;400;600;700&family=Roboto+Mono&display=swap"
      rel="stylesheet"
    />
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
    <script
      type="text/javascript"
      src="https://www.gstatic.com/charts/loader.js"
    ></script>
    <link rel="stylesheet" href="../assets/css/feature.css" />
    <link rel="stylesheet" href="../assets/css/reports-graphs.css" />
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
            <a href="########"><i data-feather="home"></i> Dashboard</a>
          </li>
          <li class="ac" data-page="features">
            <a href="features.php"
              ><i data-feather="grid"></i> Features</a
            >
          </li>
          <li class="active" data-page="features">
            <a href="reports-graphs.php"
              ><i data-feather="bar-chart-2"></i> Reports & Graphs</a
            >
          </li>
        </ul>
      </nav>

      <main class="main-content">
        <header class="page-header">
          <h1 id="page-title">Reports & Graphs</h1>
          <div class="date-display" id="current-date"></div>
        </header>

        <div class="feature-content">
          <div class="page-actions">
            <button
              class="back-button"
              onclick="window.location.href='../pages/features.html'"
            >
              <i data-feather="arrow-left"></i> Back to Features
            </button>
          </div>

          <div class="feature-description">
            <div class="feature-icon large">
              <i data-feather="bar-chart-2"></i>
            </div>
            <h2>Financial Analytics Dashboard</h2>
            <p>
              Visualize your financial data with interactive charts and graphs.
              Track income, expenses, and savings trends over time to make
              informed financial decisions.
            </p>
          </div>

          <!-- Financial Overview Cards -->
          <div class="overview-section">
            <h3 class="section-title">Financial Overview</h3>
            <div class="stats-cards">
              <div class="stats-card income">
                <div class="stats-icon">
                  <i data-feather="trending-up"></i>
                </div>
                <div class="stats-info">
                  <h4>Total Income</h4>
                  <div class="stats-value">$5,200</div>
                  <div class="stats-change positive">
                    <i data-feather="arrow-up"></i> 8.3% vs last month
                  </div>
                </div>
              </div>

              <div class="stats-card expenses">
                <div class="stats-icon">
                  <i data-feather="trending-down"></i>
                </div>
                <div class="stats-info">
                  <h4>Total Expenses</h4>
                  <div class="stats-value">$4,100</div>
                  <div class="stats-change negative">
                    <i data-feather="arrow-up"></i> 5.1% vs last month
                  </div>
                </div>
              </div>

              <div class="stats-card savings">
                <div class="stats-icon">
                  <i data-feather="dollar-sign"></i>
                </div>
                <div class="stats-info">
                  <h4>Net Savings</h4>
                  <div class="stats-value">$1,100</div>
                  <div class="stats-change positive">
                    <i data-feather="arrow-up"></i> 22.2% vs last month
                  </div>
                </div>
              </div>

              <div class="stats-card balance">
                <div class="stats-icon">
                  <i data-feather="credit-card"></i>
                </div>
                <div class="stats-info">
                  <h4>Current Balance</h4>
                  <div class="stats-value">$12,450</div>
                  <div class="stats-change positive">
                    <i data-feather="arrow-up"></i> 9.7% vs last month
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Chart Sections -->
          <div class="charts-container">
            <!-- Monthly Finances Chart -->
            <div class="chart-card">
              <div class="chart-header">
                <h3>Monthly Finances</h3>
                <p>Income vs. expenses for the last 6 months</p>
                <div class="chart-actions">
                  <button class="chart-btn">
                    <i data-feather="download"></i>
                  </button>
                  <button class="chart-btn">
                    <i data-feather="maximize-2"></i>
                  </button>
                </div>
              </div>
              <div class="chart-body" id="monthlyChart"></div>
            </div>

            <!-- Expense Breakdown Chart -->
            <div class="chart-card">
              <div class="chart-header">
                <h3>Expense Breakdown</h3>
                <p>Where your money goes</p>
                <div class="chart-actions">
                  <button class="chart-btn">
                    <i data-feather="download"></i>
                  </button>
                  <button class="chart-btn">
                    <i data-feather="maximize-2"></i>
                  </button>
                </div>
              </div>
              <div class="chart-body" id="expenseChart"></div>
            </div>

            <!-- Income Sources Chart -->
            <div class="chart-card">
              <div class="chart-header">
                <h3>Income Sources</h3>
                <p>Where your money comes from</p>
                <div class="chart-actions">
                  <button class="chart-btn">
                    <i data-feather="download"></i>
                  </button>
                  <button class="chart-btn">
                    <i data-feather="maximize-2"></i>
                  </button>
                </div>
              </div>
              <div class="chart-body" id="incomeChart"></div>
            </div>

            <!-- Transaction Trends Chart -->
            <div class="chart-card">
              <div class="chart-header">
                <h3>Transaction Trends</h3>
                <p>Income and expense patterns over time</p>
                <div class="chart-actions">
                  <button class="chart-btn">
                    <i data-feather="download"></i>
                  </button>
                  <button class="chart-btn">
                    <i data-feather="maximize-2"></i>
                  </button>
                </div>
              </div>
              <div class="chart-body" id="trendsChart"></div>
            </div>
          </div>
        </div>
      </main>
    </div>

    <div id="notification-container" class="notification-container"></div>
    <script src="../assets/js/features.js"></script>
    <script src="../assets/js/reports-graphs.js"></script>
    <script>
      document.addEventListener("DOMContentLoaded", function () {
        // Initialize Feather Icons
        feather.replace();

        // Set current date
        const currentDateElement = document.getElementById("current-date");
        const now = new Date();
        currentDateElement.textContent = now.toLocaleDateString("en-US", {
          weekday: "long",
          year: "numeric",
          month: "long",
          day: "numeric",
        });
      });
    </script>
  </body>
</html>


<?php
    }else{
        header('location: login.html');
    }

?>