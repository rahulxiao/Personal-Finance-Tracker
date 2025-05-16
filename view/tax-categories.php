
<?php
    session_start();
    if(isset($_SESSION['status'])){
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>FinanceFlow - Tax Categories</title>
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link
            href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&family=Open+Sans:wght@300;400;600;700&family=Roboto+Mono&display=swap"
            rel="stylesheet"
        />
        <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
        <link rel="stylesheet" href="../css/feature.css" />
        <link rel="stylesheet" href="../css/tax-categories.css" />
    </head>
    <body>
        <div class="app-container">
            <nav class="sidebar" id="sidebar">
                <div class="sidebar-header">
                    <h1>FinanceFlow</h1>
                    <button
                        id="sidebar-toggle"
                        class="sidebar-toggle mobile-only"
                    >
                        <i data-feather="menu"></i>
                    </button>
                </div>
                <ul class="sidebar-menu">
                    <li data-page="dashboard">
                        <a href="##########"
                            ><i data-feather="home"></i> Dashboard</a
                        >
                    </li>
                    <li data-page="features">
                        <a href="../pages/features.html"><i data-feather="grid"></i> Features</a>
                    </li>
                    <li class="active" data-page="features">
                        <a href="../pages/tax-categories.html"
                            > <i data-feather="file-text"></i>Tax </a
                        >
                    </li>
                </ul>
            </nav>

            <main class="main-content">
                <header class="page-header">
                    <h1 id="page-title">Tax Categories</h1>
                    <div class="date-display" id="current-date"></div>
                </header>

                <div class="feature-content">
                    <div class="page-actions">
                        <button class="back-button" onclick="window.location.href='../pages/features.html'">
                            <i data-feather="arrow-left"></i> Back to Features
                        </button>
                        
                        <div class="tax-nav-tabs">
                            <button class="tax-nav-tab active" data-tab="categories">Categories</button>
                            <button class="tax-nav-tab" data-tab="deduction-manager">Deduction Manager</button>
                            <button class="tax-nav-tab" data-tab="year-end-summary">Year-End Summary</button>
                            <button class="tax-nav-tab" data-tab="cpa-export">CPA Export</button>
                        </div>
                    </div>
                    
                    <!-- Tab Content Sections -->
                    <div class="tax-tab-content">
                        <!-- Categories Tab (default visible) -->
                        <div class="tax-tab-pane active" id="categories-tab">
                            <div class="feature-description">
                                <div class="feature-icon large">
                                    <i data-feather="file-text"></i>
                                </div>
                                <h2>Organize Your Transactions for Tax Time</h2>
                                <p>
                                    Categorize your income and expenses in tax-specific categories to make filing your taxes easier.
                                    Create custom tax categories to match your specific tax situation and reporting needs.
                                </p>
                            </div>

                            <div id="empty-state" class="empty-state">
                                <div class="empty-state-icon"><i data-feather="file-text"></i></div>
                                <h3>No Tax Categories Yet</h3>
                                <p>Create your first tax category to start organizing your finances for tax time</p>
                            </div>

                            <div class="tax-categories-container">
                                <button class="add-category-btn">
                                    <i data-feather="plus"></i> Add New Tax Category
                                </button>
                            </div>

                            <div class="feature-tips">
                                <h3>Tax Organizing Tips</h3>
                                <ul>
                                    <li><strong>Organize early</strong> - Don't wait until tax season to categorize your transactions</li>
                                    <li><strong>Be specific</strong> - Create detailed categories that match tax form line items</li>
                                    <li><strong>Track deductions</strong> - Pay special attention to possible tax deductions throughout the year</li>
                                    <li><strong>Separate business/personal</strong> - Keep business and personal expenses in different categories</li>
                                    <li><strong>Document everything</strong> - Add notes and attach receipts to support your categorizations</li>
                                </ul>
                            </div>
                        </div>

                        <!-- Deduction Manager Tab -->
                        <div class="tax-tab-pane" id="deduction-manager-tab">
                            <div class="feature-description">
                                <div class="feature-icon large">
                                    <i data-feather="tag"></i>
                                </div>
                                <h2>Manage Your Tax Deductions</h2>
                                <p>
                                    Tag expenses as tax-deductible and organize them into IRS-recognized categories.
                                    Track your potential deductions throughout the year for easier tax preparation.
                                </p>
                            </div>

                            <div class="deduction-summary-card">
                                <h3>Deduction Summary</h3>
                                <div class="deduction-year-selector">
                                    <label for="deduction-year">Tax Year:</label>
                                    <select id="deduction-year">
                                        <option value="2025">2025</option>
                                        <option value="2024">2024</option>
                                        <option value="2023">2023</option>
                                    </select>
                                </div>
                                <div class="deduction-totals">
                                    <div class="deduction-total-item">
                                        <span>Total Tagged Deductions:</span>
                                        <span class="total-amount">$0.00</span>
                                    </div>
                                    <div class="deduction-total-item">
                                        <span>Estimated Tax Savings:</span>
                                        <span class="total-amount">$0.00</span>
                                    </div>
                                </div>
                            </div>

                            <div class="deduction-categories">
                                <div class="section-header">
                                    <h3>Deduction Categories</h3>
                                    <button class="tag-expense-btn">
                                        <i data-feather="plus"></i> Tag New Expense
                                    </button>
                                </div>
                                
                                <div class="empty-deduction-state">
                                    <div class="empty-state-icon"><i data-feather="tag"></i></div>
                                    <h3>No Tagged Deductions</h3>
                                    <p>Tag your first tax-deductible expense to start tracking potential tax savings</p>
                                </div>
                                
                                <div class="deduction-list">
                                    <!-- Deduction list will be populated by JavaScript -->
                                </div>
                            </div>
                        </div>

                        <!-- Year-End Summary Tab -->
                        <div class="tax-tab-pane" id="year-end-summary-tab">
                            <div class="feature-description">
                                <div class="feature-icon large">
                                    <i data-feather="file"></i>
                                </div>
                                <h2>Year-End Tax Summary</h2>
                                <p>
                                    Get a comprehensive overview of your tax situation for the year.
                                    Generate IRS-ready reports and estimate your tax liability.
                                </p>
                            </div>

                            <div class="tax-year-selector">
                                <label for="summary-year">Tax Year:</label>
                                <select id="summary-year">
                                    <option value="2025">2025</option>
                                    <option value="2024">2024</option>
                                    <option value="2023">2023</option>
                                </select>
                                <button class="refresh-summary-btn">
                                    <i data-feather="refresh-cw"></i> Refresh Data
                                </button>
                            </div>

                            <div class="tax-summary-cards">
                                <div class="tax-summary-card income">
                                    <h3>Total Income</h3>
                                    <div class="summary-amount">$0.00</div>
                                    <div class="summary-categories">0 categories</div>
                                </div>
                                <div class="tax-summary-card deductions">
                                    <h3>Total Deductions</h3>
                                    <div class="summary-amount">$0.00</div>
                                    <div class="summary-categories">0 categories</div>
                                </div>
                                <div class="tax-summary-card credits">
                                    <h3>Tax Credits</h3>
                                    <div class="summary-amount">$0.00</div>
                                    <div class="summary-categories">0 categories</div>
                                </div>
                                <div class="tax-summary-card estimate">
                                    <h3>Estimated Tax</h3>
                                    <div class="summary-amount">$0.00</div>
                                    <button class="calculate-tax-btn">Calculate</button>
                                </div>
                            </div>

                            <div class="quarterly-tax-section">
                                <div class="section-header">
                                    <h3>Quarterly Tax Estimates</h3>
                                    <div class="quarterly-info">
                                        <i data-feather="info"></i>
                                        <span>For self-employed and business owners</span>
                                    </div>
                                </div>
                                
                                <div class="quarterly-tax-table">
                                    <div class="table-header">
                                        <div>Quarter</div>
                                        <div>Due Date</div>
                                        <div>Estimated Amount</div>
                                        <div>Status</div>
                                    </div>
                                    <div class="table-row">
                                        <div>Q1</div>
                                        <div>April 15, 2025</div>
                                        <div>$0.00</div>
                                        <div class="status pending">Pending</div>
                                    </div>
                                    <div class="table-row">
                                        <div>Q2</div>
                                        <div>June 15, 2025</div>
                                        <div>$0.00</div>
                                        <div class="status pending">Pending</div>
                                    </div>
                                    <div class="table-row">
                                        <div>Q3</div>
                                        <div>September 15, 2025</div>
                                        <div>$0.00</div>
                                        <div class="status pending">Pending</div>
                                    </div>
                                    <div class="table-row">
                                        <div>Q4</div>
                                        <div>January 15, 2026</div>
                                        <div>$0.00</div>
                                        <div class="status pending">Pending</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- CPA Export Tab -->
                        <div class="tax-tab-pane" id="cpa-export-tab">
                            <div class="feature-description">
                                <div class="feature-icon large">
                                    <i data-feather="download"></i>
                                </div>
                                <h2>Export Data for Your CPA</h2>
                                <p>
                                    Generate professional reports and data exports for your tax professional.
                                    Save time and money by providing your CPA with organized financial information.
                                </p>
                            </div>

                            <div class="export-options-container">
                                <div class="export-card">
                                    <div class="export-icon">
                                        <i data-feather="file-text"></i>
                                    </div>
                                    <h3>Tax Summary Report</h3>
                                    <p>A complete overview of all tax-related transactions for the selected year</p>
                                    <button class="export-btn">
                                        <i data-feather="download"></i> Export PDF
                                    </button>
                                </div>
                                
                                <div class="export-card">
                                    <div class="export-icon">
                                        <i data-feather="file"></i>
                                    </div>
                                    <h3>Itemized Deductions</h3>
                                    <p>Detailed list of all potential tax deductions with supporting information</p>
                                    <button class="export-btn">
                                        <i data-feather="download"></i> Export PDF
                                    </button>
                                </div>
                                
                                <div class="export-card">
                                    <div class="export-icon">
                                        <i data-feather="dollar-sign"></i>
                                    </div>
                                    <h3>Income Statement</h3>
                                    <p>Summary of all income sources categorized by tax classification</p>
                                    <button class="export-btn">
                                        <i data-feather="download"></i> Export PDF
                                    </button>
                                </div>
                                
                                <div class="export-card">
                                    <div class="export-icon">
                                        <i data-feather="file-plus"></i>
                                    </div>
                                    <h3>Custom Export</h3>
                                    <p>Create a tailored report with specific tax information for your CPA</p>
                                    <button class="export-btn">
                                        <i data-feather="settings"></i> Configure
                                    </button>
                                </div>
                            </div>

                            <div class="export-formats">
                                <h3>Available Export Formats</h3>
                                <div class="format-options">
                                    <label class="format-option">
                                        <input type="radio" name="export-format" value="pdf" checked>
                                        <span class="format-label">PDF</span>
                                    </label>
                                    <label class="format-option">
                                        <input type="radio" name="export-format" value="csv">
                                        <span class="format-label">CSV</span>
                                    </label>
                                    <label class="format-option">
                                        <input type="radio" name="export-format" value="excel">
                                        <span class="format-label">Excel</span>
                                    </label>
                                    <label class="format-option">
                                        <input type="radio" name="export-format" value="json">
                                        <span class="format-label">JSON</span>
                                    </label>
                                </div>
                            </div>

                            <div class="tax-year-export-selector">
                                <label for="export-year">Tax Year to Export:</label>
                                <select id="export-year">
                                    <option value="2025">2025</option>
                                    <option value="2024">2024</option>
                                    <option value="2023">2023</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>

        <!-- Tax Category Modal -->
        <div id="tax-category-modal" class="modal">
            <div class="modal-content">
                <div class="modal-header">
                    <h2>Add New Tax Category</h2>
                    <button class="close-modal">&times;</button>
                </div>
                <form id="tax-category-form">
                    <div class="form-group">
                        <label for="category-name">Category Name</label>
                        <input type="text" id="category-name" required>
                    </div>
                    <div class="form-group">
                        <label for="category-type">Category Type</label>
                        <select id="category-type" required>
                            <option value="income">Income</option>
                            <option value="expense">Expense</option>
                            <option value="deduction">Deduction</option>
                            <option value="credit">Tax Credit</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="tax-form-line">Tax Form Line Item (optional)</label>
                        <input type="text" id="tax-form-line" placeholder="e.g., Schedule C, Line 8">
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea id="description" rows="3"></textarea>
                    </div>
                    <div class="form-actions">
                        <button type="button" class="cancel-btn" onclick="closeTaxCategoryModal()">Cancel</button>
                        <button type="submit" class="submit-btn">Save Category</button>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Tag Expense Modal -->
        <div id="tag-expense-modal" class="modal">
            <div class="modal-content">
                <div class="modal-header">
                    <h2>Tag Tax-Deductible Expense</h2>
                    <button class="close-modal">&times;</button>
                </div>
                <form id="tag-expense-form">
                    <div class="form-group">
                        <label for="expense-name">Expense Name</label>
                        <input type="text" id="expense-name" required>
                    </div>
                    <div class="form-group">
                        <label for="expense-amount">Amount</label>
                        <div class="amount-input-wrapper">
                            <span class="currency-symbol">$</span>
                            <input type="number" id="expense-amount" step="0.01" min="0" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="expense-date">Date</label>
                        <input type="date" id="expense-date" required>
                    </div>
                    <div class="form-group">
                        <label for="deduction-category">Deduction Category</label>
                        <select id="deduction-category" required>
                            <option value="">Select a category</option>
                            <option value="business">Business Expense</option>
                            <option value="medical">Medical Expense</option>
                            <option value="charity">Charitable Contribution</option>
                            <option value="mortgage">Mortgage Interest</option>
                            <option value="education">Education Expense</option>
                            <option value="retirement">Retirement Contribution</option>
                            <option value="other">Other Deduction</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="receipt-upload">Receipt (optional)</label>
                        <input type="file" id="receipt-upload" accept="image/*,.pdf">
                        <div class="file-upload-info">Supported formats: JPG, PNG, PDF (max 5MB)</div>
                    </div>
                    <div class="form-group">
                        <label for="expense-notes">Notes</label>
                        <textarea id="expense-notes" rows="2"></textarea>
                    </div>
                    <div class="form-actions">
                        <button type="button" class="cancel-btn" onclick="closeTagExpenseModal()">Cancel</button>
                        <button type="submit" class="submit-btn">Save Expense</button>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Tax Calculation Modal -->
        <div id="tax-calculation-modal" class="modal">
            <div class="modal-content">
                <div class="modal-header">
                    <h2>Calculate Estimated Taxes</h2>
                    <button class="close-modal">&times;</button>
                </div>
                <form id="tax-calculation-form">
                    <div class="form-group">
                        <label for="filing-status">Filing Status</label>
                        <select id="filing-status" required>
                            <option value="single">Single</option>
                            <option value="married-joint">Married Filing Jointly</option>
                            <option value="married-separate">Married Filing Separately</option>
                            <option value="head">Head of Household</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="annual-income">Annual Income</label>
                        <div class="amount-input-wrapper">
                            <span class="currency-symbol">$</span>
                            <input type="number" id="annual-income" step="1000" min="0" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="withholding">Amount Already Withheld</label>
                        <div class="amount-input-wrapper">
                            <span class="currency-symbol">$</span>
                            <input type="number" id="withholding" step="100" min="0" value="0">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Additional Tax Situations</label>
                        <div class="checkbox-group">
                            <label class="checkbox-container">
                                <input type="checkbox" id="self-employed">
                                <span class="checkbox-label">Self-Employed</span>
                            </label>
                            <label class="checkbox-container">
                                <input type="checkbox" id="has-dependents">
                                <span class="checkbox-label">Have Dependents</span>
                            </label>
                            <label class="checkbox-container">
                                <input type="checkbox" id="foreign-income">
                                <span class="checkbox-label">Foreign Income</span>
                            </label>
                        </div>
                    </div>
                    <div class="form-actions">
                        <button type="button" class="cancel-btn" onclick="closeTaxCalculationModal()">Cancel</button>
                        <button type="submit" class="submit-btn">Calculate</button>
                    </div>
                </form>
            </div>
        </div>

        <div id="notification-container" class="notification-container"></div>
        <script src="../js/features.js"></script>
        <script src="../js/tax-categories.js"></script>
    </body>
</html>

<?php
    }else{
        header('location: login.html');
    }

?>