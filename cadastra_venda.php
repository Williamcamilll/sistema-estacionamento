<?php
require("conecta.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cliente = $_POST['cliente'] ?? null;
    $data_venda = $_POST['data_venda'] ?? null;
    $valor_total = $_POST['valor_total'] ?? null;

    if ($cliente && $data_venda && $valor_total) {
        $query = "INSERT INTO Venda (CLIENTE, DATA_VENDA, VALOR_TOTAL)
                  VALUES ('$cliente', '$data_venda', '$valor_total')";

        if ($conn->query($query) === TRUE) {
            echo "<div style='text-align: center; font-size: 20px; color: green;'>Venda cadastrada com sucesso!</div>";
        } else {
            echo "<div style='text-align: center; font-size: 20px; color: red;'>Erro ao cadastrar venda: " . $conn->error . "</div>";
        }
    } else {
        echo "<div style='text-align: center; font-size: 20px; color: red;'>Erro: Dados incompletos para o formulário.</div>";
    }
} else {
    echo "<div style='text-align: center; font-size: 20px; color: red;'>Método inválido de requisição.</div>";
}
