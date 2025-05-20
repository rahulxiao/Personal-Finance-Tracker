<?php
    session_start();
    if(isset($_SESSION['status'])){
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FinanceFlow - Export Data</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&family=Open+Sans:wght@300;400;600;700&family=Roboto+Mono&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
    <link rel="stylesheet" href="../assets/css/feature.css">
    <link rel="stylesheet" href="../assets/css/export-data.css">
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
                    <a href="#"><i data-feather="home"></i> Dashboard</a>
                </li>
                <li data-page="features">
                    <a href="features.php"><i data-feather="grid"></i> Features</a>
                </li>
                <li class="active" data-page="export-data">
                    <a href="export-data.php"><i data-feather="download"></i> Export Data</a>
                </li>
                <li data-page="logout">
                    <a href="../index.html"><i data-feather="log-out"></i> Log Out</a>
                </li>
            </ul>
        </nav>

        <main class="main-content">
            <header class="page-header">
                <h1 id="page-title">Export Data</h1>
                <div class="date-display" id="current-date"></div>
            </header>

            <div class="feature-content">
                <div class="page-actions">
                    <button class="back-button" onclick="window.location.href='features.php'">
                        <i data-feather="arrow-left"></i> Back to Features
                    </button>
                    <div class="export-nav-tabs">
                        <button class="export-nav-tab active" data-tab="wizard">Export Wizard</button>
                        <button class="export-nav-tab" data-tab="format">Format Selector</button>
                        <button class="export-nav-tab" data-tab="archive">Archive Manager</button>
                    </div>
                </div>

                <div class="export-tab-content">
                    <!-- Export Wizard Tab -->
                    <div class="export-tab-pane active" id="wizard-tab">
                        <div class="feature-description">
                            <div class="feature-icon large">
                                <i data-feather="download"></i>
                            </div>
                            <h2>Export Wizard</h2>
                            <p>Customize your data export with the options below.</p>
                        </div>
                        <form id="export-wizard-form" class="export-wizard-form">
                            <div class="form-group">
                                <label for="data-type">Data Type</label>
                                <select id="data-type" name="data-type" required>
                                    <option value="">Select data type</option>
                                    <option value="transactions">Transactions</option>
                                    <option value="budgets">Budgets</option>
                                    <option value="taxes">Tax Information</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="date-range">Date Range</label>
                                <select id="date-range" name="date-range" required>
                                    <option value="">Select date range</option>
                                    <option value="last-30">Last 30 Days</option>
                                    <option value="last-90">Last 90 Days</option>
                                    <option value="custom">Custom</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="start-date">Start Date</label>
                                <input type="date" id="start-date" name="start-date">
                            </div>
                            <div class="form-group">
                                <label for="end-date">End Date</label>
                                <input type="date" id="end-date" name="end-date">
                            </div>
                            <div class="form-group">
                                <label for="file-format">File Format</label>
                                <select id="file-format" name="file-format" required>
                                    <option value="">Select format</option>
                                    <option value="csv">CSV</option>
                                    <option value="pdf">PDF</option>
                                    <option value="qbo">QBO</option>
                                    <option value="json">JSON</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="file-extension">File Extension</label>
                                <input type="text" id="file-extension" name="file-extension" readonly value=".csv" placeholder=".csv">
                            </div>
                            <div class="form-group">
                                <label for="account">Account</label>
                                <select id="account" name="account" required>
                                    <option value="">Select account</option>
                                    <option value="all">All Accounts</option>
                                    <option value="checking">Checking</option>
                                    <option value="savings">Savings</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="currency">Currency</label>
                                <select id="currency" name="currency" required>
                                    <option value="">Select currency</option>
                                    <option value="usd">USD</option>
                                    <option value="eur">EUR</option>
                                    <option value="gbp">GBP</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="encryption">Encryption</label>
                                <select id="encryption" name="encryption">
                                    <option value="none">None</option>
                                    <option value="aes-256">AES-256</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="filename">File Name</label>
                                <input type="text" id="filename" name="filename" placeholder="export_data">
                            </div>
                            <div class="form-group">
                                <label for="sort-by">Sort By</label>
                                <select id="sort-by" name="sort-by">
                                    <option value="date-desc">Date (Descending)</option>
                                    <option value="date-asc">Date (Ascending)</option>
                                    <option value="amount-desc">Amount (Descending)</option>
                                    <option value="amount-asc">Amount (Ascending)</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="max-records">Max Records</label>
                                <input type="number" id="max-records" name="max-records" min="1" max="10000" placeholder="1000">
                            </div>
                            <div class="form-group">
                                <label for="language">Report Language</label>
                                <select id="language" name="language">
                                    <option value="en">English</option>
                                    <option value="es">Spanish</option>
                                    <option value="fr">French</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="timezone">Timezone</label>
                                <select id="timezone" name="timezone">
                                    <option value="UTC">UTC</option>
                                    <option value="America/New_York">America/New_York</option>
                                    <option value="Europe/London">Europe/London</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="compression">Compression</label>
                                <select id="compression" name="compression">
                                    <option value="none">None</option>
                                    <option value="zip">ZIP</option>
                                    <option value="gzip">GZIP</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="include-headers">Include Headers</label>
                                <input type="checkbox" id="include-headers" name="include-headers" checked>
                            </div>
                            <div class="form-group">
                                <label for="include-notes">Include Notes</label>
                                <input type="checkbox" id="include-notes" name="include-notes">
                            </div>
                            <button type="submit" class="export-btn">
                                <i data-feather="download"></i> Export Data
                            </button>
                        </form>
                    </div>

                    <!-- Format Selector Tab -->
                    <div class="export-tab-pane" id="format-tab">
                        <div class="feature-description">
                            <div class="feature-icon large">
                                <i data-feather="file"></i>
                            </div>
                            <h2>Choose Your Export Format</h2>
                            <p>Select the right file format for your needs. Each format has different benefits depending on how you plan to use your data.</p>
                        </div>
                        <div class="format-comparison">
                            <div class="format-table">
                                <div class="table-header">
                                    <div class="header-cell feature-column">Features</div>
                                    <div class="header-cell">CSV</div>
                                    <div class="header-cell">PDF</div>
                                    <div class="header-cell">QBO</div>
                                    <div class="header-cell">JSON</div>
                                </div>
                                <div class="table-row">
                                    <div class="feature-column">Editable</div>
                                    <div><i data-feather="check" class="icon-success"></i></div>
                                    <div><i data-feather="x" class="icon-error"></i></div>
                                    <div><i data-feather="x" class="icon-error"></i></div>
                                    <div><i data-feather="check" class="icon-success"></i></div>
                                </div>
                                <div class="table-row">
                                    <div class="feature-column">Formatted Report</div>
                                    <div><i data-feather="x" class="icon-error"></i></div>
                                    <div><i data-feather="check" class="icon-success"></i></div>
                                    <div><i data-feather="x" class="icon-error"></i></div>
                                    <div><i data-feather="x" class="icon-error"></i></div>
                                </div>
                                <div class="table-row">
                                    <div class="feature-column">Software Import</div>
                                    <div><i data-feather="check" class="icon-success"></i></div>
                                    <div><i data-feather="x" class="icon-error"></i></div>
                                    <div><i data-feather="check" class="icon-success"></i></div>
                                    <div><i data-feather="check" class="icon-success"></i></div>
                                </div>
                                <div class="table-row">
                                    <div class="feature-column">Excel Compatible</div>
                                    <div><i data-feather="check" class="icon-success"></i></div>
                                    <div><i data-feather="x" class="icon-error"></i></div>
                                    <div><i data-feather="x" class="icon-error"></i></div>
                                    <div><i data-feather="x" class="icon-error"></i></div>
                                </div>
                                <div class="table-row">
                                    <div class="feature-column">QuickBooks Compatible</div>
                                    <div><i data-feather="check" class="icon-partial"></i></div>
                                    <div><i data-feather="x" class="icon-error"></i></div>
                                    <div><i data-feather="check" class="icon-success"></i></div>
                                    <div><i data-feather="x" class="icon-error"></i></div>
                                </div>
                                <div class="table-row">
                                    <div class="feature-column">Developer Friendly</div>
                                    <div><i data-feather="check" class="icon-partial"></i></div>
                                    <div><i data-feather="x" class="icon-error"></i></div>
                                    <div><i data-feather="x" class="icon-error"></i></div>
                                    <div><i data-feather="check" class="icon-success"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="format-quick-export">
                            <h3>Quick Export</h3>
                            <p>Choose a format and click to export all your recent transactions.</p>
                            <div class="quick-export-buttons">
                                <button class="quick-export-btn csv" data-format="csv">
                                    <i data-feather="file-text"></i>
                                    <span>CSV</span>
                                </button>
                                <button class="quick-export-btn pdf" data-format="pdf">
                                    <i data-feather="file"></i>
                                    <span>PDF</span>
                                </button>
                                <button class="quick-export-btn qbo" data-format="qbo">
                                    <i data-feather="file"></i>
                                    <span>QBO</span>
                                </button>
                                <button class="quick-export-btn json" data-format="json">
                                    <i data-feather="code"></i>
                                    <span>JSON</span>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Archive Manager Tab -->
                    <div class="export-tab-pane" id="archive-tab">
                        <div class="feature-description">
                            <div class="feature-icon large">
                                <i data-feather="archive"></i>
                            </div>
                            <h2>Export History & Archives</h2>
                            <p>Access and manage your previously exported data files.</p>
                        </div>
                        <div class="archive-filter">
                            <div class="filter-options">
                                <select id="archive-filter-type">
                                    <option value="all">All Export Types</option>
                                    <option value="transactions">Transactions</option>
                                    <option value="budgets">Budgets</option>
                                    <option value="taxes">Taxes</option>
                                </select>
                                <select id="archive-filter-format">
                                    <option value="all">All Formats</option>
                                    <option value="csv">CSV</option>
                                    <option value="pdf">PDF</option>
                                    <option value="qbo">QBO</option>
                                    <option value="json">JSON</option>
                                </select>
                                <select id="archive-filter-date">
                                    <option value="all">All Dates</option>
                                    <option value="today">Today</option>
                                    <option value="week">This Week</option>
                                    <option value="month">This Month</option>
                                </select>
                                <button class="filter-btn">
                                    <i data-feather="filter"></i> Apply Filters
                                </button>
                            </div>
                            <div class="archive-search">
                                <input type="text" placeholder="Search archives..." id="archive-search">
                                <button class="search-btn">
                                    <i data-feather="search"></i>
                                </button>
                            </div>
                        </div>
                        <div class="archive-empty-state">
                            <div class="empty-state-icon">
                                <i data-feather="archive"></i>
                            </div>
                            <h3>No Export History</h3>
                            <p>You haven't exported any data yet. Use the Export Wizard to create your first export.</p>
                            <button class="goto-export-btn" onclick="switchTab('wizard')">
                                <i data-feather="arrow-right"></i> Go to Export Wizard
                            </button>
                        </div>
                        <div class="archive-table" style="display: none;">
                            <div class="table-header">
                                <div class="header-cell">Filename</div>
                                <div class="header-cell">Date</div>
                                <div class="header-cell">Type</div>
                                <div class="header-cell">Format</div>
                                <div class="header-cell">Size</div>
                                <div class="header-cell">Actions</div>
                            </div>
                            <div class="archive-rows">
                                <!-- Archive rows will be populated by JavaScript -->
                            </div>
                        </div>
                        <div class="archive-actions">
                            <button class="archive-action-btn delete-all-btn">
                                <i data-feather="trash-2"></i> Delete All Exports
                            </button>
                            <button class="archive-action-btn download-all-btn">
                                <i data-feather="download"></i> Download All as ZIP
                            </button>
                        </div>
                        <div class="storage-info">
                            <h3>Export Storage</h3>
                            <div class="storage-meter">
                                <div class="storage-used" style="width: 5%;"></div>
                            </div>
                            <p class="storage-details">Using <span class="storage-amount">5 MB</span> of <span class="storage-limit">100 MB</span></p>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <div id="notification-container" class="notification-container"></div>
    
    
    <script src="../assets/js/features.js"></script>
    <script src="../assets/js/export-data.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize Feather Icons
            feather.replace();
            
            // Set current date
            const currentDateElement = document.getElementById('current-date');
            const now = new Date();
            currentDateElement.textContent = now.toLocaleDateString('en-US', {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            });
            
            // Tab navigation
            const tabButtons = document.querySelectorAll('.export-nav-tab');
            const tabPanes = document.querySelectorAll('.export-tab-pane');
            
            tabButtons.forEach(button => {
                button.addEventListener('click', () => {
                    // Remove active class from all buttons and panes
                    tabButtons.forEach(btn => btn.classList.remove('active'));
                    tabPanes.forEach(pane => pane.classList.remove('active'));
                    
                    // Add active class to clicked button
                    button.classList.add('active');
                    
                    // Show corresponding tab pane
                    const tabId = button.getAttribute('data-tab');
                    document.getElementById(`${tabId}-tab`).classList.add('active');
                });
            });
            
            // Switch tab function for buttons
            window.switchTab = function(tabId) {
                tabButtons.forEach(btn => btn.classList.remove('active'));
                tabPanes.forEach(pane => pane.classList.remove('active'));
                
                const button = document.querySelector(`.export-nav-tab[data-tab="${tabId}"]`);
                button.classList.add('active');
                document.getElementById(`${tabId}-tab`).classList.add('active');
            };
            
            // File format change handler
            const fileFormatSelect = document.getElementById('file-format');
            const fileExtensionInput = document.getElementById('file-extension');
            
            fileFormatSelect.addEventListener('change', function() {
                const format = this.value;
                switch(format) {
                    case 'csv':
                        fileExtensionInput.value = '.csv';
                        break;
                    case 'pdf':
                        fileExtensionInput.value = '.pdf';
                        break;
                    case 'qbo':
                        fileExtensionInput.value = '.qbo';
                        break;
                    case 'json':
                        fileExtensionInput.value = '.json';
                        break;
                    default:
                        fileExtensionInput.value = '';
                }
            });
            
            // Date range change handler
            const dateRangeSelect = document.getElementById('date-range');
            const startDateInput = document.getElementById('start-date');
            const endDateInput = document.getElementById('end-date');
            
            dateRangeSelect.addEventListener('change', function() {
                const range = this.value;
                const today = new Date();
                let startDate = new Date();
                
                if (range === 'last-30') {
                    startDate.setDate(today.getDate() - 30);
                    startDateInput.value = formatDate(startDate);
                    endDateInput.value = formatDate(today);
                    startDateInput.disabled = true;
                    endDateInput.disabled = true;
                } else if (range === 'last-90') {
                    startDate.setDate(today.getDate() - 90);
                    startDateInput.value = formatDate(startDate);
                    endDateInput.value = formatDate(today);
                    startDateInput.disabled = true;
                    endDateInput.disabled = true;
                } else if (range === 'custom') {
                    startDateInput.disabled = false;
                    endDateInput.disabled = false;
                    startDateInput.value = '';
                    endDateInput.value = '';
                }
            });
            
            // Helper function to format date as YYYY-MM-DD
            function formatDate(date) {
                const year = date.getFullYear();
                const month = String(date.getMonth() + 1).padStart(2, '0');
                const day = String(date.getDate()).padStart(2, '0');
                return `${year}-${month}-${day}`;
            }
            
            // Form submission handler
            const exportForm = document.getElementById('export-wizard-form');
            exportForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                // Show notification to user
                const notification = document.createElement('div');
                notification.className = 'notification success';
                notification.innerHTML = `
                    <i data-feather="check-circle"></i>
                    <div class="notification-content">
                        <h4>Export Started</h4>
                        <p>Your data export is being processed. This may take a few moments.</p>
                    </div>
                    <button class="notification-close"><i data-feather="x"></i></button>
                `;
                
                const notificationContainer = document.getElementById('notification-container');
                notificationContainer.appendChild(notification);
                feather.replace();
                
                // Auto-remove notification after 5 seconds
                setTimeout(() => {
                    notification.classList.add('removing');
                    setTimeout(() => {
                        notification.remove();
                    }, 300);
                }, 5000);
                
                // Close button functionality
                const closeButton = notification.querySelector('.notification-close');
                closeButton.addEventListener('click', () => {
                    notification.classList.add('removing');
                    setTimeout(() => {
                        notification.remove();
                    }, 300);
                });
                
                // Simulate successful export after 2 seconds
                setTimeout(() => {
                    const successNotification = document.createElement('div');
                    successNotification.className = 'notification success';
                    successNotification.innerHTML = `
                        <i data-feather="check-circle"></i>
                        <div class="notification-content">
                            <h4>Export Complete</h4>
                            <p>Your data has been exported successfully!</p>
                        </div>
                        <button class="notification-close"><i data-feather="x"></i></button>
                    `;
                    
                    notificationContainer.appendChild(successNotification);
                    feather.replace();
                    
                    // Auto-remove notification after 5 seconds
                    setTimeout(() => {
                        successNotification.classList.add('removing');
                        setTimeout(() => {
                            successNotification.remove();
                        }, 300);
                    }, 5000);
                    
                    // Close button functionality
                    const closeSuccessButton = successNotification.querySelector('.notification-close');
                    closeSuccessButton.addEventListener('click', () => {
                        successNotification.classList.add('removing');
                        setTimeout(() => {
                            successNotification.remove();
                        }, 300);
                    });
                }, 2000);
            });
            
            // Quick export buttons
            const quickExportButtons = document.querySelectorAll('.quick-export-btn');
            quickExportButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const format = this.className.split(' ')[1]; // Get format from class
                    
                    // Show notification to user
                    const notification = document.createElement('div');
                    notification.className = 'notification success';
                    notification.innerHTML = `
                        <i data-feather="check-circle"></i>
                        <div class="notification-content">
                            <h4>Quick Export Started</h4>
                            <p>Your ${format.toUpperCase()} export is being processed.</p>
                        </div>
                        <button class="notification-close"><i data-feather="x"></i></button>
                    `;
                    
                    const notificationContainer = document.getElementById('notification-container');
                    notificationContainer.appendChild(notification);
                    feather.replace();
                    
                    // Auto-remove notification after 5 seconds
                    setTimeout(() => {
                        notification.classList.add('removing');
                        setTimeout(() => {
                            notification.remove();
                        }, 300);
                    }, 5000);
                    
                    // Close button functionality
                    const closeButton = notification.querySelector('.notification-close');
                    closeButton.addEventListener('click', () => {
                        notification.classList.add('removing');
                        setTimeout(() => {
                            notification.remove();
                        }, 300);
                    });
                });
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