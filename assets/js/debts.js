document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('debtForm');
    const debtSourceInput = document.getElementById('debtSource');
    const loanAmountInput = document.getElementById('loanAmount');
    const interestRateInput = document.getElementById('interestRate');
    const monthlyPaymentInput = document.getElementById('monthlyPayment');
    const debtsTableBody = document.getElementById('debtsTableBody');
    const payoffModal = document.getElementById('payoffModal');
    const closePayoffModal = document.getElementById('closePayoffModal');
    const modalPayoffTime = document.getElementById('modalPayoffTime');
    const modalTotalInterest = document.getElementById('modalTotalInterest');
    const modalTotalRepayment = document.getElementById('modalTotalRepayment');
    const grandTotalDebtElem = document.getElementById('grandTotalDebt');
    let grandTotalDebt = 0;

    // Load existing debts from database
    function loadDebts() {
        fetch('../controller/debtsDB.php?type=debts')
            .then(response => response.json())
            .then(debts => {
                debtsTableBody.innerHTML = '';
                grandTotalDebt = 0;
                
                debts.forEach(debt => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${debt.source}</td>
                        <td>$${parseFloat(debt.amount).toFixed(2)}</td>
                        <td>${parseFloat(debt.interest).toFixed(2)}</td>
                        <td>$${parseFloat(debt.monthlyPayment).toFixed(2)}</td>
                        <td style="display: flex; gap: 8px; align-items: center;">
                            <button class="btn-primary payoff-btn">Calculate Payoff</button>
                            <button class="action-btn delete-btn">
                                <i data-feather="trash-2"></i>
                            </button>
                        </td>
                    `;

                    // Add event listener for payoff button
                    row.querySelector('.payoff-btn').onclick = function() {
                        showPayoffModal(
                            parseFloat(debt.amount),
                            parseFloat(debt.interest),
                            parseFloat(debt.monthlyPayment)
                        );
                    };

                    // Add event listener for delete button
                    row.querySelector('.delete-btn').onclick = function() {
                        deleteDebt(debt.id, row, parseFloat(debt.amount), parseFloat(debt.interest));
                    };

                    debtsTableBody.appendChild(row);
                    
                    // Calculate total repayment for this debt
                    const result = calculatePayoff(
                        parseFloat(debt.amount),
                        parseFloat(debt.interest),
                        parseFloat(debt.monthlyPayment)
                    );
                    grandTotalDebt += result.totalAmount;

                    // Initialize Feather icons for the new row
                    if (window.feather) {
                        feather.replace();
                    }
                });
                
                updateGrandTotalDebt();
            })
            .catch(error => {
                console.error('Error:', error);
                showMessage('error', 'An error occurred while loading debts');
            });
    }

    function calculatePayoff(principal, annualRate, monthlyPayment) {
        const monthlyRate = annualRate / 100 / 12;
        let balance = principal;
        let totalInterest = 0;
        let months = 0;
        
        if (monthlyPayment <= balance * monthlyRate) {
            return {
                payoffTime: 'Monthly payment is too low to ever pay off this loan.',
                totalInterest: 0,
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
        
        const totalAmount = principal + totalInterest;
        const years = Math.floor(months / 12);
        const remMonths = months % 12;
        
        return {
            payoffTime: `Payoff Time: ${years > 0 ? years + ' years ' : ''}${remMonths} months`,
            totalInterest: `Total Interest Paid: $${totalInterest.toFixed(2)}`,
            totalRepayment: `Total Repayment: $${totalAmount.toFixed(2)}`,
            totalAmount: totalAmount
        };
    }

    function deleteDebt(id, row, amount, interestRate) {
        if (confirm('Are you sure you want to delete this debt?')) {
            fetch(`../controller/debtsDB.php?type=debt&id=${id}`, {
                method: 'DELETE'
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Calculate and subtract the total repayment amount
                    const result = calculatePayoff(
                        amount,
                        interestRate,
                        parseFloat(row.children[3].textContent.slice(1))
                    );
                    grandTotalDebt -= result.totalAmount;
                    
                    updateGrandTotalDebt();
                    row.remove();
                    showMessage('success', 'Debt deleted successfully');
                } else {
                    showMessage('error', data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showMessage('error', 'An error occurred while deleting the debt');
            });
        }
    }

    function showPayoffModal(principal, annualRate, monthlyPayment) {
        const result = calculatePayoff(principal, annualRate, monthlyPayment);
        modalPayoffTime.textContent = result.payoffTime;
        modalTotalInterest.textContent = result.totalInterest;
        modalTotalRepayment.textContent = result.totalRepayment;
        payoffModal.style.display = 'flex';
    }

    if (closePayoffModal) {
        closePayoffModal.onclick = function () {
            payoffModal.style.display = 'none';
        };
    }

    window.onclick = function(event) {
        if (event.target === payoffModal) {
            payoffModal.style.display = 'none';
        }
    };

    function updateGrandTotalDebt() {
        if (grandTotalDebtElem) {
            grandTotalDebtElem.textContent = `Total Debt: $${grandTotalDebt.toFixed(2)}`;
        }
    }

    function showMessage(type, message) {
        const messageDiv = document.createElement('div');
        messageDiv.className = `message ${type}-message`;
        messageDiv.textContent = message;
        
        const container = document.querySelector('#addDebt');
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

    if (form) {
        form.addEventListener('submit', function (event) {
            event.preventDefault();
            
            const formData = new FormData();
            formData.append('type', 'debt');
            formData.append('debtSource', debtSourceInput.value.trim());
            formData.append('loanAmount', loanAmountInput.value);
            formData.append('interestRate', interestRateInput.value);
            formData.append('monthlyPayment', monthlyPaymentInput.value);

            fetch('../controller/debtsDB.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showMessage('success', data.message);
                    loadDebts(); // Reload the table
                    form.reset();
                } else {
                    const errors = Array.isArray(data.errors) ? data.errors.join('<br>') : data.message;
                    showMessage('error', errors);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showMessage('error', 'An error occurred while saving the debt');
            });
        });
    }

    // Add code to set current date in header
    const currentDateElement = document.getElementById("current-date");
    if (currentDateElement) {
        const now = new Date();
        const options = { year: "numeric", month: "long", day: "numeric" };
        currentDateElement.textContent = now.toLocaleDateString("en-US", options);
    }

    // Load existing debts when the page loads
    loadDebts();
});
