<?php
require("conecta.php");
require_once 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=veiculos.xlsx");
header("Cache-Control: max-age=0");

try {
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->setTitle("Veículos");

    // Definir cabeçalhos
    $headers = ["Placa", "Marca", "KM", "Ano", "Cor", "Descrição", "Modelo", "Valor"];
    $column = 'A';
    foreach ($headers as $header) {
        $sheet->setCellValue("{$column}1", $header);
        $column++;
    }

    // Buscar dados do banco
    $query = "
        SELECT PLACA, NOME_MARCA, KM, ANO, COR, DESCRICAO, MODELO, VALOR
        FROM carro
        INNER JOIN marcas_carro ON carro.MARCA = marcas_carro.ID_MARCA
    ";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $vehicles = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (!empty($vehicles)) {
        $rowNumber = 2; // Dados começam na linha 2
        foreach ($vehicles as $vehicle) {
            $sheet->setCellValue("A{$rowNumber}", htmlspecialchars($vehicle['PLACA']));
            $sheet->setCellValue("B{$rowNumber}", htmlspecialchars($vehicle['NOME_MARCA']));
            $sheet->setCellValue("C{$rowNumber}", htmlspecialchars($vehicle['KM']));
            $sheet->setCellValue("D{$rowNumber}", htmlspecialchars($vehicle['ANO']));
            $sheet->setCellValue("E{$rowNumber}", htmlspecialchars($vehicle['COR']));
            $sheet->setCellValue("F{$rowNumber}", htmlspecialchars($vehicle['DESCRICAO']));
            $sheet->setCellValue("G{$rowNumber}", htmlspecialchars($vehicle['MODELO']));
            $sheet->setCellValue("H{$rowNumber}", htmlspecialchars($vehicle['VALOR']));
            $rowNumber++;
        }
    } else {
        $sheet->setCellValue("A2", "Nenhum veículo encontrado.");
    }

    // Salvar o arquivo
    $writer = new Xlsx($spreadsheet);
    $writer->save("php://output");
} catch (Exception $e) {
    echo json_encode(["status" => "error", "message" => "Erro ao exportar veículos: " . $e->getMessage()]);
}
?>
