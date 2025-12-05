<?php
require_once('config.php');
$sql = 'SELECT SUM(montant) as totalIncomes , DATE_FORMAT(laDate , "%Y-%m") as ladate FROM incomes GROUP BY DATE_FORMAT(laDate , "%Y-%m") ORDER BY ladate DESC;';
$sqle = 'SELECT SUM(montant) as totalExpenses , DATE_FORMAT(laDate , "%Y-%m") as ladate FROM expenses GROUP BY DATE_FORMAT(laDate , "%Y-%m") ORDER BY ladate DESC;';
$resultIncomes = $conn->query($sql);
$resultExpenses = $conn->query($sqle);
$incomes = [];
$expenses = [];
while ($row = $resultIncomes->fetch_assoc()) {
    $incomes[] = $row;
}
while ($row = $resultExpenses->fetch_assoc()) {
    $expenses[] = $row;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <title>Document</title>
</head>

<body>
    <canvas id="myChart" class="">

    </canvas>
    <script>

        const incomes = <?php echo json_encode($incomes) ?>;
        const expenses = <?php echo json_encode($expenses) ?>;
        const incomesValue = incomes.map(item => item.totalIncomes);
        const expensesValue = expenses.map(item => item.totalExpenses);
        const labels = incomes.map(item => item.ladate);
        const countainer = document.getElementById('myChart').getContext('2d');


        const myChart = new Chart(countainer, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Incomes',
                        data: incomesValue,
                        borderColor: '#10b981',
                        backgroundColor: 'rgba(16, 185, 129, 0.1)',
                        tension: 0.4
                    },
                    {
                        label: 'Expenses',
                        data: expensesValue,
                        borderColor: '#ef4444',
                        backgroundColor: 'rgba(239, 68, 68, 0.1)',
                        tension: 0.4
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true
                    }
                }
            }
        });
    </script>
</body>

</html>