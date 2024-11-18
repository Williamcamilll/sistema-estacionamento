<?php
require("conecta.php");

// Query corrigida para buscar os dados de veículos por marca
$query_marcas = "
    SELECT Marcas_Carro.NOME_MARCA, COUNT(Carro.MARCA) AS total
    FROM Carro
    INNER JOIN Marcas_Carro ON Carro.MARCA = Marcas_Carro.ID_MARCA
    GROUP BY Marcas_Carro.NOME_MARCA
";
$result_marcas = $conn->query($query_marcas);
$marcas = [];
$totais = [];
while ($row = $result_marcas->fetch_assoc()) {
    $marcas[] = $row['NOME_MARCA'];
    $totais[] = $row['total'];
}

// Consultas para os cartões do dashboard
$total_clientes = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM Cliente"))['total'];
$total_veiculos = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM Carro"))['total'];
$total_caucoes = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM Cartao_Caucao"))['total'];

// Exemplo de controle de vagas
$total_vagas = 100;
$vagas_ocupadas = $total_veiculos;
$vagas_disponiveis = $total_vagas - $vagas_ocupadas;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel de Controle</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Painel de Controle</h1>
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card text-white bg-primary mb-3">
                    <div class="card-header">Clientes</div>
                    <div class="card-body">
                        <h5 class="card-title">Total: <?php echo $total_clientes; ?></h5>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-success mb-3">
                    <div class="card-header">Veículos</div>
                    <div class="card-body">
                        <h5 class="card-title">Total: <?php echo $total_veiculos; ?></h5>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-warning mb-3">
                    <div class="card-header">Cauções</div>
                    <div class="card-body">
                        <h5 class="card-title">Total: <?php echo $total_caucoes; ?></h5>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-danger mb-3">
                    <div class="card-header">Vagas</div>
                    <div class="card-body">
                        <h5 class="card-title">Disponíveis: <?php echo $vagas_disponiveis; ?></h5>
                        <h5 class="card-title">Ocupadas: <?php echo $vagas_ocupadas; ?></h5>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <h3 class="text-center">Veículos por Marca</h3>
                <canvas id="chartVeiculosPorMarca"></canvas>
            </div>
        </div>
    </div>

    <script>
        const ctx = document.getElementById('chartVeiculosPorMarca').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($marcas); ?>,
                datasets: [{
                    label: 'Quantidade de Veículos',
                    data: <?php echo json_encode($totais); ?>,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'top' },
                    title: { display: true, text: 'Distribuição de Veículos por Marca' }
                },
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });
    </script>
</body>
</html>
