// Initialize Feather Icons
document.addEventListener('DOMContentLoaded', () => {
    feather.replace();
    updateCurrentDate();
    loadAllTotals();
});

// Update current date display
function updateCurrentDate() {
    const dateDisplay = document.getElementById('current-date');
    const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
    dateDisplay.textContent = new Date().toLocaleDateString('en-US', options);
}

// Load all totals from different pages
function loadAllTotals() {
    // Load income total
    fetch('../controller/incomeDB.php?type=paycheck')
        .then(response => response.json())
        .then(incomes => {
            const paycheckTotal = incomes.reduce((sum, item) => sum + parseFloat(item.amount), 0);
            
            // Load recurring income
            fetch('../controller/incomeDB.php?type=recurring')
                .then(response => response.json())
                .then(recurringIncomes => {
                    const recurringTotal = recurringIncomes.reduce((sum, item) => sum + parseFloat(item.amount), 0);
                    
                    // Load side hustle income
                    fetch('../controller/incomeDB.php?type=sidehustle')
                        .then(response => response.json())
                        .then(sideHustleIncomes => {
                            const sideHustleTotal = sideHustleIncomes.reduce((sum, item) => sum + parseFloat(item.amount), 0);
                            
                            // Calculate total income
                            const totalIncome = paycheckTotal + recurringTotal + sideHustleTotal;
                            document.getElementById('totalIncome').textContent = formatCurrency(totalIncome);
                        });
                });
        });

    // Load expense total
    fetch('../controller/expenseDB.php?type=expenses')
        .then(response => response.json())
        .then(expenses => {
            const totalExpense = expenses.reduce((sum, item) => sum + parseFloat(item.amount), 0);
            document.getElementById('totalExpense').textContent = formatCurrency(totalExpense);
        });

    // Load debt total
    fetch('../controller/debtsDB.php?type=debts')
        .then(response => response.json())
        .then(debts => {
            const totalDebt = debts.reduce((sum, debt) => {
                const result = calculatePayoff(
                    parseFloat(debt.amount),
                    parseFloat(debt.interest),
                    parseFloat(debt.monthlyPayment)
                );
                return sum + result.totalAmount;
            }, 0);
            document.getElementById('totalDebt').textContent = formatCurrency(totalDebt);
        });

    // Load savings total
    fetch('../controller/savingsGoalsDB.php?type=savingsGoals')
        .then(response => response.json())
        .then(goals => {
            const totalSavings = goals.reduce((sum, goal) => sum + parseFloat(goal.currentAmount), 0);
            document.getElementById('totalSavings').textContent = formatCurrency(totalSavings);
        });

    // Load upcoming bills total
    fetch('../controller/billRemindersDB.php?type=bills')
        .then(response => response.json())
        .then(bills => {
            const today = new Date();
            today.setHours(0, 0, 0, 0);
            
            const upcomingBillsTotal = bills
                .filter(bill => new Date(bill.dueDate) >= today)
                .reduce((sum, bill) => sum + parseFloat(bill.amount), 0);
            
            document.getElementById('upcomingBills').textContent = formatCurrency(upcomingBillsTotal);
        });
}

// Calculate debt payoff
function calculatePayoff(principal, annualRate, monthlyPayment) {
    const monthlyRate = annualRate / 100 / 12;
    let balance = principal;
    let totalInterest = 0;
    let months = 0;
    
    if (monthlyPayment <= balance * monthlyRate) {
        return {
            totalAmount: principal
        };
    }
    
    while (balance > 0) {
        let interest = balance * monthlyRate;
        let principalPaid = monthlyPayment - interest;
        
        if (principalPaid > balance) {
            principalPaid = balance;
            interest = balance * monthlyRate;
        }
        
        balance -= principalPaid;
        totalInterest += interest;
        months++;
        
        if (months > 1000) break;
    }
    
    return {
        totalAmount: principal + totalInterest
    };
}

// Format currency
function formatCurrency(amount) {
    return new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD'
    }).format(amount);
}

// Update recent activity
function updateRecentActivity() {
    const activityList = document.getElementById('activityList');
    if (!activityList) return;

    // Fetch all recent activities
    Promise.all([
        fetch('../controller/incomeDB.php?type=paycheck').then(r => r.json()),
        fetch('../controller/expenseDB.php?type=expenses').then(r => r.json()),
        fetch('../controller/debtsDB.php?type=debts').then(r => r.json()),
        fetch('../controller/savingsGoalsDB.php?type=savingsGoals').then(r => r.json()),
        fetch('../controller/billRemindersDB.php?type=bills').then(r => r.json())
    ])
    .then(([incomes, expenses, debts, savings, bills]) => {
        // Combine all activities
        const allActivities = [
            ...incomes.map(item => ({ ...item, type: 'income', date: item.date })),
            ...expenses.map(item => ({ ...item, type: 'expense', date: item.date })),
            ...debts.map(item => ({ ...item, type: 'debt', date: item.date })),
            ...savings.map(item => ({ ...item, type: 'savings', date: item.date })),
            ...bills.map(item => ({ ...item, type: 'bill', date: item.dueDate }))
        ];

        // Sort by date (most recent first)
        allActivities.sort((a, b) => new Date(b.date) - new Date(a.date));

        // Display last 5 activities
        activityList.innerHTML = '';
        allActivities.slice(0, 5).forEach(activity => {
            const activityItem = document.createElement('div');
            activityItem.className = 'activity-item';

            const iconClass = getActivityIcon(activity.type);
            const amountClass = activity.type === 'expense' || activity.type === 'bill' ? 'negative' : 'positive';
            const amount = activity.type === 'debt' ? 
                calculatePayoff(
                    parseFloat(activity.amount),
                    parseFloat(activity.interest),
                    parseFloat(activity.monthlyPayment)
                ).totalAmount :
                parseFloat(activity.amount);

            activityItem.innerHTML = `
                <div class="activity-icon ${activity.type}">
                    <i data-feather="${iconClass}"></i>
                </div>
                <div class="activity-details">
                    <div class="activity-title">${activity.description || activity.name || activity.source}</div>
                    <div class="activity-date">${formatDate(activity.date)}</div>
                </div>
                <div class="activity-amount ${amountClass}">
                    ${activity.type === 'expense' || activity.type === 'bill' ? '-' : '+'}${formatCurrency(amount)}
                </div>
            `;

            activityList.appendChild(activityItem);
        });

        // Reinitialize Feather icons
        if (window.feather) {
            feather.replace();
        }
    })
    .catch(error => {
        console.error('Error loading activities:', error);
    });
}

// Get appropriate icon for activity type
function getActivityIcon(type) {
    const icons = {
        income: 'trending-up',
        expense: 'trending-down',
        debt: 'credit-card',
        savings: 'dollar-sign',
        bill: 'bell'
    };
    return icons[type] || 'circle';
}

// Format date
function formatDate(dateString) {
    const options = { year: 'numeric', month: 'short', day: 'numeric' };
    return new Date(dateString).toLocaleDateString('en-US', options);
}

// Initial load of recent activity
updateRecentActivity(); 