<?php
require("conecta.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recebendo os dados do formulário de forma segura
    $placa_carro = mysqli_real_escape_string($conn, $_POST['placa_carro']);
    $km = intval($_POST['km_carro']);
    $ano = intval($_POST['ano_carro']);
    $cor = mysqli_real_escape_string($conn, $_POST['cor_carro']);
    $descricao = mysqli_real_escape_string($conn, $_POST['descricao_carro']);
    $preco = floatval($_POST['preco_carro']);
    $modelo = mysqli_real_escape_string($conn, $_POST['modelo_carro']);
    $marca = intval($_POST['marca_carro']);

    // Usando prepared statements para segurança
    $stmt = $conn->prepare("INSERT INTO Carro (placa, marca, km, ano, cor, descricao, modelo, valor) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("siissssd", $placa_carro, $marca, $km, $ano, $cor, $descricao, $modelo, $preco);

    // Executando a query
    if ($stmt->execute()) {
        echo "<center><h1>Registro inserido com sucesso!</h1>";
        echo "<a href='index.html'><input type='button' value='Voltar'></a></center>";
    } else {
        echo "<center><h3>Ocorreu um erro ao inserir o registro:</h3></center>";
        echo "<p>" . $stmt->error . "</p>";
    }

    // Fechando o statement
    $stmt->close();
}

// Fechando a conexão
$conn->close();
?>
