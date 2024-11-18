<?php
require("conecta.php");

// Exibir erros (apenas para desenvolvimento, remova em produção)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Validar o método de envio
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die(json_encode(["status" => "error", "message" => "Método de envio inválido. Use POST."]));
}

// Capturar e validar os dados
function validarDados($cpf, $email) {
    if (!preg_match('/^[0-9]{11}$/', $cpf)) {
        return "CPF inválido.";
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return "E-mail inválido.";
    }
    return true;
}

$cpf = $_POST['cpf'] ?? '';
$nome = $_POST['nome'] ?? '';
$email = $_POST['email'] ?? '';
$telefone = $_POST['telefone'] ?? '';
$cnh = $_POST['cnh'] ?? '';
$data_nascimento = $_POST['data_nascimento'] ?? '';

// Validar campos obrigatórios
if (empty($cpf) || empty($nome) || empty($email)) {
    die(json_encode(["status" => "error", "message" => "Campos obrigatórios não preenchidos."]));
}

// Validação extra
$validacao = validarDados($cpf, $email);
if ($validacao !== true) {
    die(json_encode(["status" => "error", "message" => $validacao]));
}

// Inserção segura com PDO
try {
    $query = "INSERT INTO cliente (CPF, NOME, EMAIL, TELEFONE, CNH, DT_NASC) 
              VALUES (:cpf, :nome, :email, :telefone, :cnh, :data_nascimento)";
    $stmt = $conn->prepare($query);
    $stmt->execute([
        ':cpf' => $cpf,
        ':nome' => $nome,
        ':email' => $email,
        ':telefone' => $telefone,
        ':cnh' => $cnh,
        ':data_nascimento' => $data_nascimento
    ]);
    echo json_encode(["status" => "success", "message" => "Cliente cadastrado com sucesso!"]);
} catch (PDOException $e) {
    echo json_encode(["status" => "error", "message" => "Erro ao cadastrar cliente: " . $e->getMessage()]);
}
