<?php
require_once "../includes/db.php";

class Medicine {
    public static function getAllMedicines() {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM medicines");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
