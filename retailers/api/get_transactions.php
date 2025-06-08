<?php
require_once "../models/Transaction.php";
header("Content-Type: application/json");

$transactions = Transaction::getTransactions($_GET["retailer_id"]);
echo json_encode($transactions);
?>
