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

    // Global variables
    let bills = [];

    // Initialize calendar
    function initializeCalendar() {
        const calendar = document.getElementById('billCalendar');
        if (!calendar) return;

        const today = new Date();
        const year = today.getFullYear();
        const month = today.getMonth();

        // Get first day of month and total days
        const firstDay = new Date(year, month, 1);
        const lastDay = new Date(year, month + 1, 0);
        const totalDays = lastDay.getDate();
        const startingDay = firstDay.getDay();

        // Clear calendar
        calendar.innerHTML = '';

        // Add day headers
        const days = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
        days.forEach(day => {
            const dayHeader = document.createElement('div');
            dayHeader.className = 'calendar-day-header';
            dayHeader.textContent = day;
            calendar.appendChild(dayHeader);
        });

        // Add empty cells for days before first of month
        for (let i = 0; i < startingDay; i++) {
            const emptyDay = document.createElement('div');
            emptyDay.className = 'calendar-day empty';
            calendar.appendChild(emptyDay);
        }

        // Add days
        for (let day = 1; day <= totalDays; day++) {
            const dayElement = document.createElement('div');
            dayElement.className = 'calendar-day';
            dayElement.textContent = day;

            // Check if day has bills
            const currentDate = new Date(year, month, day);
            const billsOnDay = bills.filter(bill => {
                const billDate = new Date(bill.dueDate);
                return billDate.getDate() === day && 
                       billDate.getMonth() === month && 
                       billDate.getFullYear() === year;
            });

            if (billsOnDay.length > 0) {
                dayElement.classList.add('has-bill');
                const billList = document.createElement('div');
                billList.className = 'bill-list';
                billsOnDay.forEach(bill => {
                    const billItem = document.createElement('div');
                    billItem.className = 'bill-item';
                    billItem.textContent = `${bill.name}: $${parseFloat(bill.amount).toFixed(2)}`;
                    billList.appendChild(billItem);
                });
                dayElement.appendChild(billList);
            }

            // Highlight today
            if (day === today.getDate() && 
                month === today.getMonth() && 
                year === today.getFullYear()) {
                dayElement.classList.add('today');
            }

            calendar.appendChild(dayElement);
        }
    }

    // Load bills from database
    function loadBills() {
        fetch('../controller/billRemindersDB.php?type=bills')
            .then(response => response.json())
            .then(data => {
                if (Array.isArray(data)) {
                    bills = data;
                    updateBillHistory();
                    initializeCalendar();
                    updateUpcomingBills();
                } else if (data.error) {
                    showMessage('error', data.error);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showMessage('error', 'An error occurred while loading bill reminders');
            });
    }

    // Bill form handling
    const billForm = document.getElementById('billForm');
    if (billForm) {
        billForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            formData.append('type', 'bill');
            
            fetch('../controller/billRemindersDB.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showMessage('success', data.message);
                    this.reset();
                    loadBills();
                } else {
                    const errors = Array.isArray(data.errors) ? data.errors.join('<br>') : data.message;
                    showMessage('error', errors);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showMessage('error', 'An error occurred while saving the bill reminder');
            });
        });
    }

    // Update bill history table
    function updateBillHistory() {
        const tableBody = document.getElementById('billHistoryTableBody');
        if (!tableBody) return;

        // Clear table
        tableBody.innerHTML = '';

        // Sort bills by due date (most recent first)
        const sortedBills = [...bills].sort((a, b) => new Date(b.dueDate) - new Date(a.dueDate));

        // Add bills to table
        sortedBills.forEach(bill => {
            const row = document.createElement('tr');
            const dueDate = new Date(bill.dueDate);
            const formattedDate = dueDate.toLocaleDateString('en-US', {
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            });

            row.innerHTML = `
                <td>${bill.name}</td>
                <td>$${parseFloat(bill.amount).toFixed(2)}</td>
                <td>${formattedDate}</td>
                <td>${bill.category}</td>
                <td>
                    <button onclick="deleteBill(${bill.id})" class="action-btn delete-btn">
                        <i data-feather="trash-2"></i>
                    </button>
                </td>
            `;
            tableBody.appendChild(row);
        });

        // Re-initialize Feather icons
        if (window.feather) {
            feather.replace();
        }

        // Update upcoming bills count
        updateUpcomingBills();
    }

    // Update upcoming bills count
    function updateUpcomingBills() {
        const upcomingBillsElement = document.getElementById('upcomingBills');
        if (!upcomingBillsElement) return;

        const today = new Date();
        today.setHours(0, 0, 0, 0);

        const upcomingBillsList = bills.filter(bill => {
            const dueDate = new Date(bill.dueDate);
            dueDate.setHours(0, 0, 0, 0);
            return dueDate >= today;
        });

        upcomingBillsElement.textContent = `Upcoming Bills: ${upcomingBillsList.length}`;
    }

    // Show message
    function showMessage(type, message) {
        const messageDiv = document.createElement('div');
        messageDiv.className = `message ${type}-message`;
        messageDiv.textContent = message;
        
        const container = document.querySelector('#addBill');
        if (container) {
            // Remove any existing messages
            const existingMessages = container.querySelectorAll('.message');
            existingMessages.forEach(msg => msg.remove());
            
            container.insertBefore(messageDiv, container.firstChild);

            setTimeout(() => {
                if (messageDiv.parentElement) {
                    messageDiv.remove();
                }
            }, 5000);
        }
    }

    // Delete bill
    window.deleteBill = function(billId) {
        if (confirm('Are you sure you want to delete this bill reminder?')) {
            fetch(`../controller/billRemindersDB.php?type=bill&id=${billId}`, {
                method: 'DELETE'
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showMessage('success', data.message);
                    loadBills();
                } else {
                    showMessage('error', data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showMessage('error', 'An error occurred while deleting the bill reminder');
            });
        }
    };

    // Initialize everything
    loadBills();
});
