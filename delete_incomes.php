<?php
require_once("config.php");

$id = $_GET['id'];

$sql = "DELETE FROM incomes WHERE id=$id";
$conn->query($sql);

$conn->query("SET @num := 0");
$conn->query("UPDATE incomes SET id = (@num := @num + 1) ORDER BY id");
$conn->query("ALTER TABLE incomes AUTO_INCREMENT = 1");

header("Location: incomes.php");
exit;
?>