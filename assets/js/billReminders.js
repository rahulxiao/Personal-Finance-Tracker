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
    let upcomingBills = 0;

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
                    billItem.textContent = `${bill.name}: $${bill.amount}`;
                    billList.appendChild(billItem);
                });
                dayElement.appendChild(billList);
            }

            // Highlight today
            if (day === today.getDate() && 
                month === today.getMonth() && 
                year === today.getFullYear()) {
                dayElement.classList.add('due-today');
            }

            calendar.appendChild(dayElement);
        }
    }

    // Bill form handling
    const billForm = document.getElementById('billForm');
    if (billForm) {
        billForm.addEventListener('submit', function(event) {
            event.preventDefault();

            const billName = document.getElementById('billName').value.trim();
            const billAmount = parseFloat(document.getElementById('billAmount').value);
            const dueDate = document.getElementById('dueDate').value;
            const category = document.getElementById('billCategory').value;
            const autoPay = document.getElementById('autoPay').checked;

            // Validate inputs
            if (!billName) {
                alert('Please enter a bill name.');
                return;
            }

            if (isNaN(billAmount) || billAmount <= 0) {
                alert('Please enter a valid positive amount.');
                return;
            }

            if (!dueDate) {
                alert('Please select a due date.');
                return;
            }

            if (!category) {
                alert('Please select a category.');
                return;
            }

            // Create new bill object
            const newBill = {
                id: Date.now(),
                name: billName,
                amount: billAmount,
                dueDate: dueDate,
                category: category,
                autoPay: autoPay,
                status: 'pending'
            };

            // Add to bills array
            bills.push(newBill);

            // Update UI
            updateBillHistory();
            initializeCalendar();
            updateUpcomingBills();

            // Clear form
            billForm.reset();
        });
    }

    // Update bill history table
    function updateBillHistory() {
        const tableBody = document.getElementById('billHistoryTableBody');
        if (!tableBody) return;

        // Clear table
        tableBody.innerHTML = '';

        // Sort bills by due date
        const sortedBills = [...bills].sort((a, b) => new Date(a.dueDate) - new Date(b.dueDate));

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
                <td>$${bill.amount.toFixed(2)}</td>
                <td>${formattedDate}</td>
                <td>${bill.category}</td>
                <td>
                    <select class="status-select" onchange="updateBillStatus(${bill.id}, this.value)">
                        <option value="pending" ${bill.status === 'pending' ? 'selected' : ''}>Pending</option>
                        <option value="paid" ${bill.status === 'paid' ? 'selected' : ''}>Paid</option>
                        <option value="overdue" ${bill.status === 'overdue' ? 'selected' : ''}>Overdue</option>
                    </select>
                </td>
                <td>
                    <button class="action-btn delete-btn" onclick="deleteBill(${bill.id})">Delete</button>
                </td>
            `;
            tableBody.appendChild(row);
        });

        // Update upcoming bills after updating the table
        updateUpcomingBills();
    }

    // Update upcoming bills count
    function updateUpcomingBills() {
        const upcomingBillsElement = document.getElementById('upcomingBills');
        if (!upcomingBillsElement) return;

        const today = new Date();
        today.setHours(0, 0, 0, 0); // Reset time to start of day
        const threeDaysFromNow = new Date(today);
        threeDaysFromNow.setDate(today.getDate() + 3);

        // Filter bills that are due within next 3 days and are pending
        const upcomingBillsList = bills.filter(bill => {
            const dueDate = new Date(bill.dueDate);
            dueDate.setHours(0, 0, 0, 0); // Reset time to start of day
            return dueDate >= today && 
                   dueDate <= threeDaysFromNow && 
                   bill.status === 'pending';
        });

        upcomingBills = upcomingBillsList.length;
        upcomingBillsElement.textContent = `Upcoming Bills: ${upcomingBills}`;

        // Remove any existing alerts
        const existingAlerts = document.querySelectorAll('.alert');
        existingAlerts.forEach(alert => alert.remove());

        // Show alert only if there are upcoming bills
        if (upcomingBills > 0) {
            showAlert(`You have ${upcomingBills} bill${upcomingBills > 1 ? 's' : ''} due in the next 3 days!`, 'warning');
        }
    }

    // Show alert
    function showAlert(message, type) {
        const alertContainer = document.createElement('div');
        alertContainer.className = `alert alert-${type}`;
        alertContainer.innerHTML = `
            <i data-feather="${type === 'warning' ? 'alert-triangle' : 'alert-circle'}"></i>
            <span>${message}</span>
        `;

        const mainContent = document.querySelector('.main-content');
        mainContent.insertBefore(alertContainer, mainContent.firstChild);

        // Initialize Feather icon
        if (window.feather) feather.replace();

        // Remove alert after 5 seconds
        setTimeout(() => {
            alertContainer.remove();
        }, 5000);
    }

    // Make functions available globally
    window.updateBillStatus = function(billId, newStatus) {
        const bill = bills.find(b => b.id === billId);
        if (bill) {
            bill.status = newStatus;
            if (newStatus === 'paid') {
                bill.paymentDate = new Date().toISOString();
            }
            updateBillHistory();
            initializeCalendar();
            updateUpcomingBills();
        }
    };

    window.deleteBill = function(billId) {
        if (confirm('Are you sure you want to delete this bill?')) {
            bills = bills.filter(b => b.id !== billId);
            updateBillHistory();
            initializeCalendar();
            updateUpcomingBills();
        }
    };

    window.filterBills = function() {
        const statusFilter = document.getElementById('statusFilter').value;
        const tableBody = document.getElementById('billHistoryTableBody');
        if (!tableBody) return;

        const rows = tableBody.getElementsByTagName('tr');
        for (let row of rows) {
            const statusSelect = row.querySelector('.status-select');
            if (statusFilter === 'all' || statusSelect.value === statusFilter) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        }
    };

    // Check for overdue bills
    function checkOverdueBills() {
        const today = new Date();
        today.setHours(0, 0, 0, 0); // Reset time to start of day
        const overdueBills = bills.filter(bill => {
            const dueDate = new Date(bill.dueDate);
            dueDate.setHours(0, 0, 0, 0); // Reset time to start of day
            return dueDate < today && bill.status === 'pending';
        });

        if (overdueBills.length > 0) {
            overdueBills.forEach(bill => {
                bill.status = 'overdue';
            });
            updateBillHistory();
            showAlert(`You have ${overdueBills.length} overdue bills!`, 'danger');
        }
    }

    // Initialize everything
    initializeCalendar();
    updateBillHistory();
    updateUpcomingBills();
    checkOverdueBills();

    // Check for overdue bills every hour
    setInterval(checkOverdueBills, 3600000);
});
