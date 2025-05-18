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

    function calculatePayoff(principal, annualRate, monthlyPayment) {
        const monthlyRate = annualRate / 100 / 12;
        let balance = principal;
        let totalInterest = 0;
        let months = 0;
        if (monthlyPayment <= balance * monthlyRate) {
            return {
                payoffTime: 'Monthly payment is too low to ever pay off this loan.',
                totalInterest: '',
                totalRepayment: ''
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
        const totalRepayment = principal + totalInterest;
        const years = Math.floor(months / 12);
        const remMonths = months % 12;
        return {
            payoffTime: `Payoff Time: ${years > 0 ? years + ' years ' : ''}${remMonths} months`,
            totalInterest: `Total Interest Paid: $${totalInterest.toFixed(2)}`,
            totalRepayment: `Total Repayment: $${totalRepayment.toFixed(2)}`
        };
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

    if (form) {
        form.addEventListener('submit', function (event) {
            event.preventDefault();
            const source = debtSourceInput.value.trim();
            const principal = parseFloat(loanAmountInput.value);
            const annualRate = parseFloat(interestRateInput.value);
            const monthlyPayment = parseFloat(monthlyPaymentInput.value);
            if (!source) {
                alert('Please enter the debt source.');
                debtSourceInput.focus();
                return;
            }
            if (isNaN(principal) || principal <= 0) {
                alert('Please enter a valid loan amount.');
                loanAmountInput.focus();
                return;
            }
            if (isNaN(annualRate) || annualRate < 0) {
                alert('Please enter a valid interest rate.');
                interestRateInput.focus();
                return;
            }
            if (isNaN(monthlyPayment) || monthlyPayment <= 0) {
                alert('Please enter a valid monthly payment.');
                monthlyPaymentInput.focus();
                return;
            }
            // Add to table
            const newRow = document.createElement('tr');
            newRow.innerHTML = `
                <td>${source}</td>
                <td>$${principal.toFixed(2)}</td>
                <td>${annualRate.toFixed(2)}</td>
                <td>$${monthlyPayment.toFixed(2)}</td>
                <td>
                    <button class="btn-primary payoff-btn">Calculate Payoff</button>
                    <button class="btn-primary clear-btn" style="margin-left:8px;background:var(--error-color);color:#fff;">Clear</button>
                </td>
            `;
            // Add event listener for this row's payoff button
            newRow.querySelector('.payoff-btn').onclick = function() {
                showPayoffModal(principal, annualRate, monthlyPayment);
            };
            // Add event listener for clear button
            newRow.querySelector('.clear-btn').onclick = function() {
                grandTotalDebt -= principal;
                updateGrandTotalDebt();
                newRow.remove();
            };
            debtsTableBody.appendChild(newRow);
            // Update grand total
            grandTotalDebt += principal;
            updateGrandTotalDebt();
            // Clear form
            debtSourceInput.value = '';
            loanAmountInput.value = '';
            interestRateInput.value = '';
            monthlyPaymentInput.value = '';
            debtSourceInput.focus();
        });
    }

    // Add code to set current date in header
    const currentDateElement = document.getElementById("current-date");
    if (currentDateElement) {
        const now = new Date();
        const options = { year: "numeric", month: "long", day: "numeric" };
        currentDateElement.textContent = now.toLocaleDateString("en-US", options);
    }
});
