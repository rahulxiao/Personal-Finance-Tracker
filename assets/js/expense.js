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

    // Initialize categories
    const defaultCategories = [
        { name: 'Food & Dining', limit: 500 },
        { name: 'Transportation', limit: 300 },
        { name: 'Housing', limit: 1500 },
        { name: 'Utilities', limit: 200 },
        { name: 'Entertainment', limit: 200 },
        { name: 'Shopping', limit: 300 },
        { name: 'Healthcare', limit: 200 },
        { name: 'Education', limit: 300 },
        { name: 'Personal Care', limit: 100 },
        { name: 'Other', limit: 200 }
    ];

    // Initialize category limits and spending
    defaultCategories.forEach(category => {
        window.categoryLimits[category.name] = category.limit;
        window.categorySpending[category.name] = 0;
    });

    function updateGrandTotalExpense() {
        const grandTotalElem = document.getElementById('grandTotalExpense');
        if (grandTotalElem) {
            grandTotalElem.textContent = `Total Expense: $${window.totalExpense.toFixed(2)}`;
        }
    }

    function updateCategoryProgress(category) {
        const categoryCard = document.getElementById(category.toLowerCase().replace(/\s+/g, '-'));
        if (categoryCard) {
            const progressBar = categoryCard.querySelector('.progress-fill');
            const spentText = categoryCard.querySelector('p:last-child');
            
            if (progressBar) {
                const percentage = (window.categorySpending[category] / window.categoryLimits[category]) * 100;
                progressBar.style.width = `${Math.min(percentage, 100)}%`;
                
                // Add or remove over-budget class based on spending
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

    // Expense form handling
    const form = document.getElementById('expenseForm');
    const expenseInput = document.getElementById('expense');
    const categoryInput = document.getElementById('category');
    const dateInput = document.getElementById('expenseDate');
    const descriptionInput = document.getElementById('description');
    const expenseTableBody = document.getElementById('expenseTableBody');

    function addExpense(event) {
        event.preventDefault();

        const expenseValRaw = expenseInput.value.trim();
        const categoryVal = categoryInput.value;
        const dateVal = dateInput.value;
        const descriptionVal = descriptionInput.value.trim();

        const expenseVal = parseFloat(expenseValRaw);
        if (!expenseValRaw || isNaN(expenseVal) || expenseVal <= 0) {
            alert('Please enter a valid positive expense amount.');
            expenseInput.focus();
            return;
        }

        if (!categoryVal) {
            alert('Please select a category.');
            categoryInput.focus();
            return;
        }

        if (!dateVal) {
            alert('Please select a date.');
            dateInput.focus();
            return;
        }

        // Update totals
        window.totalExpense += expenseVal;
        window.categorySpending[categoryVal] += expenseVal;
        updateGrandTotalExpense();
        updateCategoryProgress(categoryVal);

        // Add to table
        const newRow = document.createElement('tr');
        const formattedDate = new Date(dateVal).toLocaleDateString('en-US', {
            day: 'numeric',
            month: 'long',
            year: 'numeric',
        });

        newRow.innerHTML = `
            <td>$${expenseVal.toFixed(2)}</td>
            <td>${categoryVal}</td>
            <td>${descriptionVal}</td>
            <td>${formattedDate}</td>
            <td>
                <button class="action-btn delete-btn" onclick="deleteExpense(this)">Delete</button>
            </td>
        `;
        expenseTableBody.appendChild(newRow);

        // Clear form
        expenseInput.value = '';
        categoryInput.value = '';
        dateInput.value = '';
        descriptionInput.value = '';
        expenseInput.focus();
    }

    if (form) {
        form.addEventListener('submit', addExpense);
    }

    // Category Manager
    function initializeCategoryManager() {
        const categoryList = document.querySelector('.category-list');
        if (!categoryList) return;

        defaultCategories.forEach(category => {
            addCategoryToUI(category.name, category.limit);
        });
    }

    function addCategoryToUI(name, limit) {
        // Add to category list
        const categoryList = document.querySelector('.category-list');
        if (categoryList) {
            const categoryCard = document.createElement('div');
            categoryCard.className = 'category-card';
            categoryCard.id = name.toLowerCase().replace(/\s+/g, '-');
            categoryCard.innerHTML = `
                <h3>${name}</h3>
                <p class="limit">Limit: $${limit}</p>
                <div class="progress-bar" id="${name.toLowerCase().replace(/\s+/g, '-')}-progress">
                    <div class="progress-fill" style="width: 0%"></div>
                </div>
                <p>Spent: $${window.categorySpending[name].toFixed(2)}</p>
            `;
            categoryList.appendChild(categoryCard);
        }

        // Add to category select
        const categorySelect = document.getElementById('category');
        if (categorySelect) {
            const option = document.createElement('option');
            option.value = name;
            option.textContent = name;
            categorySelect.appendChild(option);
        }
    }

    // Modal handling
    const modal = document.getElementById('addCategoryModal');
    const addCategoryBtn = document.getElementById('addCategoryBtn');
    const closeModal = document.querySelector('.close-modal');
    const addCategoryForm = document.getElementById('addCategoryForm');

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

    // Close modal when clicking outside
    window.addEventListener('click', (event) => {
        if (event.target === modal) {
            modal.classList.remove('show');
        }
    });

    // Handle new category form submission
    if (addCategoryForm) {
        addCategoryForm.addEventListener('submit', (event) => {
            event.preventDefault();
            
            const nameInput = document.getElementById('categoryName');
            const limitInput = document.getElementById('categoryLimit');
            
            const name = nameInput.value.trim();
            const limit = parseFloat(limitInput.value);

            if (!name) {
                alert('Please enter a category name.');
                return;
            }

            if (isNaN(limit) || limit <= 0) {
                alert('Please enter a valid positive limit amount.');
                return;
            }

            if (window.categoryLimits[name]) {
                alert('This category already exists!');
                return;
            }

            // Add new category
            window.categoryLimits[name] = limit;
            window.categorySpending[name] = 0;
            addCategoryToUI(name, limit);

            // Clear form and close modal
            nameInput.value = '';
            limitInput.value = '';
            modal.classList.remove('show');
        });
    }

    // Initialize components
    initializeCategoryManager();
});

// Global function for deleting expenses
function deleteExpense(button) {
    const row = button.closest('tr');
    const amount = parseFloat(row.cells[0].textContent.replace('$', ''));
    const category = row.cells[1].textContent;
    
    // Update totals
    window.totalExpense -= amount;
    window.categorySpending[category] -= amount;
    
    // Update UI
    const grandTotalElem = document.getElementById('grandTotalExpense');
    if (grandTotalElem) {
        grandTotalElem.textContent = `Total Expense: $${window.totalExpense.toFixed(2)}`;
    }

    // Update category progress
    const categoryCard = document.getElementById(category.toLowerCase().replace(/\s+/g, '-'));
    if (categoryCard) {
        const progressBar = categoryCard.querySelector('.progress-fill');
        const spentText = categoryCard.querySelector('p:last-child');
        
        if (progressBar) {
            const percentage = (window.categorySpending[category] / window.categoryLimits[category]) * 100;
            progressBar.style.width = `${Math.min(percentage, 100)}%`;
            
            // Update over-budget state
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
    
    // Remove the row
    row.remove();
}

// Category Management
function addCategory(name, limit) {
    if (window.categoryLimits[name]) {
        alert('Category already exists!');
        return;
    }

    window.categoryLimits[name] = limit;
    window.categorySpending[name] = 0;

    // Add to category list
    const categoryList = document.querySelector('.category-list');
    if (categoryList) {
        const categoryCard = document.createElement('div');
        categoryCard.className = 'category-card';
        categoryCard.id = name.toLowerCase().replace(/\s+/g, '-');
        categoryCard.innerHTML = `
            <h3>${name}</h3>
            <p class="limit">Limit: $${limit}</p>
            <div class="progress-bar" id="${name.toLowerCase().replace(/\s+/g, '-')}-progress">
                <div class="progress-fill" style="width: 0%"></div>
            </div>
            <p>Spent: $0.00</p>
        `;
        categoryList.appendChild(categoryCard);
    }

    // Add to category select
    const categorySelect = document.getElementById('category');
    if (categorySelect) {
        const option = document.createElement('option');
        option.value = name;
        option.textContent = name;
        categorySelect.appendChild(option);
    }
}

// Custom Rules
function addCustomRule(name, description) {
    const customRules = document.querySelector('.custom-rules');
    if (!customRules) return;

    const ruleCard = document.createElement('div');
    ruleCard.className = 'rule-card';
    ruleCard.innerHTML = `
        <h3>${name}</h3>
        <p>${description}</p>
    `;
    customRules.appendChild(ruleCard);
}
