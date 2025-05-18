<?php
    session_start();
    if(isset($_SESSION['status'])){
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Income Tracker</title>
    <link rel="stylesheet" href="js/income.css" />
  
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let totalIncome = 5300;
            const currentDateElement = document.getElementById("current-date");
            if (currentDateElement) {
            const now = new Date();
            const options = { year: "numeric", month: "long", day: "numeric" };
            currentDateElement.textContent = now.toLocaleDateString(
             "en-US",
            options
    );
  }
            const form = document.getElementById('incomeForm');
            const incomeInput = document.getElementById('income');
            const sourceInput = document.getElementById('source');
            const totalIncomeElem = document.getElementById('totalIncome');
            const incomeTableBody = document.getElementById('incomeTableBody');

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
                totalIncomeElem.textContent = `Total Income: $${totalIncome.toFixed(2)}`;

                const newRow = document.createElement('tr');
                const today = new Date();
                const formattedDate = today.toLocaleDateString('en-US', {
                    day: 'numeric',
                    month: 'long',
                    year: 'numeric',
                });
                newRow.innerHTML = `<td>${sourceVal}</td><td>$${incomeVal.toFixed(2)}</td><td>${formattedDate}</td>`;
                incomeTableBody.appendChild(newRow);

                incomeInput.value = '';
                sourceInput.value = '';
                incomeInput.focus();
            }

            if (form) {
                form.addEventListener('submit', addIncome);
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

    <main class="main-content">
          <header class="page-header">
        <div type= "date" class="date-display" id="current-date"></div>
    </header>
   
        <div class="income-container">
            <div class="header">
                <div id="incomeInfo">
                    <p id="totalIncome">Total Income: $5300.00</p>
                </div>
            </div>
      
            <div id="addIncome">
                <form action="../contoroller/db.php" method="POST" onsubmit="return validRegister()" id="income-form" novalidate>
                    <input type="incomeSource" id="source" name="source" placeholder="Income Source" required />
                    <input type="incomeAmount" id="income" name="income" placeholder="Amount" required />
                    <input type="submit" value="Add" />
                </form>
            </div>
        
            <div id="Table">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Source</th>
                            <th>Amount</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody id="incomeTableBody">
                        <!-- Income entries will go here -->
                    </tbody>
                </table>
            </div>
        </div>
    
    <script src="../js/features.js"></script>
</body>

</html>
<?php
    }else{
        header('location: login.html');
    }

?>