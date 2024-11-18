<?php
require("conecta.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recebendo a placa do veículo a ser excluído
    $placa_veiculo = mysqli_real_escape_string($conn, $_POST["placa_veiculo"]);

    // Query para excluir o veículo
    $query = "DELETE FROM Carro WHERE PLACA = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $placa_veiculo);

    // Executando a query
    if ($stmt->execute()) {
        echo "<center><h1>Veículo excluído com sucesso!</h1>";
        echo "<a href='listagem_veiculos.php'><input type='button' value='Voltar'></a></center>";
    } else {
        echo "<center><h3>Ocorreu um erro ao excluir o veículo:</h3></center>";
        echo "<p>" . $stmt->error . "</p>";
    }

    // Fechando o statement
    $stmt->close();
}

// Fechando a conexão
$conn->close();
?>
