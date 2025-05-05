// Tax Categories Management and Tab Switching
document.addEventListener('DOMContentLoaded', () => {
    const tabButtons = document.querySelectorAll('.tax-nav-tab');
    const tabPanes = document.querySelectorAll('.tax-tab-pane');

    function switchTab(tabId) {
        // Remove active class from all tabs and panes
        tabButtons.forEach(tab => tab.classList.remove('active'));
        tabPanes.forEach(pane => pane.classList.remove('active'));

        // Add active class to selected tab and pane
        const selectedTab = document.querySelector(`[data-tab="${tabId}"]`);
        const selectedPane = document.getElementById(`${tabId}-tab`);
        
        if (selectedTab && selectedPane) {
            selectedTab.classList.add('active');
            selectedPane.classList.add('active');
        }
    }

    // Add click event listeners to all tab buttons
    tabButtons.forEach(button => {
        button.addEventListener('click', () => {
            const tabId = button.getAttribute('data-tab');
            switchTab(tabId);
        });
    });
});

// Modal Management and Form Validation
const taxCategoryModal = document.getElementById('tax-category-modal');
const tagExpenseModal = document.getElementById('tag-expense-modal');
const addCategoryBtn = document.querySelector('.add-category-btn');
const tagExpenseBtn = document.querySelector('.tag-expense-btn');
const closeButtons = document.querySelectorAll('.close-modal');

// Show/Hide Modal Functions
function showModal(modal) {
    if (modal) {
        modal.style.display = 'flex';
        clearFormErrors(modal);
    }
}

function hideModal(modal) {
    if (modal) {
        modal.style.display = 'none';
        clearFormErrors(modal);
    }
}

// Event Listeners for Modal Buttons
addCategoryBtn?.addEventListener('click', () => showModal(taxCategoryModal));
tagExpenseBtn?.addEventListener('click', () => showModal(tagExpenseModal));

closeButtons.forEach(button => {
    button.addEventListener('click', () => {
        const modal = button.closest('.modal');
        hideModal(modal);
    });
});

// Close modal when clicking outside
window.addEventListener('click', (e) => {
    if (e.target.classList.contains('modal')) {
        hideModal(e.target);
    }
});

// Form Validation Functions
function showError(formElement, inputId, message) {
    const input = formElement.querySelector(`#${inputId}`);
    const errorDiv = document.createElement('div');
    errorDiv.className = 'error-message';
    errorDiv.textContent = message;
    
    // Remove any existing error message
    const existingError = input.parentElement.querySelector('.error-message');
    if (existingError) {
        existingError.remove();
    }
    
    input.parentElement.appendChild(errorDiv);
    input.classList.add('error');
}

function clearFormErrors(modal) {
    const errorMessages = modal.querySelectorAll('.error-message');
    const errorInputs = modal.querySelectorAll('.error');
    errorMessages.forEach(msg => msg.remove());
    errorInputs.forEach(input => input.classList.remove('error'));
}

// Tax Category Form Validation
const taxCategoryForm = document.getElementById('tax-category-form');
taxCategoryForm?.addEventListener('submit', (e) => {
    e.preventDefault();
    clearFormErrors(taxCategoryModal);
    
    let isValid = true;
    const categoryName = document.getElementById('category-name').value.trim();
    const categoryType = document.getElementById('category-type').value;
    
    if (categoryName.length < 3) {
        showError(taxCategoryForm, 'category-name', 'Category name must be at least 3 characters long');
        isValid = false;
    }
    
    if (!categoryType) {
        showError(taxCategoryForm, 'category-type', 'Please select a category type');
        isValid = false;
    }
    
    if (isValid) {
        // Form is valid - you would typically save the data here
        hideModal(taxCategoryModal);
        showNotification('Tax category created successfully!');
    }
});

// Tag Expense Form Validation
const tagExpenseForm = document.getElementById('tag-expense-form');
tagExpenseForm?.addEventListener('submit', (e) => {
    e.preventDefault();
    clearFormErrors(tagExpenseModal);
    
    let isValid = true;
    const expenseName = document.getElementById('expense-name').value.trim();
    const amount = document.getElementById('expense-amount').value;
    const date = document.getElementById('expense-date').value;
    const category = document.getElementById('deduction-category').value;
    
    if (expenseName.length < 3) {
        showError(tagExpenseForm, 'expense-name', 'Expense name must be at least 3 characters long');
        isValid = false;
    }
    
    if (!amount || amount <= 0) {
        showError(tagExpenseForm, 'expense-amount', 'Please enter a valid amount');
        isValid = false;
    }
    
    if (!date) {
        showError(tagExpenseForm, 'expense-date', 'Please select a date');
        isValid = false;
    }
    
    if (!category) {
        showError(tagExpenseForm, 'deduction-category', 'Please select a deduction category');
        isValid = false;
    }
    
    if (isValid) {
        // Form is valid - you would typically save the data here
        hideModal(tagExpenseModal);
        showNotification('Expense tagged successfully!');
    }
});

// Notification Function
function showNotification(message, type = 'success') {
    const container = document.getElementById('notification-container');
    const notification = document.createElement('div');
    notification.className = `notification ${type}`;
    notification.textContent = message;
    
    container.appendChild(notification);
    
    // Remove notification after 3 seconds
    setTimeout(() => {
        notification.remove();
    }, 3000);
}
