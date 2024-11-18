<?php
require("conecta.php");
require_once 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=caucao.xlsx");
header("Cache-Control: max-age=0");

try {
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->setTitle("Cauções");

    // Definir cabeçalhos
    $headers = ["ID", "Nome no Cartão", "Últimos Dígitos do Cartão", "Data de Vencimento", "Cliente", "CPF do Cliente"];
    $column = 'A';
    foreach ($headers as $header) {
        $sheet->setCellValue("{$column}1", $header);
        $column++;
    }

    // Buscar dados do banco
    $query = "
        SELECT 
            Cartao_Caucao.ID_CARTAO,
            Cartao_Caucao.NOME_CARTAO,
            RIGHT(Cartao_Caucao.NUMERO_CARTAO, 4) AS ULTIMOS_DIGITOS,
            Cartao_Caucao.DT_VENCTO_CARTAO,
            Cliente.NOME AS CLIENTE,
            Cliente.CPF
        FROM cartao_caucao
        INNER JOIN cliente ON cartao_caucao.CLIENTE = cliente.CPF
    ";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $caucao = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (!empty($caucao)) {
        $rowNumber = 2; // Dados começam na linha 2
        foreach ($caucao as $row) {
            $sheet->setCellValue("A{$rowNumber}", htmlspecialchars($row['ID_CARTAO']));
            $sheet->setCellValue("B{$rowNumber}", htmlspecialchars($row['NOME_CARTAO']));
            $sheet->setCellValue("C{$rowNumber}", htmlspecialchars($row['ULTIMOS_DIGITOS']));
            $sheet->setCellValue("D{$rowNumber}", htmlspecialchars($row['DT_VENCTO_CARTAO']));
            $sheet->setCellValue("E{$rowNumber}", htmlspecialchars($row['CLIENTE']));
            $sheet->setCellValue("F{$rowNumber}", htmlspecialchars($row['CPF']));
            $rowNumber++;
        }
    } else {
        $sheet->setCellValue("A2", "Nenhuma caução encontrada.");
    }

    // Salvar o arquivo
    $writer = new Xlsx($spreadsheet);
    $writer->save("php://output");
} catch (Exception $e) {
    echo json_encode(["status" => "error", "message" => "Erro ao exportar cauções: " . $e->getMessage()]);
}
?>
