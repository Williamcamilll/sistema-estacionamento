<?php
require("conecta.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recebendo o CPF do cliente a ser excluído
    $cpf_cliente = mysqli_real_escape_string($conn, $_POST["cpf_cliente"]);

    // Query para excluir o cliente
    $query = "DELETE FROM Cliente WHERE CPF = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $cpf_cliente);

    // Executando a query
    if ($stmt->execute()) {
        echo "<center><h1>Cliente excluído com sucesso!</h1>";
        echo "<a href='listagem_clientes.php'><input type='button' value='Voltar'></a></center>";
    } else {
        echo "<center><h3>Ocorreu um erro ao excluir o cliente:</h3></center>";
        echo "<p>" . $stmt->error . "</p>";
    }

    // Fechando o statement
    $stmt->close();
}

// Fechando a conexão
$conn->close();
?>

