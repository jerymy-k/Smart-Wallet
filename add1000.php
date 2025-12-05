<?php
// -----------------------------
// CONFIG
// -----------------------------
$host = "localhost";
$user = "root";
$pass = "";
$db = "SmartWallet"; // bdelha ila bghiti

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// -----------------------------
// HELPERS
// -----------------------------

function randomDate($start, $end)
{
    $min = strtotime($start);
    $max = strtotime($end);
    $rand = mt_rand($min, $max);
    return date("Y-m-d", $rand);
}

$incomeDesc = ['Salaire', 'Bonus', 'Freelance', 'Vente', 'Prime', 'Other'];
$expenseDesc = ['Food', 'Transport', 'Shopping', 'Rent', 'Bills', 'Health', 'Fun', 'Other'];

// -----------------------------
// INSERT incomes
// -----------------------------

$stmt = $pdo->prepare("INSERT INTO incomes (montant, laDate, descri) VALUES (?, ?, ?)");

for ($i = 0; $i < 1000; $i++) {
    $montant = round(mt_rand(100, 5000) + mt_rand() / mt_getrandmax(), 2);
    $date = randomDate("2022-01-01", "2025-12-31");
    $desc = $incomeDesc[array_rand($incomeDesc)];

    $stmt->execute([$montant, $date, $desc]);
}

// -----------------------------
// INSERT expenses
// -----------------------------

$stmt2 = $pdo->prepare("INSERT INTO expenses (montant, laDate, descri) VALUES (?, ?, ?)");

for ($i = 0; $i < 1000; $i++) {
    $montant = round(mt_rand(5, 500) + mt_rand() / mt_getrandmax(), 2);
    $date = randomDate("2022-01-01", "2025-12-31");
    $desc = $expenseDesc[array_rand($expenseDesc)];

    $stmt2->execute([$montant, $date, $desc]);
}

echo "✓ 1000 incomes + 1000 expenses inserted successfully.";