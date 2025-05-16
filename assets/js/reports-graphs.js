// Load Google Charts
google.charts.load("current", { packages: ["corechart"] });
google.charts.setOnLoadCallback(drawCharts);

function drawCharts() {
    // Monthly Finances Bar Chart
    var monthlyData = google.visualization.arrayToDataTable([
        ["Month", "Income", "Expenses", "Savings"],
        ["Jan", 4800, 3800, 1000],
        ["Feb", 4600, 3900, 700],
        ["Mar", 5200, 4000, 1200],
        ["Apr", 4700, 3900, 800],
        ["May", 5000, 4100, 900],
        ["Jun", 5300, 4200, 1100],
    ]);
    var monthlyOptions = {
        title: "",
        chartArea: { width: "80%", height: "70%" },
        hAxis: { title: "Month" },
        vAxis: { title: "Amount ($)" },
        legend: { position: "top" },
        colors: ["#3498db", "#e74c3c", "#2ecc71"],
    };
    var monthlyChart = new google.visualization.ColumnChart(
        document.getElementById("monthlyChart"),
    );
    monthlyChart.draw(monthlyData, monthlyOptions);

    // Expense Breakdown Donut Chart
    var expenseData = google.visualization.arrayToDataTable([
        ["Category", "Amount"],
        ["Housing", 1200],
        ["Food", 500],
        ["Transport", 350],
        ["Utilities", 300],
        ["Other", 1750],
    ]);
    var expenseOptions = {
        title: "",
        pieHole: 0.4,
        chartArea: { width: "80%", height: "80%" },
        colors: ["#e91e63", "#9b59b6", "#f1c40f", "#1abc9c", "#7f8c8d"],
    };
    var expenseChart = new google.visualization.PieChart(
        document.getElementById("expenseChart"),
    );
    expenseChart.draw(expenseData, expenseOptions);

    // Income Sources Pie Chart
    var incomeData = google.visualization.arrayToDataTable([
        ["Source", "Amount"],
        ["Salary", 3800],
        ["Freelance", 850],
        ["Investments", 450],
        ["Other", 100],
    ]);
    var incomeOptions = {
        title: "",
        chartArea: { width: "80%", height: "80%" },
        colors: ["#2980b9", "#8e44ad", "#27ae60", "#d35400"],
    };
    var incomeChart = new google.visualization.PieChart(
        document.getElementById("incomeChart"),
    );
    incomeChart.draw(incomeData, incomeOptions);

    // Transaction Trends Line Chart
    var trendsData = google.visualization.arrayToDataTable([
        ["Date", "Income", "Expenses"],
        ["Jan 1", 1500, 1200],
        ["Jan 7", 1800, 1400],
        ["Jan 14", 2000, 1800],
        ["Jan 21", 1700, 1000],
        ["Jan 28", 1900, 1600],
        ["Feb 4", 1600, 1200],
        ["Feb 11", 1750, 1500],
        ["Feb 18", 1800, 1300],
    ]);
    var trendsOptions = {
        title: "",
        chartArea: { width: "80%", height: "70%" },
        hAxis: { title: "Date" },
        vAxis: { title: "Amount ($)" },
        legend: { position: "top" },
        colors: ["#3498db", "#e74c3c"],
    };
    var trendsChart = new google.visualization.LineChart(
        document.getElementById("trendsChart"),
    );
    trendsChart.draw(trendsData, trendsOptions);
}
