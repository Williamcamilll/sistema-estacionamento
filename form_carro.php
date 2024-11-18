<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Carro</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Cadastro de Carro</h1>
        <form method="POST" action="cadastra_carro.php" class="needs-validation" novalidate>
            <div class="mb-3">
                <label for="placa_carro" class="form-label">Placa</label>
                <input type="text" id="placa_carro" name="placa_carro" class="form-control" required>
                <div class="invalid-feedback">Por favor, insira a placa do carro.</div>
            </div>
            <div class="mb-3">
                <label for="marca_carro" class="form-label">Marca</label>
                <select id="marca_carro" name="marca_carro" class="form-select" required>
                    <option value="">Selecione uma marca</option>
                    <?php
                    require("conecta.php");
                    $dados_select = mysqli_query($conn, "SELECT ID_MARCA, NOME_MARCA FROM Marcas_Carro");
                    while ($dado = mysqli_fetch_array($dados_select)) {
                        echo "<option value='" . $dado['ID_MARCA'] . "'>" . $dado['NOME_MARCA'] . "</option>";
                    }
                    ?>
                </select>
                <div class="invalid-feedback">Por favor, selecione uma marca.</div>
            </div>
            <div class="mb-3">
                <label for="km_carro" class="form-label">KM</label>
                <input type="number" id="km_carro" name="km_carro" class="form-control" required>
                <div class="invalid-feedback">Por favor, insira a quilometragem.</div>
            </div>
            <div class="mb-3">
                <label for="ano_carro" class="form-label">Ano</label>
                <input type="number" id="ano_carro" name="ano_carro" class="form-control" required>
                <div class="invalid-feedback">Por favor, insira o ano.</div>
            </div>
            <div class="mb-3">
                <label for="cor_carro" class="form-label">Cor</label>
                <input type="text" id="cor_carro" name="cor_carro" class="form-control" required>
                <div class="invalid-feedback">Por favor, insira a cor.</div>
            </div>
            <div class="mb-3">
                <label for="descricao_carro" class="form-label">Descrição</label>
                <textarea id="descricao_carro" name="descricao_carro" class="form-control" rows="3" required></textarea>
                <div class="invalid-feedback">Por favor, insira uma descrição.</div>
            </div>
            <div class="mb-3">
                <label for="preco_carro" class="form-label">Preço</label>
                <input type="number" id="preco_carro" name="preco_carro" step="0.01" class="form-control" required>
                <div class="invalid-feedback">Por favor, insira o preço.</div>
            </div>
            <div class="mb-3">
                <label for="modelo_carro" class="form-label">Modelo</label>
                <input type="text" id="modelo_carro" name="modelo_carro" class="form-control" required>
                <div class="invalid-feedback">Por favor, insira o modelo.</div>
            </div>
            <div class="d-flex justify-content-center">
                <button type="submit" class="btn btn-success me-2">Cadastrar</button>
                <button type="reset" class="btn btn-secondary">Limpar</button>
            </div>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Script para validação do formulário
        (function () {
            'use strict'
            const forms = document.querySelectorAll('.needs-validation')
            Array.from(forms).forEach(form => {
                form.addEventListener('submit', event => {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }
                    form.classList.add('was-validated')
                }, false)
            })
        })()
    </script>
</body>
</html>
