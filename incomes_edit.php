<?php
require_once("config.php");
$id = $_POST["id"];
$montant = $_POST["montant_incomes"];
$descripcion = $_POST["incomes_desc"];
$sql = "UPDATE incomes 
        SET montant='$montant', descri='$descripcion' 
        WHERE id=$id";

$conn->query($sql);
header( "location: incomes.php")
?>