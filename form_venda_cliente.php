<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Venda</title>
    <!-- Link do CSS do Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Cadastro de Venda</h1>
        <div class="card shadow">
            <div class="card-body">
                <form action="cadastra_venda.php" method="POST">
                    <div class="mb-3">
                        <label for="cliente" class="form-label">Cliente (CPF):</label>
                        <select name="cliente" id="cliente" class="form-select" required>
                            <option value="">Selecione um cliente</option>
                            <?php
                            require("conecta.php");

                            // Consulta para buscar os clientes
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

                    <div class="mb-3">
                        <label for="data_venda" class="form-label">Data da Venda:</label>
                        <input type="date" id="data_venda" name="data_venda" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="valor_total" class="form-label">Valor Total:</label>
                        <input type="number" step="0.01" id="valor_total" name="valor_total" class="form-control" placeholder="Ex: 150.00" required>
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
