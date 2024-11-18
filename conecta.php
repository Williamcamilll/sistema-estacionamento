<?php
$servername = "localhost"; // Servidor do banco de dados
$username = "root";        // Nome de usuário do banco
$password = "";            // Senha do banco (geralmente vazia no XAMPP)
$dbname = "estacionamento"; // Nome do banco de dados

// Criar a conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar a conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}
?>
