// assets/js/income.js

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
    window.totalIncome = 0;
    window.recurringTotalIncome = 0;
    window.sideHustleTotalIncome = 0;

    function updateGrandTotalIncome() {
        const grandTotal = window.totalIncome + window.recurringTotalIncome + window.sideHustleTotalIncome;
        const grandTotalElem = document.getElementById('grandTotalIncome');
        if (grandTotalElem) {
            grandTotalElem.textContent = `Total Income: $${grandTotal.toFixed(2)}`;
        }
    }

    // Load all income types
    function loadAllIncomes() {
        loadIncomes();
        loadRecurringIncomes();
        loadSideHustleIncomes();
    }

    // Paycheck income functions
    function loadIncomes() {
        fetch('../controller/incomeDB.php?type=paycheck')
            .then(response => response.json())
            .then(incomes => {
                const tableBody = document.getElementById('incomeTableBody');
                tableBody.innerHTML = '';
                
                window.totalIncome = 0;
                
                incomes.forEach(income => {
                    const row = document.createElement('tr');
                    const actionIcon = document.createElement('button');
                    actionIcon.className = 'action-icon delete-action';
                    actionIcon.setAttribute('title', 'Delete Income');
                    actionIcon.innerHTML = '<i data-feather="trash-2"></i>';
                    
                    actionIcon.setAttribute('data-tooltip', 'Delete this income');
                    actionIcon.setAttribute('data-income-id', income.id);
                    
                    actionIcon.addEventListener('click', function() {
                        handleDelete(income.id, income.source, 'paycheck');
                    });

                    row.innerHTML = `
                        <td>${income.source}</td>
                        <td>$${parseFloat(income.amount).toFixed(2)}</td>
                        <td>${formatDate(income.date)}</td>
                        <td></td>
                    `;
                    row.cells[3].appendChild(actionIcon);
                    tableBody.appendChild(row);
                    
                    window.totalIncome += parseFloat(income.amount);
                });
                
                document.getElementById('totalIncome').textContent = `Total Paycheck: $${window.totalIncome.toFixed(2)}`;
        updateGrandTotalIncome();
                
                if (window.feather) {
                    feather.replace();
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showMessage('error', 'An error occurred while loading incomes');
            });
    }

    // Recurring income functions
    function loadRecurringIncomes() {
        fetch('../controller/incomeDB.php?type=recurring')
            .then(response => response.json())
            .then(incomes => {
                const tableBody = document.getElementById('recurringIncomeTableBody');
                tableBody.innerHTML = '';
                
                window.recurringTotalIncome = 0;
                
                incomes.forEach(income => {
                    const row = document.createElement('tr');
                    const actionIcon = document.createElement('button');
                    actionIcon.className = 'action-icon delete-action';
                    actionIcon.setAttribute('title', 'Delete Recurring Income');
                    actionIcon.innerHTML = '<i data-feather="trash-2"></i>';
                    
                    actionIcon.setAttribute('data-tooltip', 'Delete this recurring income');
                    actionIcon.setAttribute('data-income-id', income.id);
                    
                    actionIcon.addEventListener('click', function() {
                        handleDelete(income.id, income.source, 'recurring');
                    });

                    row.innerHTML = `
                        <td>${income.source}</td>
                        <td>$${parseFloat(income.amount).toFixed(2)}</td>
                        <td>${formatDate(income.date)}</td>
                        <td></td>
                    `;
                    row.cells[3].appendChild(actionIcon);
                    tableBody.appendChild(row);
                    
                    window.recurringTotalIncome += parseFloat(income.amount);
                });
                
                document.getElementById('recurringTotalIncome').textContent = `Recurring Income: $${window.recurringTotalIncome.toFixed(2)}`;
                updateGrandTotalIncome();
                
                if (window.feather) {
                    feather.replace();
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showMessage('error', 'An error occurred while loading recurring incomes');
            });
    }

    // Side hustle income functions
    function loadSideHustleIncomes() {
        fetch('../controller/incomeDB.php?type=sidehustle')
            .then(response => response.json())
            .then(incomes => {
                const tableBody = document.getElementById('sideHustleIncomeTableBody');
                tableBody.innerHTML = '';
                
                window.sideHustleTotalIncome = 0;
                
                incomes.forEach(income => {
                    const row = document.createElement('tr');
                    const actionIcon = document.createElement('button');
                    actionIcon.className = 'action-icon delete-action';
                    actionIcon.setAttribute('title', 'Delete Side Hustle Income');
                    actionIcon.innerHTML = '<i data-feather="trash-2"></i>';
                    
                    actionIcon.setAttribute('data-tooltip', 'Delete this side hustle income');
                    actionIcon.setAttribute('data-income-id', income.id);
                    
                    actionIcon.addEventListener('click', function() {
                        handleDelete(income.id, income.source, 'sidehustle');
                    });

                    row.innerHTML = `
                        <td>${income.source}</td>
                        <td>$${parseFloat(income.amount).toFixed(2)}</td>
                        <td>${formatDate(income.date)}</td>
                        <td></td>
                    `;
                    row.cells[3].appendChild(actionIcon);
                    tableBody.appendChild(row);
                    
                    window.sideHustleTotalIncome += parseFloat(income.amount);
                });
                
                document.getElementById('sideHustleTotalIncome').textContent = `Side Hustle Income: $${window.sideHustleTotalIncome.toFixed(2)}`;
        updateGrandTotalIncome();
                
                if (window.feather) {
                    feather.replace();
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showMessage('error', 'An error occurred while loading side hustle incomes');
            });
    }

    // Generic delete handler for all income types
    function handleDelete(id, source, type) {
        const typeLabels = {
            'paycheck': 'paycheck',
            'recurring': 'recurring income',
            'sidehustle': 'side hustle income'
        };
        
        if (confirm(`Are you sure you want to delete the ${typeLabels[type]} from ${source}?`)) {
            fetch(`../controller/incomeDB.php?type=${type}&id=${id}`, {
                method: 'DELETE'
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showMessage('success', data.message);
                    
                    // Reload the appropriate income type
                    switch(type) {
                        case 'paycheck':
                            loadIncomes();
                            break;
                        case 'recurring':
                            loadRecurringIncomes();
                            break;
                        case 'sidehustle':
                            loadSideHustleIncomes();
                            break;
                    }
                } else {
                    showMessage('error', data.message || `Error deleting ${typeLabels[type]}`);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showMessage('error', `An error occurred while deleting the ${typeLabels[type]}`);
            });
        }
    }

    // Form submission handlers
    const paycheckForm = document.getElementById('incomeForm');
    const recurringForm = document.getElementById('recurringIncomeForm');
    const sideHustleForm = document.getElementById('sideHustleIncomeForm');

    function setupFormValidation(form, type) {
        if (!form) return;

        const sourceInput = form.querySelector('input[type="text"]');
        if (sourceInput) {
            sourceInput.addEventListener('input', function(e) {
                this.value = this.value.replace(/[0-9]/g, '');
            });
        }

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const sourceValue = sourceInput.value.trim();
            
            if (/[0-9]/.test(sourceValue)) {
                showMessage('error', 'Income source cannot contain numbers');
                return;
            }
            
            if (!sourceValue) {
                showMessage('error', 'Please enter a valid income source');
                return;
            }
            
            const formData = new FormData(this);
            formData.append('type', type);
            
            fetch('../controller/incomeDB.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    this.reset();
                    showMessage('success', data.message);
                    loadAllIncomes();
                } else {
                    const errors = Array.isArray(data.errors) ? data.errors.join('<br>') : data.message;
                    showMessage('error', errors);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showMessage('error', 'An error occurred while saving the income');
            });
        });
    }

    // Setup form validation for all forms
    setupFormValidation(paycheckForm, 'paycheck');
    setupFormValidation(recurringForm, 'recurring');
    setupFormValidation(sideHustleForm, 'sidehustle');

    // Initial load of all incomes
    loadAllIncomes();
});

function formatDate(dateString) {
    const date = new Date(dateString);
    return date.toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    });
}

function showMessage(type, message) {
    const messageDiv = document.createElement('div');
    messageDiv.className = `message ${type}-message`;
    messageDiv.innerHTML = message;
    
    const container = document.querySelector('.income-container');
    container.insertBefore(messageDiv, container.firstChild);
    
    setTimeout(() => {
        messageDiv.remove();
    }, 5000);
}

// Add animation styles
const style = document.createElement('style');
style.textContent = `
    @keyframes fadeOut {
        from { opacity: 1; transform: translateX(0); }
        to { opacity: 0; transform: translateX(-20px); }
    }
    
    .delete-action {
        background: none;
        border: none;
        color: #dc3545;
        cursor: pointer;
        padding: 5px;
        transition: color 0.3s ease;
    }
    
    .delete-action:hover {
        color: #c82333;
    }
    
    .message {
        padding: 10px;
        margin-bottom: 10px;
        border-radius: 4px;
        animation: fadeIn 0.3s ease;
    }
    
    .success-message {
        background-color: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }
    
    .error-message {
        background-color: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }
`;
document.head.appendChild(style); 