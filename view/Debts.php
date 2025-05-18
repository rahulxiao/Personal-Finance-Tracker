<?php
    session_start();
    if(isset($_SESSION['user'])){
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Debts Tracker</title>
    <link rel="stylesheet" href="js/styles.css" />
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            
            let totalDebt = 800;

            const form = document.getElementById('debtForm');
            const debtInput = document.getElementById('debt');
            const sourceInput = document.getElementById('source');
            const totalDebtElem = document.getElementById('totalDebt');
            const debtTableBody = document.getElementById('debtTableBody');

            function addDebt(event) {
                event.preventDefault();

                const debtValRaw = debtInput.value.trim();
                const sourceVal = sourceInput.value.trim();

                
                const debtVal = parseFloat(debtValRaw);
                if (!debtValRaw || isNaN(debtVal) || debtVal <= 0) {
                    alert('Please enter a valid positive debt amount.');
                    debtInput.focus();
                    return;
                }

                
                if (!sourceVal) {
                    alert('Please enter the source of debt.');
                    sourceInput.focus();
                    return;
                }

                
                totalDebt += debtVal;
                totalDebtElem.textContent = `Total Debt: $${totalDebt.toFixed(2)}`;

                
                const newRow = document.createElement('tr');
                const today = new Date();
                const formattedDate = today.toLocaleDateString('en-US', {
                    day: 'numeric',
                    month: 'long',
                    year: 'numeric',
                });
                newRow.innerHTML = `<td>$${debtVal.toFixed(2)}</td><td>${formattedDate}</td><td>${sourceVal}</td>`;
                debtTableBody.appendChild(newRow);

                
                debtInput.value = '';
                sourceInput.value = '';
                debtInput.focus();
            }

            if (form) {
                form.addEventListener('submit', addDebt);
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

    <div id="debtInfo">
        <p id="totalDebt">Total Debt: $800</p>
    </div>

    <div id="addDebt">
        <form id="debtForm">
            <label for="debt">Add Debt:</label>
            <input type="text" id="debt" name="debt" required />
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
            <tbody id="debtTableBody">
                <tr>
                    <td>$500</td>
                    <td>14 April 2025</td>
                    <td>Bank</td>
                </tr>
                <tr>
                    <td>$200</td>
                    <td>10 April 2025</td>
                    <td>Adam</td>
                </tr>
                <tr>
                    <td>$100</td>
                    <td>5 April 2025</td>
                    <td>Kevin</td>
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