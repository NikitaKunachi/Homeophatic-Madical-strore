<?php
require('fpdf/fpdf.php'); // Include FPDF for PDF
require('PHPExcel/PHPExcel.php'); // Include PHPExcel for Excel

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "homeopathic_store";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$type = $_GET['type'];

$sql = "SELECT * FROM transactions";
$result = $conn->query($sql);

if ($type == 'pdf') {
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 14);
    $pdf->Cell(190, 10, 'Transaction History', 1, 1, 'C');

    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(40, 10, 'ID', 1);
    $pdf->Cell(50, 10, 'Amount', 1);
    $pdf->Cell(50, 10, 'Status', 1);
    $pdf->Cell(50, 10, 'Date', 1);
    $pdf->Ln();

    while ($row = $result->fetch_assoc()) {
        $pdf->Cell(40, 10, $row['id'], 1);
        $pdf->Cell(50, 10, "$" . $row['amount'], 1);
        $pdf->Cell(50, 10, $row['status'], 1);
        $pdf->Cell(50, 10, $row['date'], 1);
        $pdf->Ln();
    }

    $pdf->Output('D', 'Transaction_Report.pdf');
} elseif ($type == 'excel') {
    $excel = new PHPExcel();
    $excel->setActiveSheetIndex(0);
    $sheet = $excel->getActiveSheet();
    $sheet->setCellValue("A1", "Transaction ID");
    $sheet->setCellValue("B1", "Amount");
    $sheet->setCellValue("C1", "Status");
    $sheet->setCellValue("D1", "Date");

    $rowNum = 2;
    while ($row = $result->fetch_assoc()) {
        $sheet->setCellValue("A$rowNum", $row['id']);
        $sheet->setCellValue("B$rowNum", "$" . $row['amount']);
        $sheet->setCellValue("C$rowNum", $row['status']);
        $sheet->setCellValue("D$rowNum", $row['date']);
        $rowNum++;
    }

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="Transaction_Report.xlsx"');
    $writer = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
    $writer->save('php://output');
}

$conn->close();
?>
