<?php
require("conecta.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome_cartao = $_POST['nome_cartao'] ?? null;
    $numero_cartao = $_POST['numero_cartao'] ?? null;
    $data_vencimento = $_POST['data_vencimento'] ?? null;
    $cvc = $_POST['cvc'] ?? null;
    $cliente = $_POST['cliente'] ?? null;

    if ($nome_cartao && $numero_cartao && $data_vencimento && $cvc && $cliente) {
        $query = "INSERT INTO Cartao_Caucao (NOME_CARTAO, NUMERO_CARTAO, DT_VENCTO_CARTAO, CVC_CARTAO, CLIENTE)
                  VALUES ('$nome_cartao', '$numero_cartao', '$data_vencimento', '$cvc', '$cliente')";

        if ($conn->query($query) === TRUE) {
            echo "<div style='text-align: center; font-size: 20px; color: green;'>Caução cadastrada com sucesso!</div>";
        } else {
            echo "<div style='text-align: center; font-size: 20px; color: red;'>Erro ao cadastrar caução: " . $conn->error . "</div>";
        }
    } else {
        echo "<div style='text-align: center; font-size: 20px; color: red;'>Erro: Dados incompletos para o formulário.</div>";
    }
} else {
    echo "<div style='text-align: center; font-size: 20px; color: red;'>Método inválido de requisição.</div>";
}
