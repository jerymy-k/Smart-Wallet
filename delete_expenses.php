<?php
require_once("config.php");

$id = $_GET['id'];

$sql = "DELETE FROM expenses WHERE id=$id";
$conn->query($sql);

$conn->query("SET @num := 0");
$conn->query("UPDATE expenses SET id = (@num := @num + 1) ORDER BY id");
$conn->query("ALTER TABLE expenses AUTO_INCREMENT = 1");

header("Location: expenses.php");
exit;
?>