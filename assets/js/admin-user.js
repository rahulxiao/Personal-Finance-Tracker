document.addEventListener('DOMContentLoaded', function() {
    // Initialize Feather Icons
    feather.replace();
    
    // Set current date
    setCurrentDate();
    
    // Initialize user search functionality
    initSearchFunctionality();
    
    // Initialize user table interactions
    initTableInteractions();
    
    // Initialize modals
    initModals();
    
    // Load sample user data (in a real app, this would fetch from an API)
    loadUserData();
});

/**
 * Sets the current date in the header
 */
function setCurrentDate() {
    const currentDateElement = document.getElementById('current-date');
    if (!currentDateElement) return;
    
    const now = new Date();
    const options = { 
        weekday: 'long', 
        year: 'numeric', 
        month: 'long', 
        day: 'numeric' 
    };
    
    currentDateElement.textContent = now.toLocaleDateString('en-US', options);
}

/**
 * Initializes the search functionality
 */
function initSearchFunctionality() {
    const searchInput = document.getElementById('user-search');
    if (!searchInput) return;
    
    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        const tableRows = document.querySelectorAll('#users-table-body tr');
        
        tableRows.forEach(row => {
            const fullName = row.querySelector('td:first-child').textContent.toLowerCase();
            const username = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
            
            if (fullName.includes(searchTerm) || username.includes(searchTerm)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
}

/**
 * Initializes table interactions like sorting and password visibility
 */
function initTableInteractions() {
    // Initialize password visibility toggles
    const passwordToggleButtons = document.querySelectorAll('.view-password-btn');
    passwordToggleButtons.forEach(button => {
        button.addEventListener('click', function() {
            const passwordField = this.parentElement;
            const maskedPassword = passwordField.querySelector('.masked-password');
            
            if (maskedPassword.textContent === '••••••••') {
                maskedPassword.textContent = 'password123'; // In a real app, this would fetch the actual password
                this.innerHTML = '<i data-feather="eye-off"></i>';
                feather.replace();
            } else {
                maskedPassword.textContent = '••••••••';
                this.innerHTML = '<i data-feather="eye"></i>';
                feather.replace();
            }
        });
    });
    
    // Initialize table sorting
    const sortableHeaders = document.querySelectorAll('.th-content');
    sortableHeaders.forEach(header => {
        header.addEventListener('click', function() {
            const columnIndex = this.closest('th').cellIndex;
            const tableBody = document.getElementById('users-table-body');
            const rows = Array.from(tableBody.querySelectorAll('tr'));
            
            // Toggle sort direction
            const currentDirection = this.getAttribute('data-direction') || 'asc';
            const newDirection = currentDirection === 'asc' ? 'desc' : 'asc';
            
            // Reset all headers
            document.querySelectorAll('.th-content').forEach(h => {
                h.setAttribute('data-direction', '');
                h.querySelector('.sort-icon').style.transform = '';
            });
            
            // Set new direction on clicked header
            this.setAttribute('data-direction', newDirection);
            this.querySelector('.sort-icon').style.transform = newDirection === 'desc' ? 'rotate(180deg)' : '';
            
            // Sort the rows
            rows.sort((a, b) => {
                let aValue = a.cells[columnIndex].textContent.trim();
                let bValue = b.cells[columnIndex].textContent.trim();
                
                // Handle numeric values (like income, expense)
                if (aValue.startsWith('$') || bValue.startsWith('$')) {
                    aValue = parseFloat(aValue.replace(/[$,]/g, ''));
                    bValue = parseFloat(bValue.replace(/[$,]/g, ''));
                }
                
                if (aValue < bValue) return newDirection === 'asc' ? -1 : 1;
                if (aValue > bValue) return newDirection === 'asc' ? 1 : -1;
                return 0;
            });
            
            // Reorder rows in the table
            rows.forEach(row => tableBody.appendChild(row));
        });
    });
    
    // Initialize action buttons
    const actionButtons = document.querySelectorAll('.table-action-btn');
    actionButtons.forEach(button => {
        button.addEventListener('click', function() {
            const action = this.getAttribute('title');
            const row = this.closest('tr');
            const userName = row.querySelector('td:first-child').textContent.trim();
            
            if (action === 'Edit') {
                showNotification(`Editing user: ${userName}`);
                // In a real app, this would open an edit modal with user data
            } else if (action === 'Delete') {
                if (confirm(`Are you sure you want to delete user: ${userName}?`)) {
                    row.remove();
                    showNotification(`User deleted: ${userName}`, 'warning');
                    updateUserStats();
                }
            }
        });
    });
}

/**
 * Initializes modal interactions
 */
function initModals() {
    const addUserBtn = document.getElementById('add-user-btn');
    const addUserModal = document.getElementById('add-user-modal');
    const closeModalBtn = document.querySelector('.close-modal');
    const cancelBtn = document.getElementById('cancel-add-user');
    const addUserForm = document.getElementById('add-user-form');
    
    // Toggle password visibility in form
    const togglePasswordBtn = document.querySelector('.toggle-password');
    if (togglePasswordBtn) {
        togglePasswordBtn.addEventListener('click', function() {
            const passwordInput = document.getElementById('password');
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            
            this.innerHTML = type === 'password' ? 
                '<i data-feather="eye"></i>' : 
                '<i data-feather="eye-off"></i>';
            feather.replace();
        });
    }
    
    // Open modal
    if (addUserBtn && addUserModal) {
        addUserBtn.addEventListener('click', function() {
            addUserModal.classList.add('active');
        });
    }
    
    // Close modal functions
    const closeModal = () => {
        if (addUserModal) {
            addUserModal.classList.remove('active');
            addUserForm.reset();
        }
    };
    
    if (closeModalBtn) closeModalBtn.addEventListener('click', closeModal);
    if (cancelBtn) cancelBtn.addEventListener('click', closeModal);
    
    // Close on click outside
    window.addEventListener('click', function(event) {
        if (event.target === addUserModal) {
            closeModal();
        }
    });
    
    // Form submission
    if (addUserForm) {
        addUserForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const fullname = document.getElementById('fullname').value;
            const username = document.getElementById('username').value;
            
            // Create a new user row
            addUserToTable({
                fullName: fullname,
                username: username,
                income: '$0.00',
                expense: '$0.00',
                net: '$0.00'
            });
            
            showNotification(`User added: ${fullname}`, 'success');
            closeModal();
            updateUserStats();
        });
    }
}

/**
 * Adds a new user to the table
 * @param {Object} user - User data object
 */
function addUserToTable(user) {
    const tableBody = document.getElementById('users-table-body');
    if (!tableBody) return;
    
    const row = document.createElement('tr');
    row.innerHTML = `
        <td>
            <div class="user-info-cell">
                <div class="user-avatar small">
                    <img src="../api/placeholder/32/32" alt="User">
                </div>
                <span>${user.fullName}</span>
            </div>
        </td>
        <td>${user.username}</td>
        <td>
            <div class="password-field">
                <span class="masked-password">••••••••</span>
                <button class="view-password-btn">
                    <i data-feather="eye"></i>
                </button>
            </div>
        </td>
        <td class="income">${user.income}</td>
        <td class="expense">${user.expense}</td>
        <td class="net">${user.net}</td>
        <td>
            <div class="action-buttons">
                <button class="table-action-btn" title="Edit">
                    <i data-feather="edit-2"></i>
                </button>
                <button class="table-action-btn" title="Delete">
                    <i data-feather="trash-2"></i>
                </button>
            </div>
        </td>
    `;
    
    tableBody.prepend(row);
    feather.replace();
    
    // Attach event listeners to new buttons
    const passwordBtn = row.querySelector('.view-password-btn');
    const actionButtons = row.querySelectorAll('.table-action-btn');
    
    if (passwordBtn) {
        passwordBtn.addEventListener('click', function() {
            const passwordField = this.parentElement;
            const maskedPassword = passwordField.querySelector('.masked-password');
            
            if (maskedPassword.textContent === '••••••••') {
                maskedPassword.textContent = 'newpassword'; // In a real app, this would be the actual password
                this.innerHTML = '<i data-feather="eye-off"></i>';
                feather.replace();
            } else {
                maskedPassword.textContent = '••••••••';
                this.innerHTML = '<i data-feather="eye"></i>';
                feather.replace();
            }
        });
    }
    
    actionButtons.forEach(button => {
        button.addEventListener('click', function() {
            const action = this.getAttribute('title');
            const row = this.closest('tr');
            const userName = row.querySelector('td:first-child').textContent.trim();
            
            if (action === 'Edit') {
                showNotification(`Editing user: ${userName}`);
            } else if (action === 'Delete') {
                if (confirm(`Are you sure you want to delete user: ${userName}?`)) {
                    row.remove();
                    showNotification(`User deleted: ${userName}`, 'warning');
                    updateUserStats();
                }
            }
        });
    });
}

/**
 * Updates the user statistics in the dashboard
 */
function updateUserStats() {
    const rows = document.querySelectorAll('#users-table-body tr');
    const totalUsers = rows.length;
    
    let totalIncome = 0;
    let totalExpense = 0;
    
    rows.forEach(row => {
        const income = parseFloat(row.querySelector('.income').textContent.replace(/[$,]/g, ''));
        const expense = parseFloat(row.querySelector('.expense').textContent.replace(/[$,]/g, ''));
        
        totalIncome += income;
        totalExpense += expense;
    });
    
    const netIncome = totalIncome - totalExpense;
    const growthPercentage = totalIncome > 0 ? (netIncome / totalIncome) * 100 : 0;
    
    // Update stats
    document.getElementById('total-users').textContent = totalUsers;
    document.getElementById('active-users').textContent = Math.ceil(totalUsers * 0.8); // 80% active as a sample
    document.getElementById('total-income').textContent = `$${totalIncome.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2})}`;
    document.getElementById('net-growth').textContent = `${growthPercentage >= 0 ? '+' : ''}${growthPercentage.toFixed(1)}%`;
}

/**
 * Loads sample user data into the table
 * In a real application, this would fetch from a database
 */
function loadUserData() {
    // Sample data is already in the HTML
    updateUserStats();
}

/**
 * Shows a notification message
 * @param {string} message - The message to display
 * @param {string} type - The type of notification (info, success, warning, error)
 */
function showNotification(message, type = 'info') {
    // Create notification element
    const notification = document.createElement('div');
    notification.className = `notification ${type}`;
    notification.textContent = message;
    
    // Style the notification
    Object.assign(notification.style, {
        position: 'fixed',
        bottom: '20px',
        right: '20px',
        padding: '12px 20px',
        backgroundColor: type === 'info' ? 'var(--accent-blue)' : 
                        type === 'success' ? 'var(--green)' : 
                        type === 'warning' ? '#ff9800' : 
                        '#f44336',
        color: 'white',
        borderRadius: '8px',
        boxShadow: '0 4px 12px rgba(0, 0, 0, 0.15)',
        zIndex: '1000',
        opacity: '0',
        transform: 'translateY(10px)',
        transition: 'opacity 0.3s ease, transform 0.3s ease'
    });
    
    // Add to body
    document.body.appendChild(notification);
    
    // Trigger animation
    setTimeout(() => {
        notification.style.opacity = '1';
        notification.style.transform = 'translateY(0)';
    }, 10);
    
    // Remove after 3 seconds
    setTimeout(() => {
        notification.style.opacity = '0';
        notification.style.transform = 'translateY(10px)';
        
        // Remove from DOM after fade out
        setTimeout(() => {
            notification.remove();
        }, 300);
    }, 3000);
}