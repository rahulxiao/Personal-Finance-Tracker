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

    // Loading state management
    function setLoadingState(isLoading, elementId) {
        const element = document.getElementById(elementId);
        if (element) {
            if (isLoading) {
                element.innerHTML = '<div class="loading-spinner"></div>';
                element.classList.add('loading');
            } else {
                element.classList.remove('loading');
            }
        }
    }

    function updateGrandTotalIncome() {
        const grandTotal = window.totalIncome + window.recurringTotalIncome + window.sideHustleTotalIncome;
        const grandTotalElem = document.getElementById('grandTotalIncome');
        if (grandTotalElem) {
            grandTotalElem.textContent = `Total Income: $${grandTotal.toFixed(2)}`;
        }
    }

    // Load all income types
    async function loadAllIncomes() {
        try {
            setLoadingState(true, 'incomeTableBody');
            setLoadingState(true, 'recurringIncomeTableBody');
            setLoadingState(true, 'sideHustleIncomeTableBody');

            await Promise.all([
                loadIncomes(),
                loadRecurringIncomes(),
                loadSideHustleIncomes()
            ]);
        } catch (error) {
            console.error('Error loading incomes:', error);
            showMessage('error', 'Failed to load income data. Please try again.');
        } finally {
            setLoadingState(false, 'incomeTableBody');
            setLoadingState(false, 'recurringIncomeTableBody');
            setLoadingState(false, 'sideHustleIncomeTableBody');
        }
    }

    // Paycheck income functions
    async function loadIncomes() {
        try {
            const response = await fetch('../controller/incomeDB.php?type=paycheck');
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            const incomes = await response.json();
            
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
        } catch (error) {
            console.error('Error:', error);
            showMessage('error', 'An error occurred while loading incomes');
            throw error;
        }
    }

    // Recurring income functions
    async function loadRecurringIncomes() {
        try {
            const response = await fetch('../controller/incomeDB.php?type=recurring');
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            const incomes = await response.json();
            
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
        } catch (error) {
            console.error('Error:', error);
            showMessage('error', 'An error occurred while loading recurring incomes');
            throw error;
        }
    }

    // Side hustle income functions
    async function loadSideHustleIncomes() {
        try {
            const response = await fetch('../controller/incomeDB.php?type=sidehustle');
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            const incomes = await response.json();
            
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
        } catch (error) {
            console.error('Error:', error);
            showMessage('error', 'An error occurred while loading side hustle incomes');
            throw error;
        }
    }

    // Generic delete handler for all income types
    async function handleDelete(id, source, type) {
        const typeLabels = {
            'paycheck': 'paycheck',
            'recurring': 'recurring income',
            'sidehustle': 'side hustle income'
        };
        
        if (confirm(`Are you sure you want to delete the ${typeLabels[type]}?`)) {
            try {
                const response = await fetch(`../controller/incomeDB.php?type=${type}&id=${id}`, {
                    method: 'DELETE'
                });
                
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                
                const data = await response.json();
                
                if (data.success) {
                    showMessage('success', data.message);
                    
                    // Reload the appropriate income type
                    switch(type) {
                        case 'paycheck':
                            await loadIncomes();
                            break;
                        case 'recurring':
                            await loadRecurringIncomes();
                            break;
                        case 'sidehustle':
                            await loadSideHustleIncomes();
                            break;
                    }
                } else {
                    showMessage('error', data.message || `Error deleting ${typeLabels[type]}`);
                }
            } catch (error) {
                console.error('Error:', error);
                showMessage('error', `An error occurred while deleting the ${typeLabels[type]}`);
            }
        }
    }

    // Form submission handlers
    const paycheckForm = document.getElementById('incomeForm');
    const recurringForm = document.getElementById('recurringIncomeForm');
    const sideHustleForm = document.getElementById('sideHustleIncomeForm');

    function setupFormValidation(form, type) {
        if (!form) return;

        const sourceInput = form.querySelector('input[type="text"]');
        const submitButton = form.querySelector('input[type="submit"]');
        
        if (sourceInput) {
            sourceInput.addEventListener('input', function(e) {
                this.value = this.value.replace(/[0-9]/g, '');
            });
        }

        form.addEventListener('submit', async function(e) {
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
            
            // Disable submit button and show loading state
            submitButton.disabled = true;
            submitButton.value = 'Adding...';
            
            try {
                const formData = new FormData(this);
                formData.append('type', type);
                
                const response = await fetch('../controller/incomeDB.php', {
                    method: 'POST',
                    body: formData
                });
                
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                
                const data = await response.json();
                
                if (data.success) {
                    this.reset();
                    showMessage('success', data.message);
                    await loadAllIncomes();
                } else {
                    const errors = Array.isArray(data.errors) ? data.errors.join('<br>') : data.message;
                    showMessage('error', errors);
                }
            } catch (error) {
                console.error('Error:', error);
                showMessage('error', 'An error occurred while saving the income');
            } finally {
                // Re-enable submit button and restore original text
                submitButton.disabled = false;
                submitButton.value = type === 'paycheck' ? 'Add Income' : 
                                   type === 'recurring' ? 'Add Recurring Income' : 
                                   'Add Side Hustle Income';
            }
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