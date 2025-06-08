<?php
require_once "../models/Medicine.php";
header("Content-Type: application/json");

$medicines = Medicine::getAllMedicines();
echo json_encode($medicines);
?>
