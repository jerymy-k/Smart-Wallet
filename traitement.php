<?php
require_once('config.php');

if (isset($_POST['montant_incomes'])) {
    $montant_incomes = $_POST['montant_incomes'];
    $incomes_desc = $_POST['incomes_desc'];
    $sql = "INSERT INTO incomes (montant , descri ) VALUES ('$montant_incomes' , '$incomes_desc')";
    $conn->query($sql);
}

if (isset($_POST['montant_expenses'])) {
    $montant_expenses = $_POST['montant_expenses'];
    $expenses_desc = $_POST['expenses_desc'];
    $sql = "INSERT INTO expenses (montant , descri ) VALUES ('$montant_expenses' , '$expenses_desc')";
    $conn->query($sql);
}
header("location: index.php");
