<?php
require("conecta.php");
require_once 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=clientes.xlsx");
header("Cache-Control: max-age=0");

try {
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->setTitle("Clientes");

    // Headers for the table
    $headers = ["CPF", "Nome", "Email", "Telefone", "CNH", "Data de Nascimento"];
    $column = 'A';

    foreach ($headers as $header) {
        $sheet->setCellValue("{$column}1", $header);
        $column++;
    }

    // Fetching data from the database
    $query = "SELECT CPF, NOME, EMAIL, TELEFONE, CNH, DT_NASC FROM cliente";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($result) > 0) {
        $rowNumber = 2; // Start at the second row for data
        foreach ($result as $row) {
            $sheet->setCellValue("A{$rowNumber}", htmlspecialchars($row["CPF"]));
            $sheet->setCellValue("B{$rowNumber}", htmlspecialchars($row["NOME"]));
            $sheet->setCellValue("C{$rowNumber}", htmlspecialchars($row["EMAIL"]));
            $sheet->setCellValue("D{$rowNumber}", htmlspecialchars($row["TELEFONE"]));
            $sheet->setCellValue("E{$rowNumber}", htmlspecialchars($row["CNH"]));
            $sheet->setCellValue("F{$rowNumber}", htmlspecialchars($row["DT_NASC"]));
            $rowNumber++;
        }
    } else {
        $sheet->setCellValue("A2", "Nenhum cliente encontrado.");
    }

    // Save the file
    $writer = new Xlsx($spreadsheet);
    $writer->save("php://output");
} catch (Exception $e) {
    echo json_encode(["status" => "error", "message" => "Erro ao exportar clientes: " . $e->getMessage()]);
}
?>
