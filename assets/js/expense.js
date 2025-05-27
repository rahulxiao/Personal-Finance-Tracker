document.addEventListener('DOMContentLoaded', function() {
    // Initialize Feather Icons
    if (window.feather) feather.replace();

    // Set current date
    const currentDateElement = document.getElementById("current-date");
    if (currentDateElement) {
        const now = new Date();
        const options = { year: "numeric", month: "long", day: "numeric" };
        currentDateElement.textContent = now.toLocaleDateString("en-US", options);
    }

    // Global variables for tracking totals
    window.totalExpense = 0;
    window.categoryLimits = {};
    window.categorySpending = {};

    // Load categories and expenses
    function loadCategories() {
        fetch('../controller/expenseDB.php?type=categories')
            .then(response => response.json())
            .then(categories => {
                // Populate category select
                const categorySelect = document.getElementById('category');
                if (categorySelect) {
                    categorySelect.innerHTML = '<option value="">Select Category</option>';
                    categories.forEach(category => {
                        const option = document.createElement('option');
                        option.value = category.id;
                        option.textContent = category.name;
                        categorySelect.appendChild(option);
                        
                        // Store category budget
                        window.categoryLimits[category.name] = parseFloat(category.budget);
                        window.categorySpending[category.name] = 0;
                    });
                }

                // Initialize category cards
                const categoryList = document.querySelector('.category-list');
                if (categoryList) {
                    categoryList.innerHTML = '';
                    categories.forEach(category => {
                        addCategoryToUI(category.name, category.budget);
                    });
                }

                // After loading categories, load expenses
                loadExpenses();
            })
            .catch(error => {
                console.error('Error loading categories:', error);
                showMessage('error', 'Failed to load expense categories');
            });
    }

    function loadExpenses() {
        fetch('../controller/expenseDB.php?type=expenses')
            .then(response => response.json())
            .then(expenses => {
                const tableBody = document.getElementById('expenseTableBody');
                if (!tableBody) return;

                tableBody.innerHTML = '';
                window.totalExpense = 0;
                
                // Reset category spending
                Object.keys(window.categorySpending).forEach(category => {
                    window.categorySpending[category] = 0;
                });

                expenses.forEach(expense => {
                    const amount = parseFloat(expense.amount);
                    window.totalExpense += amount;
                    
                    // Update category spending
                    if (window.categorySpending.hasOwnProperty(expense.category)) {
                        window.categorySpending[expense.category] += amount;
                    }

                    const row = document.createElement('tr');
                    const actionIcon = document.createElement('button');
                    actionIcon.className = 'action-btn delete-btn';
                    actionIcon.innerHTML = '<i data-feather="trash-2"></i>';
                    actionIcon.setAttribute('data-expense-id', expense.id);
                    
                    actionIcon.addEventListener('click', function() {
                        handleDelete(expense.id, expense.amount, expense.category);
                    });

                    row.innerHTML = `
                        <td>$${amount.toFixed(2)}</td>
                        <td>${expense.category}</td>
                        <td>${expense.description}</td>
                        <td>${formatDate(expense.date)}</td>
                        <td></td>
                    `;
                    row.cells[4].appendChild(actionIcon);
                    tableBody.appendChild(row);
                });

                // Update UI
                updateGrandTotalExpense();
                updateAllCategoryProgress();
                
                // Re-initialize Feather icons
                if (window.feather) {
                    feather.replace();
                }
            })
            .catch(error => {
                console.error('Error loading expenses:', error);
                showMessage('error', 'Failed to load expenses');
            });
    }

    function updateGrandTotalExpense() {
        const grandTotalElem = document.getElementById('grandTotalExpense');
        if (grandTotalElem) {
            grandTotalElem.textContent = `Total Expense: $${window.totalExpense.toFixed(2)}`;
        }
    }

    function updateAllCategoryProgress() {
        Object.keys(window.categorySpending).forEach(category => {
            updateCategoryProgress(category);
        });
    }

    function updateCategoryProgress(category) {
        const categoryCard = document.getElementById(category.toLowerCase().replace(/\s+/g, '-'));
        if (categoryCard) {
            const progressBar = categoryCard.querySelector('.progress-fill');
            const spentText = categoryCard.querySelector('p:last-child');
            
            if (progressBar) {
                const percentage = (window.categorySpending[category] / window.categoryLimits[category]) * 100;
                progressBar.style.width = `${Math.min(percentage, 100)}%`;
                
                if (window.categorySpending[category] > window.categoryLimits[category]) {
                    progressBar.classList.add('over-budget');
                } else {
                    progressBar.classList.remove('over-budget');
                }
            }
            
            if (spentText) {
                const isOverBudget = window.categorySpending[category] > window.categoryLimits[category];
                spentText.textContent = `Spent: $${window.categorySpending[category].toFixed(2)}${isOverBudget ? ' (Over Budget)' : ''}`;
                spentText.style.color = isOverBudget ? 'var(--error-color)' : 'var(--text-secondary)';
            }
        }
    }

    // Form submission handler
    const form = document.getElementById('expenseForm');
    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            formData.append('type', 'expense');
            
            fetch('../controller/expenseDB.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showMessage('success', data.message);
                    this.reset();
                    loadExpenses();
                } else {
                    const errors = Array.isArray(data.errors) ? data.errors.join('<br>') : data.message;
                    showMessage('error', errors);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showMessage('error', 'An error occurred while saving the expense');
            });
        });
    }

    // Add Category Form Handler
    const addCategoryForm = document.getElementById('addCategoryForm');
    if (addCategoryForm) {
        addCategoryForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            formData.append('type', 'category');
            
            fetch('../controller/expenseDB.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showMessage('success', data.message);
                    this.reset();
                    loadCategories();
                    document.getElementById('addCategoryModal').classList.remove('show');
                } else {
                    showMessage('error', data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showMessage('error', 'An error occurred while adding the category');
            });
        });
    }

    function handleDelete(id, amount, category) {
        if (confirm('Are you sure you want to delete this expense?')) {
            fetch(`../controller/expenseDB.php?type=expense&id=${id}`, {
                method: 'DELETE'
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showMessage('success', data.message);
                    loadExpenses();
                } else {
                    showMessage('error', data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showMessage('error', 'An error occurred while deleting the expense');
            });
        }
    }

    // Modal handling
    const modal = document.getElementById('addCategoryModal');
    const addCategoryBtn = document.getElementById('addCategoryBtn');
    const closeModal = document.querySelector('.close-modal');

    if (addCategoryBtn) {
        addCategoryBtn.addEventListener('click', () => {
            modal.classList.add('show');
        });
    }

    if (closeModal) {
        closeModal.addEventListener('click', () => {
            modal.classList.remove('show');
        });
    }

    window.addEventListener('click', (event) => {
        if (event.target === modal) {
            modal.classList.remove('show');
        }
    });

    function addCategoryToUI(name, budget) {
        const categoryList = document.querySelector('.category-list');
        if (!categoryList) return;

        const categoryCard = document.createElement('div');
        categoryCard.className = 'category-card';
        categoryCard.id = name.toLowerCase().replace(/\s+/g, '-');
        categoryCard.innerHTML = `
            <h3>${name}</h3>
            <p class="limit">Budget: $${parseFloat(budget).toFixed(2)}</p>
            <div class="progress-bar">
                <div class="progress-fill" style="width: 0%"></div>
            </div>
            <p>Spent: $0.00</p>
        `;
        categoryList.appendChild(categoryCard);
    }

    function formatDate(dateString) {
        const date = new Date(dateString);
        return date.toLocaleDateString('en-US', {
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        });
    }

    function showMessage(type, message) {
        // Remove any existing messages
        const existingMessages = document.querySelectorAll('.message');
        existingMessages.forEach(msg => msg.remove());

        // Create message container
        const messageDiv = document.createElement('div');
        messageDiv.className = `message ${type}-message`;
        messageDiv.textContent = message;
        
        // Insert message at the top of the form container
        const container = document.querySelector('#addExpense');
        if (container) {
            container.insertBefore(messageDiv, container.firstChild);

            // Auto-remove after 5 seconds
            setTimeout(() => {
                if (messageDiv.parentElement) {
                    messageDiv.remove();
                }
            }, 5000);
        }
    }

    // Initialize the page
    loadCategories();
});
