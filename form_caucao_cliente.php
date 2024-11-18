<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Caução</title>
    <!-- Link do CSS do Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Cadastro de Caução</h1>
        <div class="card shadow">
            <div class="card-body">
                <form action="cadastra_caucao.php" method="POST">
                    <div class="mb-3">
                        <label for="nome_cartao" class="form-label">Nome no Cartão:</label>
                        <input type="text" id="nome_cartao" name="nome_cartao" class="form-control" placeholder="Ex: João da Silva" required>
                    </div>

                    <div class="mb-3">
                        <label for="numero_cartao" class="form-label">Número do Cartão:</label>
                        <input type="text" id="numero_cartao" name="numero_cartao" class="form-control" placeholder="Ex: 1234 5678 9012 3456" required>
                    </div>

                    <div class="mb-3">
                        <label for="data_vencimento" class="form-label">Data de Vencimento:</label>
                        <input type="date" id="data_vencimento" name="data_vencimento" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="cvc" class="form-label">CVC:</label>
                        <input type="text" id="cvc" name="cvc" class="form-control" placeholder="Ex: 123" required>
                    </div>

                    <div class="mb-3">
                        <label for="cliente" class="form-label">Cliente (CPF):</label>
                        <select name="cliente" id="cliente" class="form-select" required>
                            <option value="">Selecione um cliente</option>
                            <?php
                            require("conecta.php");

                            $query = "SELECT CPF, NOME FROM Cliente";
                            $result = $conn->query($query);

                            if ($result && $result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<option value='" . $row['CPF'] . "'>" . $row['NOME'] . " (" . $row['CPF'] . ")</option>";
                                }
                            } else {
                                echo "<option value=''>Nenhum cliente encontrado</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-primary px-5">Cadastrar</button>
                        <button type="reset" class="btn btn-secondary px-5">Limpar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Script do Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
