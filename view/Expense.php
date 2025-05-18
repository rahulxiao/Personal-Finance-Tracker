<?php
    session_start();
    if(isset($_SESSION['user'])){
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Expense Tracker</title>
    <link rel="stylesheet" href="js/styles.css" />
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            
            let totalExpense = 5000;

            const form = document.getElementById('expenseForm');
            const expenseInput = document.getElementById('expense');
            const sourceInput = document.getElementById('source');
            const totalExpenseElem = document.getElementById('totalExpense');
            const expenseTableBody = document.getElementById('expenseTableBody');

            function addExpense(event) {
                event.preventDefault();

                const expenseValRaw = expenseInput.value.trim();
                const sourceVal = sourceInput.value.trim();

                
                const expenseVal = parseFloat(expenseValRaw);
                if (!expenseValRaw || isNaN(expenseVal) || expenseVal <= 0) {
                    alert('Please enter a valid positive expense amount.');
                    expenseInput.focus();
                    return;
                }

                
                if (!sourceVal) {
                    alert('Please enter the source of expense.');
                    sourceInput.focus();
                    return;
                }

                
                totalExpense += expenseVal;
                totalExpenseElem.textContent = `Total Expense: $${totalExpense.toFixed(2)}`;

                
                const newRow = document.createElement('tr');
                const today = new Date();
                const formattedDate = today.toLocaleDateString('en-US', {
                    day: 'numeric',
                    month: 'long',
                    year: 'numeric',
                });
                newRow.innerHTML = `<td>$${expenseVal.toFixed(2)}</td><td>${formattedDate}</td><td>${sourceVal}</td>`;
                expenseTableBody.appendChild(newRow);

                
                expenseInput.value = '';
                sourceInput.value = '';
                expenseInput.focus();
            }

            if (form) {
                form.addEventListener('submit', addExpense);
            }
        });
    </script>
</head>

<body>
    <div class="sidebar">
        <div class="title">
            <p>MoneyFin</p>
        </div>
        <p><a href="Profile management.html">Profile Management</a></p> 
        <p><a href="Income.html">Income</a></p>
        <p><a href="Expense.html">Expense</a></p>
        <p><a href="Debts.html">Debts</a></p>
    </div>
    <div id="date">
        <p>14 April 2025</p>
    </div>

    <div id="expenseInfo">
        <p id="totalExpense">Total Expense: $5000</p>
    </div>

    <div id="addExpense">
        <form id="expenseForm">
            <label for="expense">Add Expense:</label>
            <input type="text" id="expense" name="expense" required />
            <label for="source">Source:</label>
            <input type="text" id="source" name="source" required />
            <input type="submit" value="Add" />
        </form>
    </div>

    <div id="Table">
        <table border="1">
            <thead>
                <tr>
                    <th>Amount</th>
                    <th>Date</th>
                    <th>Source</th>
                </tr>
            </thead>
            <tbody id="expenseTableBody">
                <tr>
                    <td>$500</td>
                    <td>14 April 2025</td>
                    <td>Grocery</td>
                </tr>
                <tr>
                    <td>$200</td>
                    <td>10 April 2025</td>
                    <td>Bills</td>
                </tr>
                <tr>
                    <td>$100</td>
                    <td>5 April 2025</td>
                    <td>Gift</td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>
<?php
    }else{
        header('location: login.html');
    }

?>
