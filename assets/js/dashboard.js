// Initialize Feather Icons
document.addEventListener('DOMContentLoaded', () => {
    feather.replace();
    updateCurrentDate();
    initializeData();
    updateDashboard();
});

// Update current date display
function updateCurrentDate() {
    const dateDisplay = document.getElementById('current-date');
    const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
    dateDisplay.textContent = new Date().toLocaleDateString('en-US', options);
}

// Sample data structure
let dashboardData = {
    income: [],
    expenses: [],
    debts: [],
    savings: [],
    bills: []
};

// Initialize with sample data
function initializeData() {
    // Sample income data
    dashboardData.income = [
        { id: 1, amount: 5000, description: 'Salary', date: '2024-03-15', category: 'Salary' },
        { id: 2, amount: 200, description: 'Freelance Work', date: '2024-03-10', category: 'Freelance' }
    ];

    // Sample expense data
    dashboardData.expenses = [
        { id: 1, amount: 1200, description: 'Rent', date: '2024-03-01', category: 'Housing' },
        { id: 2, amount: 300, description: 'Groceries', date: '2024-03-05', category: 'Food' }
    ];

    // Sample debt data
    dashboardData.debts = [
        { id: 1, amount: 15000, description: 'Student Loan', date: '2024-03-01', category: 'Education' },
        { id: 2, amount: 5000, description: 'Car Loan', date: '2024-03-15', category: 'Vehicle' }
    ];

    // Sample savings data
    dashboardData.savings = [
        { id: 1, amount: 5000, description: 'Emergency Fund', date: '2024-03-01', category: 'Emergency' },
        { id: 2, amount: 2000, description: 'Vacation Fund', date: '2024-03-10', category: 'Travel' }
    ];

    // Sample bills data
    dashboardData.bills = [
        { id: 1, amount: 100, description: 'Electric Bill', date: '2024-03-20', category: 'Utilities' },
        { id: 2, amount: 50, description: 'Internet Bill', date: '2024-03-25', category: 'Utilities' }
    ];
}

// Calculate totals
function calculateTotals() {
    const totals = {
        income: dashboardData.income.reduce((sum, item) => sum + item.amount, 0),
        expenses: dashboardData.expenses.reduce((sum, item) => sum + item.amount, 0),
        debts: dashboardData.debts.reduce((sum, item) => sum + item.amount, 0),
        savings: dashboardData.savings.reduce((sum, item) => sum + item.amount, 0),
        bills: dashboardData.bills.reduce((sum, item) => sum + item.amount, 0)
    };
    return totals;
}

// Format currency
function formatCurrency(amount) {
    return new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD'
    }).format(amount);
}

// Update dashboard display
function updateDashboard() {
    const totals = calculateTotals();

    // Update summary cards
    document.getElementById('totalIncome').textContent = formatCurrency(totals.income);
    document.getElementById('totalExpense').textContent = formatCurrency(totals.expenses);
    document.getElementById('totalDebt').textContent = formatCurrency(totals.debts);
    document.getElementById('totalSavings').textContent = formatCurrency(totals.savings);
    document.getElementById('upcomingBills').textContent = formatCurrency(totals.bills);

    // Update recent activity
    updateRecentActivity();
}

// Update recent activity section
function updateRecentActivity() {
    const activityList = document.getElementById('activityList');
    activityList.innerHTML = '';

    // Combine all activities
    const allActivities = [
        ...dashboardData.income.map(item => ({ ...item, type: 'income' })),
        ...dashboardData.expenses.map(item => ({ ...item, type: 'expense' })),
        ...dashboardData.debts.map(item => ({ ...item, type: 'debt' })),
        ...dashboardData.savings.map(item => ({ ...item, type: 'savings' })),
        ...dashboardData.bills.map(item => ({ ...item, type: 'bill' }))
    ];

    // Sort by date (most recent first)
    allActivities.sort((a, b) => new Date(b.date) - new Date(a.date));

    // Display last 5 activities
    allActivities.slice(0, 5).forEach(activity => {
        const activityItem = document.createElement('div');
        activityItem.className = 'activity-item';

        const iconClass = getActivityIcon(activity.type);
        const amountClass = activity.type === 'expense' || activity.type === 'bill' ? 'negative' : 'positive';

        activityItem.innerHTML = `
            <div class="activity-icon ${activity.type}">
                <i data-feather="${iconClass}"></i>
            </div>
            <div class="activity-details">
                <div class="activity-title">${activity.description}</div>
                <div class="activity-date">${formatDate(activity.date)}</div>
            </div>
            <div class="activity-amount ${amountClass}">
                ${activity.type === 'expense' || activity.type === 'bill' ? '-' : '+'}${formatCurrency(activity.amount)}
            </div>
        `;

        activityList.appendChild(activityItem);
    });

    // Reinitialize Feather icons for new elements
    feather.replace();
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

// Add new transaction
function addTransaction(type, data) {
    const newTransaction = {
        id: Date.now(),
        ...data,
        date: new Date().toISOString().split('T')[0]
    };

    dashboardData[type].push(newTransaction);
    updateDashboard();
}

// Remove transaction
function removeTransaction(type, id) {
    dashboardData[type] = dashboardData[type].filter(item => item.id !== id);
    updateDashboard();
}

// Update transaction
function updateTransaction(type, id, newData) {
    const index = dashboardData[type].findIndex(item => item.id === id);
    if (index !== -1) {
        dashboardData[type][index] = { ...dashboardData[type][index], ...newData };
        updateDashboard();
    }
} 