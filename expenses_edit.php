<?php
require_once("config.php");
$id = $_POST["id"];
$montant = $_POST["montant_expenses"];
$descripcion = $_POST["expenses_desc"];
$sql = "UPDATE expenses 
        SET montant='$montant', descri='$descripcion' 
        WHERE id=$id";

$conn->query($sql);
header( "location: expenses.php")
?>