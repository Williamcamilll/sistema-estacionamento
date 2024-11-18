
<?php
require("conecta.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recebendo os dados do formulário de forma segura
    $nome_marca = mysqli_real_escape_string($conn, $_POST["nome_marca"]);

    // Usando prepared statements para segurança
    $stmt = $conn->prepare("INSERT INTO Marcas_Carro (NOME_MARCA) VALUES (?)");
    $stmt->bind_param("s", $nome_marca);

    // Executando a query
    if ($stmt->execute()) {
        echo "<center><h1>Marca cadastrada com sucesso!</h1>";
        echo "<a href='index.html'><input type='button' value='Voltar'></a></center>";
    } else {
        echo "<center><h3>Ocorreu um erro ao cadastrar a marca:</h3></center>";
        echo "<p>" . $stmt->error . "</p>";
    }

    // Fechando o statement
    $stmt->close();
}

// Fechando a conexão
$conn->close();
?>
