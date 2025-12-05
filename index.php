<?php
require_once("config.php");

$sql_sum_inco = "SELECT SUM(montant) AS total FROM incomes";
$sql_sum_expe = "SELECT SUM(montant) AS total FROM expenses";

$sum_res_inco = $conn->query($sql_sum_inco);
$sum_inco = $sum_res_inco->fetch_assoc();
if (!$sum_inco['total']) {
    $sum_inco['total'] = 0;
}
$sum_res_expe = $conn->query($sql_sum_expe);
$sum_expe = $sum_res_expe->fetch_assoc();
if (!$sum_expe['total']) {
    $sum_expe['total'] = 0;
}
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
<html class="light" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>SmartWallet - Dashboard</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200;300;400;500;600;700;800&display=swap"
        rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
        rel="stylesheet" />
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 300, 'GRAD' 0, 'opsz' 24;
        }
    </style>
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#13ec5b",
                        "background-light": "#f6f8f6",
                        "background-dark": "#102216",
                        "card-light": "#ffffff",
                        "card-dark": "#182c1f",
                        "border-light": "#e5e7eb",
                        "border-dark": "#374151"
                    },
                    fontFamily: {
                        "display": ["Manrope", "sans-serif"]
                    },
                    borderRadius: { "DEFAULT": "0.25rem", "lg": "0.5rem", "xl": "0.75rem", "full": "9999px" },
                    boxShadow: {
                        'subtle': '0 4px 6px -1px rgb(0 0 0 / 0.05), 0 2px 4px -2px rgb(0 0 0 / 0.05)',
                        'subtle-hover': '0 10px 15px -3px rgb(0 0 0 / 0.07), 0 4px 6px -4px rgb(0 0 0 / 0.07)',
                    }
                },
            },
        }
    </script>
</head>

