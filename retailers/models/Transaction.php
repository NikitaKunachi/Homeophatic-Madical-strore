<?php
require_once "../includes/db.php";

class Transaction {
    public static function getTransactions($retailer_id) {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM transactions WHERE order_id IN (SELECT id FROM orders WHERE retailer_id = ?)");
        $stmt->execute([$retailer_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
