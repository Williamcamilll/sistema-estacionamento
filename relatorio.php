<?php
require_once 'conecta.php'; // Conecta ao banco de dados

// Função para buscar dados com base nos filtros
function fetchData($conn, $query) {
    $result = mysqli_query($conn, $query);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

// Filtros
$clienteFiltro = $_GET['cliente_nome'] ?? '';
$caucaoFiltro = $_GET['data_caucao'] ?? '';
$veiculoFiltro = $_GET['marca_veiculo'] ?? '';

// Consultas com Filtros
$clientesQuery = "SELECT * FROM Cliente WHERE NOME LIKE '%$clienteFiltro%'";
$clientes = fetchData($conn, $clientesQuery);

$caucaoQuery = "SELECT * FROM Cartao_Caucao WHERE DT_VENCTO_CARTAO LIKE '%$caucaoFiltro%'";
$caucao = fetchData($conn, $caucaoQuery);

$veiculosQuery = "SELECT * FROM Carro WHERE MARCA LIKE '%$veiculoFiltro%'";
$veiculos = fetchData($conn, $veiculosQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório Geral</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.html">Estacionamento</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link" href="index.html">Início</a></li>
                    <li class="nav-item"><a class="nav-link" href="dashboard.php">Painel de Controle</a></li>
                    <li class="nav-item"><a class="nav-link active" href="relatorio.php">Relatórios</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h1 class="text-center">Relatórios</h1>
        <ul class="nav nav-tabs mt-4" id="relatorioTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="clientes-tab" data-bs-toggle="tab" data-bs-target="#clientes" type="button" role="tab" aria-controls="clientes" aria-selected="true">Clientes</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="caucao-tab" data-bs-toggle="tab" data-bs-target="#caucao" type="button" role="tab" aria-controls="caucao" aria-selected="false">Caução</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="veiculos-tab" data-bs-toggle="tab" data-bs-target="#veiculos" type="button" role="tab" aria-controls="veiculos" aria-selected="false">Veículos</button>
            </li>
        </ul>

        <div class="tab-content mt-4" id="relatorioTabContent">
            <!-- Clientes -->
            <div class="tab-pane fade show active" id="clientes" role="tabpanel" aria-labelledby="clientes-tab">
                <h3>Clientes</h3>
                <form method="GET" class="mb-3">
                    <input type="text" name="cliente_nome" class="form-control" placeholder="Pesquisar por nome" value="<?= $clienteFiltro ?>">
                    <button type="submit" class="btn btn-primary mt-2">Filtrar</button>
                </form>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>CPF</th>
                            <th>Nome</th>
                            <th>Email</th>
                            <th>Telefone</th>
                            <th>CNH</th>
                            <th>Data de Nascimento</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($clientes as $cliente): ?>
                            <tr>
                                <td><?= $cliente['CPF'] ?></td>
                                <td><?= $cliente['NOME'] ?></td>
                                <td><?= $cliente['EMAIL'] ?></td>
                                <td><?= $cliente['TELEFONE'] ?></td>
                                <td><?= $cliente['CNH'] ?></td>
                                <td><?= $cliente['DT_NASC'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Caução -->
            <div class="tab-pane fade" id="caucao" role="tabpanel" aria-labelledby="caucao-tab">
                <h3>Caução</h3>
                <form method="GET" class="mb-3">
                    <input type="date" name="data_caucao" class="form-control" placeholder="Pesquisar por data" value="<?= $caucaoFiltro ?>">
                    <button type="submit" class="btn btn-primary mt-2">Filtrar</button>
                </form>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID Cartão</th>
                            <th>Nome no Cartão</th>
                            <th>Número</th>
                            <th>Data de Vencimento</th>
                            <th>CVC</th>
                            <th>Cliente (CPF)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($caucao as $c): ?>
                            <tr>
                                <td><?= $c['ID_CARTAO'] ?></td>
                                <td><?= $c['NOME_CARTAO'] ?></td>
                                <td><?= $c['NUMERO_CARTAO'] ?></td>
                                <td><?= $c['DT_VENCTO_CARTAO'] ?></td>
                                <td><?= $c['CVC_CARTAO'] ?></td>
                                <td><?= $c['CLIENTE'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Veículos -->
            <div class="tab-pane fade" id="veiculos" role="tabpanel" aria-labelledby="veiculos-tab">
                <h3>Veículos</h3>
                <form method="GET" class="mb-3">
                    <input type="text" name="marca_veiculo" class="form-control" placeholder="Pesquisar por marca" value="<?= $veiculoFiltro ?>">
                    <button type="submit" class="btn btn-primary mt-2">Filtrar</button>
                </form>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Placa</th>
                            <th>Marca</th>
                            <th>Modelo</th>
                            <th>Ano</th>
                            <th>Cor</th>
                            <th>Valor</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($veiculos as $veiculo): ?>
                            <tr>
                                <td><?= $veiculo['PLACA'] ?></td>
                                <td><?= $veiculo['MARCA'] ?></td>
                                <td><?= $veiculo['MODELO'] ?></td>
                                <td><?= $veiculo['ANO'] ?></td>
                                <td><?= $veiculo['COR'] ?></td>
                                <td><?= $veiculo['VALOR'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
