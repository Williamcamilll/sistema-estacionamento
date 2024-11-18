# Creating 'edita_veiculo.php' to allow editing of vehicle records
edita_veiculo_php_content = """
<?php
require("conecta.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recebendo os dados do formulário de edição
    $placa_veiculo = mysqli_real_escape_string($conn, $_POST["placa_veiculo"]);
    $marca_veiculo = intval($_POST["marca_veiculo"]);
    $km_veiculo = intval($_POST["km_veiculo"]);
    $ano_veiculo = intval($_POST["ano_veiculo"]);
    $cor_veiculo = mysqli_real_escape_string($conn, $_POST["cor_veiculo"]);
    $descricao_veiculo = mysqli_real_escape_string($conn, $_POST["descricao_veiculo"]);
    $modelo_veiculo = mysqli_real_escape_string($conn, $_POST["modelo_veiculo"]);
    $valor_veiculo = floatval($_POST["valor_veiculo"]);

    // Query para atualizar os dados do veículo
    $query = "
        UPDATE Carro
        SET MARCA = ?, KM = ?, ANO = ?, COR = ?, DESCRICAO = ?, MODELO = ?, VALOR = ?
        WHERE PLACA = ?
    ";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("iisssds", $marca_veiculo, $km_veiculo, $ano_veiculo, $cor_veiculo, $descricao_veiculo, $modelo_veiculo, $valor_veiculo, $placa_veiculo);

    // Executando a query
    if ($stmt->execute()) {
        echo "<center><h1>Dados do veículo atualizados com sucesso!</h1>";
        echo "<a href='listagem_veiculos.php'><input type='button' value='Voltar'></a></center>";
    } else {
        echo "<center><h3>Ocorreu um erro ao atualizar os dados do veículo:</h3></center>";
        echo "<p>" . $stmt->error . "</p>";
    }

    // Fechando o statement
    $stmt->close();
}

// Fechando a conexão
$conn->close();
?>