<body
    class="bg-background-light dark:bg-background-dark font-display text-gray-800 dark:text-gray-200 antialiased min-h-screen">

    <!-- Mobile Overlay -->
    <div id="mobile-overlay" class="fixed inset-0 bg-black/50 z-40 hidden lg:hidden"></div>

    <div class="flex h-screen">

        <!-- Sidebar - Hidden on mobile, visible on lg+ -->
        <aside id="sidebar"
            class="fixed lg:static inset-y-0 left-0 z-50 w-64 bg-card-light dark:bg-card-dark border-r border-border-light dark:border-border-dark transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out flex flex-col">
            <div class="flex flex-col flex-grow p-4">
                <div class="flex items-center justify-between mb-8">
                    <div class="flex items-center gap-3">
                        <div class="bg-center bg-no-repeat aspect-square bg-cover rounded-full size-14"
                            style="background-image:url('img/SmartWallet.png')"></div>
                        <div>
                            <h1 class="text-gray-900 dark:text-white text-base font-bold">SmartWallet</h1>
                            <p class="text-gray-500 dark:text-gray-400 text-sm">Personal Finance</p>
                        </div>
                    </div>
                    <!-- Close button only on mobile -->
                    <button id="close-sidebar" class="lg:hidden text-gray-600 dark:text-gray-400">
                        <span class="material-symbols-outlined">close</span>
                    </button>
                </div>

                <nav class="flex flex-col gap-2 flex-grow">
                    <a class="flex items-center gap-3 px-4 py-2.5 rounded-lg hover:bg-gray-100 dark:hover:bg-white/10 text-gray-600 dark:text-gray-300 transition-colors"
                        href="index.php">
                        <span class="material-symbols-outlined">dashboard</span>
                        <p class="text-sm font-semibold">Dashboard</p>
                    </a>
                    <a class="allincomes flex items-center gap-3 px-4 py-2.5 rounded-lg hover:bg-gray-100 dark:hover:bg-white/10 text-gray-600 dark:text-gray-300 transition-colors"
                        href="incomes.php">
                        <span class="material-symbols-outlined">account_balance_wallet</span>
                        <p class="text-sm font-medium">Incomes</p>
                    </a>
                    <a class="allexpenses flex items-center gap-3 px-4 py-2.5 rounded-lg  hover:bg-gray-100 dark:hover:bg-white/10 text-gray-600 dark:text-gray-300 transition-colors"
                        href="expenses.php">
                        <span class="material-symbols-outlined">receipt_long</span>
                        <p class="text-sm font-medium">Expenses</p>
                    </a>
                    <a class="flex items-center gap-3 px-4 py-2.5 rounded-lg hover:bg-gray-100 dark:hover:bg-white/10 text-gray-600 dark:text-gray-300 transition-colors"
                        href="#">
                        <span class="material-symbols-outlined">category</span>
                        <p class="text-sm font-medium">Categories</p>
                    </a>
                    <a class="flex items-center gap-3 px-4 py-2.5 rounded-lg hover:bg-gray-100 dark:hover:bg-white/10 text-gray-600 dark:text-gray-300 transition-colors"
                        href="#">
                        <span class="material-symbols-outlined">ios_share</span>
                        <p class="text-sm font-medium">Export</p>
                    </a>
                </nav>

                <div class="flex flex-col gap-2 pt-4 border-t border-border-light dark:border-border-dark">
                    <a class="flex items-center gap-3 px-4 py-2.5 rounded-lg hover:bg-gray-100 dark:hover:bg-white/10 text-gray-600 dark:text-gray-300 transition-colors"
                        href="#">
                        <span class="material-symbols-outlined">settings</span>
                        <p class="text-sm font-medium">Settings</p>
                    </a>
                    <a class="flex items-center gap-3 px-4 py-2.5 rounded-lg hover:bg-gray-100 dark:hover:bg-white/10 text-gray-600 dark:text-gray-300 transition-colors"
                        href="#">
                        <span class="material-symbols-outlined">logout</span>
                        <p class="text-sm font-medium">Logout</p>
                    </a>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col">
            <!-- Header with Hamburger -->
            <header
                class="bg-card-light/80 dark:bg-card-dark/80 backdrop-blur-sm border-b border-border-light dark:border-border-dark p-4 sticky top-0 z-30 flex items-center justify-between">
                <button id="open-sidebar" class="lg:hidden text-gray-700 dark:text-gray-300">
                    <span class="material-symbols-outlined text-2xl">menu</span>
                </button>

                <div>
                    <h2 class="text-gray-900 dark:text-white text-xl md:text-2xl font-bold">Dashboard</h2>
                    <p class="text-gray-500 dark:text-gray-400 text-xs md:text-sm">Welcome back, Kerymy! Here's your
                        financial overview.</p>
                </div>

                <div class="flex items-center gap-4">
                    <button class="text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">
                        <span class="material-symbols-outlined">notifications</span>
                    </button>
                    <div class="bg-center bg-no-repeat aspect-square bg-cover rounded-full size-10"
                        style='background-image: url("https://intranet.youcode.ma/storage/users/profile/thumbnail/2050-1760996601.png");'>
                    </div>
                    <div><p class="text-gray-900 dark:text-white text-sm font-semibold">Kerymy M.</p>
                    <p class="text-gray-500 dark:text-gray-400 text-xs">M.Kerymy@gamil.com</p></div>
                </div>
            </header>

            <!-- Dashboard Content -->
            <main class="flex-1 overflow-y-auto p-4 md:p-6 lg:p-8">
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4 md:gap-6">
                    <div class="xl:col-span-3 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 md:gap-6">
                        <div
                            class="flex flex-col justify-between gap-2 rounded-xl p-4 md:p-6 bg-card-light dark:bg-card-dark border border-border-light dark:border-border-dark shadow-subtle hover:shadow-subtle-hover transition-shadow">
                            <div>
                                <p class="text-gray-500 dark:text-gray-400 text-xs md:text-sm font-medium">Total
                                    Revenues</p>
                                <p
                                    class="text-gray-900 dark:text-white text-2xl lg:text-3xl  font-bold mt-2 md:text-[12px]">
                                    $<?php echo number_format($sum_inco['total'], 2); ?></p>
                            </div>
                            <p class="text-green-500 text-xs flex items-center gap-1">+12.5% vs last month <span
                                    class="material-symbols-outlined text-base">trending_up</span></p>
                        </div>
                        <div
                            class="flex flex-col justify-between gap-2 rounded-xl p-4 md:p-6 bg-card-light dark:bg-card-dark border border-border-light dark:border-border-dark shadow-subtle hover:shadow-subtle-hover transition-shadow">
                            <div>
                                <p class="text-gray-500 dark:text-gray-400 text-xs md:text-sm font-medium">Total
                                    Expenses</p>
                                <p
                                    class="text-gray-900 dark:text-white text-2xl lg:text-3xl  font-bold mt-2 md:text-[12px]">
                                    $<?php echo number_format($sum_expe['total'], 2); ?></p>
                            </div>
                            <p class="text-red-500 text-xs flex items-center gap-1">+5.2% vs last month <span
                                    class="material-symbols-outlined text-base">trending_up</span></p>
                        </div>
                        <div
                            class="flex flex-col justify-between gap-2 rounded-xl p-4 md:p-6 bg-card-light dark:bg-card-dark border border-border-light dark:border-border-dark shadow-subtle hover:shadow-subtle-hover transition-shadow">
                            <div>
                                <p class="text-gray-500 dark:text-gray-400 text-xs md:text-sm font-medium">Current
                                    Balance</p>
                                <p
                                    class="<?php echo ($sum_inco['total'] - $sum_expe['total'] > 0) ? 'text-primary' : 'text-red-500'; ?> text-2xl lg:text-3xl  font-bold mt-2 md:text-[12px]">
                                    $<?php echo number_format($sum_inco['total'] - $sum_expe['total'], 2); ?>
                                </p>
                            </div>
                            <p class="text-gray-500 dark:text-gray-400 text-xs">Updated just now</p>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div
                        class="flex flex-col gap-4 rounded-xl p-4 md:p-6 bg-card-light dark:bg-card-dark border border-border-light dark:border-border-dark shadow-subtle">
                        <h3 class="font-semibold text-sm md:text-base text-gray-800 dark:text-gray-200">Quick Actions
                        </h3>
                        <button
                            class="newincom w-full flex items-center justify-center gap-2 px-4 py-2.5 bg-primary/20 hover:bg-primary/30 text-primary font-semibold text-sm rounded-lg transition-colors">
                            <span class="material-symbols-outlined">add</span> New Income
                        </button>
                        <button
                            class="newexpense w-full flex items-center justify-center gap-2 px-4 py-2.5 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 font-semibold text-sm rounded-lg transition-colors">
                            <span class="material-symbols-outlined">remove</span> New Expense
                        </button>
                    </div>
                </div>

                <!-- Chart + Transactions -->
                <div class="mt-6 md:mt-8 grid grid-cols-1 xl:grid-cols-5 gap-6 md:gap-8">
                    <div
                        class="xl:col-span-3 bg-card-light dark:bg-card-dark border border-border-light dark:border-border-dark rounded-xl shadow-subtle p-4 md:p-6">
                        <canvas id="myChart"></canvas>
                    </div>

                    <div
                        class="p-4 md:p-5 xl:col-span-2 bg-card-light dark:bg-card-dark border border-border-light dark:border-border-dark rounded-xl shadow-subtle flex flex-col gap-4">
                        <p class="text-gray-500 dark:text-gray-400 text-base md:text-lg font-medium text-center">Last
                            Transactions</p>
                        <?php
                        $mounth = date("m");
                        $sql = "SELECT montant, laDate, descri, 'incomes' as source FROM incomes WHERE MONTH(laDate) = $mounth
                                UNION
                                SELECT montant, laDate, descri, 'expenses' as source FROM expenses WHERE MONTH(laDate) = $mounth
                                ORDER BY laDate DESC LIMIT 5";
                        $inco_expe = $conn->query($sql);
                        while ($row = $inco_expe->fetch_assoc()) {
                            $color = $row['source'] == 'incomes' ? 'text-green-500' : 'text-red-500';
                            $img = $row['source'] == 'incomes'
                                ? 'https://media.istockphoto.com/id/1144366258/fr/vectoriel/flèche-verte-pointant-vers-le-haut-le-symbole-de-direction-icône-de-signe-flèche.webp?s=2048x2048&w=is&k=20&c=vSOuyB3sdkxiWCGgBoSBdkVFUtzGbsQX1EuZNy_09js='
                                : 'https://media.istockphoto.com/id/1144366180/fr/vectoriel/flèche-rouge-pointant-vers-le-haut-le-symbole-de-direction-icône-de-signe-flèche.webp?s=2048x2048&w=is&k=20&c=U995t8Ta6XreKdkRnvbGCz6jsdIV_6bpx2AA1WN9yac=';
                            $rotate = $row['source'] == 'expenses' ? 'rotate-180' : '';
                            $converted = date("d-M", strtotime($row['laDate']));
                            echo "<div class='w-full border-2 flex py-2 rounded-lg p-2 justify-between items-center gap-2'>
                                    <div class='flex gap-2 items-center min-w-0'>
                                        <img class='rounded-full h-8 md:h-10 w-8 md:w-10 flex-shrink-0 $rotate' src='$img'>
                                        <p class='text-black/50 dark:text-gray-400 text-xs md:text-sm truncate'>{$row['descri']}<br><span class='text-xs'>$converted</span></p>
                                    </div>
                                    <p class='$color font-semibold text-sm md:text-base flex-shrink-0'>$" . $row['montant'] . "</p>
                                    </div>";
                        }
                        ?>
                        <a href="#" class="self-center text-primary text-sm hover:underline">view all transactions</a>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Modals (unchanged) -->
    <div class="fixed inset-0 bg-gray-500/30 z-50 flex justify-center items-center income_model hidden">
        <form action="traitement.php" method="POST"
            class="border-2 flex flex-col w-[90vw] md:w-[400px] rounded-[25px] bg-white dark:bg-card-dark p-6 income_form">
            <h1 class="text-center text-lg font-bold mb-4">Add Income</h1>
            <label class="text-sm font-medium">Montant Income</label>
            <input class="rounded-lg px-3 py-2 text-sm border-2 mb-3" type="text" name="montant_incomes" required
                placeholder="Insert amount">
            <label class="text-sm font-medium">Description</label>
            <input class="rounded-lg px-3 py-2 text-sm border-2 mb-4" type="text" name="incomes_desc" required
                placeholder="Insert description">
            <button type="submit"
                class="border-2 rounded-lg px-4 py-2 font-semibold bg-primary text-white hover:bg-primary/90">Add
                Income</button>
        </form>
    </div>

    <div class="fixed inset-0 bg-gray-500/30 z-50 flex justify-center items-center expenses_model hidden">
        <form action="traitement.php" method="POST"
            class="border-2 flex flex-col w-[90vw] md:w-[400px] rounded-[25px] bg-white dark:bg-card-dark p-6 expenses_form">
            <h1 class="text-center text-lg font-bold mb-4">Add Expense</h1>
            <label class="text-sm font-medium">Montant Expense</label>
            <input class="rounded-lg px-3 py-2 text-sm border-2 mb-3" type="text" name="montant_expenses" required
                placeholder="Insert amount">
            <label class="text-sm font-medium">Description</label>
            <input class="rounded-lg px-3 py-2 text-sm border-2 mb-4" type="text" name="expenses_desc" required
                placeholder="Insert description">
            <button type="submit"
                class="border-2 rounded-lg px-4 py-2 font-semibold bg-red-500 text-white hover:bg-red-600">Add
                Expense</button>
        </form>
    </div>

    <!-- Chart Script (unchanged) -->
    <script>
        const incomes = <?php echo json_encode($incomes); ?>;
        const expenses = <?php echo json_encode($expenses); ?>;
        const incomesValue = incomes.map(item => item.totalIncomes || 0);
        const expensesValue = expenses.map(item => item.totalExpenses || 0);
        const labels = incomes.length > expenses.length ? incomes.map(i => i.ladate) : expenses.map(e => e.ladate);

        const balance = labels.map((date, i) => {
            const inc = incomes.find(x => x.ladate === date)?.totalIncomes || 0;
            const exp = expenses.find(x => x.ladate === date)?.totalExpenses || 0;
            return (inc - exp).toFixed(2);
        });

        const ctx = document.getElementById('myChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [
                    { label: 'Incomes', data: incomesValue, borderColor: '#10b981', backgroundColor: 'rgba(16, 185, 129, 0.1)', tension: 0.4 },
                    { label: 'Expenses', data: expensesValue, borderColor: '#ef4444', backgroundColor: 'rgba(239, 68, 68, 0.1)', tension: 0.4 },
                    { label: 'Balance', data: balance, borderColor: '#013cffff', backgroundColor: 'rgba(19, 236, 91, 0.1)', tension: 0.4 }
                ]
            },
            options: {
                responsive: true,
                plugins: { legend: { position: 'bottom' } }
            }
        });
    </script>

    <!-- Mobile Sidebar Toggle Script -->
    <script>
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('mobile-overlay');
        const openBtn = document.getElementById('open-sidebar');
        const closeBtn = document.getElementById('close-sidebar');

        openBtn.addEventListener('click', () => {
            sidebar.classList.remove('-translate-x-full');
            overlay.classList.remove('hidden');
        });

        closeBtn.addEventListener('click', () => {
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
        });

        overlay.addEventListener('click', () => {
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
        });

        // Modal Scripts (your original)
        document.querySelector('.newincom').addEventListener('click', () => document.querySelector('.income_model').classList.toggle('hidden'));
        document.querySelector('.newexpense').addEventListener('click', () => document.querySelector('.expenses_model').classList.toggle('hidden'));

        document.querySelectorAll('.income_model, .expenses_model').forEach(modal => {
            modal.addEventListener('click', (e) => {
                if (e.target === modal) modal.classList.add('hidden');
            });
        });
    </script>
</body>

</html>