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

    // Income form handling
    const form = document.getElementById('incomeForm');
    const incomeInput = document.getElementById('income');
    const sourceInput = document.getElementById('source');
    const totalIncomeElem = document.getElementById('totalIncome');
    const incomeTableBody = document.getElementById('incomeTableBody');
    let totalIncome = 0;
    let recurringTotalIncome = 0;
    let sideHustleTotalIncome = 0;

    function updateGrandTotalIncome() {
        const grandTotal = totalIncome + recurringTotalIncome + sideHustleTotalIncome;
        const grandTotalElem = document.getElementById('grandTotalIncome');
        if (grandTotalElem) {
            grandTotalElem.textContent = `Total Income: $${grandTotal.toFixed(2)}`;
        }
    }

    function addIncome(event) {
        event.preventDefault();

        const incomeValRaw = incomeInput.value.trim();
        const sourceVal = sourceInput.value.trim();

        const incomeVal = parseFloat(incomeValRaw);
        if (!incomeValRaw || isNaN(incomeVal) || incomeVal <= 0) {
            alert('Please enter a valid positive income amount.');
            incomeInput.focus();
            return;
        }

        if (!sourceVal) {
            alert('Please enter the source of income.');
            sourceInput.focus();
            return;
        }

        totalIncome += incomeVal;
        totalIncomeElem.textContent = `Total Paycheck: $${totalIncome.toFixed(2)}`;

        const newRow = document.createElement('tr');
        const today = new Date();
        const formattedDate = today.toLocaleDateString('en-US', {
            day: 'numeric',
            month: 'long',
            year: 'numeric',
        });

        newRow.innerHTML = `
            <td>${sourceVal}</td>
            <td>$${incomeVal.toFixed(2)}</td>
            <td>${formattedDate}</td>
            <td>
                <button class="edit-btn" onclick="editIncome(this)">Edit</button>
                <button class="delete-btn" onclick="deleteIncome(this)">Delete</button>
            </td>
        `;
        incomeTableBody.appendChild(newRow);

        incomeInput.value = '';
        sourceInput.value = '';
        incomeInput.focus();

        // Update grand total
        updateGrandTotalIncome();
    }

    if (form) {
        form.addEventListener('submit', addIncome);
    }

    // Recurring Income form handling
    const recurringForm = document.getElementById('recurringIncomeForm');
    const recurringSourceInput = document.getElementById('recurringSource');
    const recurringAmountInput = document.getElementById('recurringAmount');
    const recurringDateInput = document.getElementById('recurringDate');
    const recurringIncomeTableBody = document.getElementById('recurringIncomeTableBody');
    const recurringTotalIncomeElem = document.getElementById('recurringTotalIncome');

    function addRecurringIncome(event) {
        event.preventDefault();

        const sourceVal = recurringSourceInput.value.trim();
        const amountValRaw = recurringAmountInput.value.trim();
        const dateVal = recurringDateInput.value;
        const amountVal = parseFloat(amountValRaw);

        if (!sourceVal) {
            alert('Please enter the source of recurring income.');
            recurringSourceInput.focus();
            return;
        }
        if (!amountValRaw || isNaN(amountVal) || amountVal <= 0) {
            alert('Please enter a valid positive amount.');
            recurringAmountInput.focus();
            return;
        }
        if (!dateVal) {
            alert('Please select a date.');
            recurringDateInput.focus();
            return;
        }

        recurringTotalIncome += amountVal;
        if (recurringTotalIncomeElem) {
            recurringTotalIncomeElem.textContent = `Recurring Income: $${recurringTotalIncome.toFixed(2)}`;
        }

        // Format date to match Paycheck section
        const formattedDate = new Date(dateVal).toLocaleDateString('en-US', {
            day: 'numeric',
            month: 'long',
            year: 'numeric',
        });

        const newRow = document.createElement('tr');
        newRow.innerHTML = `
            <td>${sourceVal}</td>
            <td>$${amountVal.toFixed(2)}</td>
            <td>${formattedDate}</td>
            <td></td>
        `;
        recurringIncomeTableBody.appendChild(newRow);

        recurringSourceInput.value = '';
        recurringAmountInput.value = '';
        recurringDateInput.value = '';
        recurringSourceInput.focus();

        // Update grand total
        updateGrandTotalIncome();
    }

    if (recurringForm) {
        recurringForm.addEventListener('submit', addRecurringIncome);
    }

    // Side Hustle Income form handling
    function addSideHustleIncome(event) {
        event.preventDefault();

        const sourceInput = document.getElementById('sideHustleSource');
        const amountInput = document.getElementById('sideHustleAmount');
        const dateInput = document.getElementById('sideHustleDate');
        const tableBody = document.getElementById('sideHustleIncomeTableBody');
        const totalElem = document.getElementById('sideHustleTotalIncome');

        const sourceVal = sourceInput.value.trim();
        const amountValRaw = amountInput.value.trim();
        const dateVal = dateInput.value;
        const amountVal = parseFloat(amountValRaw);

        if (!sourceVal) {
            alert('Please enter the source of side hustle income.');
            sourceInput.focus();
            return;
        }
        if (!amountValRaw || isNaN(amountVal) || amountVal <= 0) {
            alert('Please enter a valid positive amount.');
            amountInput.focus();
            return;
        }
        if (!dateVal) {
            alert('Please select a date.');
            dateInput.focus();
            return;
        }

        sideHustleTotalIncome += amountVal;
        if (totalElem) {
            totalElem.textContent = `Side Hustle Income: $${sideHustleTotalIncome.toFixed(2)}`;
        }

        // Format date to match Paycheck section
        const formattedDate = new Date(dateVal).toLocaleDateString('en-US', {
            day: 'numeric',
            month: 'long',
            year: 'numeric',
        });

        const newRow = document.createElement('tr');
        newRow.innerHTML = `
            <td>${sourceVal}</td>
            <td>$${amountVal.toFixed(2)}</td>
            <td>${formattedDate}</td>
            <td></td>
        `;
        tableBody.appendChild(newRow);

        sourceInput.value = '';
        amountInput.value = '';
        dateInput.value = '';
        sourceInput.focus();

        // Update grand total
        updateGrandTotalIncome();
    }

    const sideHustleForm = document.getElementById('sideHustleIncomeForm');
    if (sideHustleForm) {
        sideHustleForm.addEventListener('submit', addSideHustleIncome);
    }

    // Initialize forecast chart
    function initForecastChart() {
        const ctx = document.getElementById('incomeForecastChart');
        if (!ctx) return null;
        return new Chart(ctx.getContext('2d'), {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                datasets: [{
                    label: 'Projected Income',
                    data: [0, 0, 0, 0, 0, 0],
                    borderColor: '#6366f1',
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        labels: {
                            color: '#f8f9fa'
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: '#2d2d2d'
                        },
                        ticks: {
                            color: '#9ca3af'
                        }
                    },
                    x: {
                        grid: {
                            color: '#2d2d2d'
                        },
                        ticks: {
                            color: '#9ca3af'
                        }
                    }
                }
            }
        });
    }

    let forecastChart = initForecastChart();

    function updateForecastChart() {
        if (!forecastChart) return;
        // Update chart with new data
        const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'];
        const projectedData = months.map(() => totalIncome);
        forecastChart.data.datasets[0].data = projectedData;
        forecastChart.update();
    }
});

// Edit and Delete functions
function editIncome(button) {
    const row = button.closest('tr');
    const cells = row.cells;
    const source = cells[0].textContent;
    const amount = cells[1].textContent.replace('$', '');
    // Implement edit functionality (e.g., open a modal or inline editing)
}

function deleteIncome(button) {
    const row = button.closest('tr');
    const amount = parseFloat(row.cells[1].textContent.replace('$', ''));
    // Update total income
    const totalIncomeElem = document.getElementById('totalIncome');
    const currentTotal = parseFloat(totalIncomeElem.textContent.replace(/[^0-9.-]+/g, ''));
    totalIncomeElem.textContent = `Total Income: $${(currentTotal - amount).toFixed(2)}`;
    // Remove the row
    row.remove();
} 