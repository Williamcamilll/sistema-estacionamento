<?php
require("conecta.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recebendo os dados do formulário de edição
    $cpf_cliente = mysqli_real_escape_string($conn, $_POST["cpf_cliente"]);
    $nome_cliente = mysqli_real_escape_string($conn, $_POST["nome_cliente"]);
    $email_cliente = mysqli_real_escape_string($conn, $_POST["email_cliente"]);
    $telefone_cliente = mysqli_real_escape_string($conn, $_POST["telefone_cliente"]);
    $cnh_cliente = mysqli_real_escape_string($conn, $_POST["cnh_cliente"]);
    $dt_nascimento_cliente = mysqli_real_escape_string($conn, $_POST["dt_nascimento_cliente"]);

    // Query para atualizar os dados do cliente
    $query = "
        UPDATE Cliente
        SET NOME = ?, EMAIL = ?, TELEFONE = ?, CNH = ?, DT_NASCTO = ?
        WHERE CPF = ?
    ";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssssss", $nome_cliente, $email_cliente, $telefone_cliente, $cnh_cliente, $dt_nascimento_cliente, $cpf_cliente);

    // Executando a query
    if ($stmt->execute()) {
        echo "<center><h1>Dados do cliente atualizados com sucesso!</h1>";
        echo "<a href='listagem_clientes.php'><input type='button' value='Voltar'></a></center>";
    } else {
        echo "<center><h3>Ocorreu um erro ao atualizar os dados do cliente:</h3></center>";
        echo "<p>" . $stmt->error . "</p>";
    }

    // Fechando o statement
    $stmt->close();
}

// Fechando a conexão
$conn->close();
?>
