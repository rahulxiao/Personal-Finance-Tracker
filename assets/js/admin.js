document.addEventListener('DOMContentLoaded', function() {
    // Initialize Feather Icons
    feather.replace();
    
    // Set current date
    setCurrentDate();
    
    // Create the sales chart bars
    createSalesChart();
    
    // Add event listeners for interactive elements
    setupEventListeners();
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
 * Creates the sales chart visualization
 */
function createSalesChart() {
    const chartContainer = document.getElementById('sales-chart');
    if (!chartContainer) return;
    
    // Days for the chart
    const days = ['Sept 07', 'Sept 08', 'Sept 09', 'Sept 10', 'Sept 11', 'Sept 12'];
    
    // Sample data for the chart (heights as percentages)
    const data = [25, 60, 40, 85, 55, 45];
    
    // Clear any existing content
    chartContainer.innerHTML = '';
    
    // Create bars and labels
    days.forEach((day, index) => {
        // Create bar container
        const barContainer = document.createElement('div');
        barContainer.className = 'chart-bar-container';
        barContainer.style.flex = '1';
        barContainer.style.display = 'flex';
        barContainer.style.flexDirection = 'column';
        barContainer.style.alignItems = 'center';
        
        // Create bar
        const bar = document.createElement('div');
        bar.className = 'chart-bar';
        bar.style.width = '40px';
        bar.style.height = `${data[index]}%`;
        bar.style.backgroundColor = index === 3 ? 'var(--accent-blue)' : 'var(--hover-bg)';
        bar.style.borderRadius = '6px';
        bar.style.marginBottom = '10px';
        
        // Create label
        const label = document.createElement('div');
        label.className = 'chart-label';
        label.textContent = day;
        label.style.fontSize = '12px';
        label.style.color = 'var(--text-secondary)';
        
        // Append to container
        barContainer.appendChild(bar);
        barContainer.appendChild(label);
        chartContainer.appendChild(barContainer);
    });
}

/**
 * Sets up event listeners for interactive elements
 */
function setupEventListeners() {
    // Sidebar menu items
    const menuItems = document.querySelectorAll('.sidebar-menu li a');
    menuItems.forEach(item => {
        item.addEventListener('click', function(e) {
            // Prevent default for demo purposes
            e.preventDefault();
            
            // Remove active class from all menu items
            menuItems.forEach(menuItem => {
                menuItem.parentElement.classList.remove('active');
            });
            
            // Add active class to clicked item
            this.parentElement.classList.add('active');
            
            // Show notification
            showNotification('Menu item clicked: ' + this.querySelector('span').textContent);
        });
    });
    
    // User profile dropdown
    const userProfile = document.querySelector('.user-profile');
    if (userProfile) {
        userProfile.addEventListener('click', function() {
            showNotification('User profile clicked');
        });
    }
    
    // Action buttons
    const actionButtons = document.querySelectorAll('.download-btn, .add-btn, .icon-btn');
    actionButtons.forEach(button => {
        button.addEventListener('click', function() {
            const buttonText = this.textContent.trim() || 'Action';
            showNotification(`${buttonText} button clicked`);
        });
    });
    
    // More options buttons
    const moreButtons = document.querySelectorAll('.more-btn');
    moreButtons.forEach(button => {
        button.addEventListener('click', function() {
            showNotification('More options clicked');
        });
    });
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
                        type === 'warning' ? 'var(--yellow)' : 
                        'var(--error-color)',
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

// For demonstration, simulate data loading
setTimeout(() => {
    // Update the earnings chart to show animation when page loads
    const earningsChart = document.querySelector('.donut-chart');
    if (earningsChart) {
        earningsChart.style.transition = 'all 1s ease';
        earningsChart.style.background = 'conic-gradient(var(--accent-blue) 0% 65%, var(--yellow) 65% 90%, var(--hover-bg) 90% 100%)';
    }
}, 1000);