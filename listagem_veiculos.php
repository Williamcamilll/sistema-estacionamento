<?php
require("conecta.php");

// Query para buscar todos os veículos
$query = "SELECT PLACA, NOME_MARCA, KM, ANO, COR, DESCRICAO, MODELO, VALOR FROM Carro INNER JOIN Marcas_Carro ON Carro.MARCA = Marcas_Carro.ID_MARCA";
$result = $conn->query($query);

echo '<div class="container mt-5">';
echo '<h1 class="text-center mb-4">Lista de Veículos</h1>';

if ($result->num_rows > 0) {
    // Botão de exportação
    echo '<div class="mb-3 text-end">';
    echo '<a href="exporta_veiculos_excel.php" class="btn btn-success">Exportar para Excel</a>';
    echo '</div>';

    // Campo de busca
    echo '<div class="mb-3">';
    echo '<input type="text" id="searchInput" class="form-control" placeholder="Digite para buscar..." onkeyup="filterTable()">';
    echo '</div>';

    // Tabela
    echo "<table class='table table-striped table-bordered' id='veiculosTable'>";
    echo "<thead class='table-dark'>
            <tr>
                <th>Placa</th>
                <th>Marca</th>
                <th>KM</th>
                <th>Ano</th>
                <th>Cor</th>
                <th>Descrição</th>
                <th>Modelo</th>
                <th>Valor</th>
                <th>Ações</th>
            </tr>
          </thead>";
    echo "<tbody>";

    // Exibindo os resultados
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['PLACA']}</td>
                <td>{$row['NOME_MARCA']}</td>
                <td>{$row['KM']}</td>
                <td>{$row['ANO']}</td>
                <td>{$row['COR']}</td>
                <td>{$row['DESCRICAO']}</td>
                <td>{$row['MODELO']}</td>
                <td>R$ {$row['VALOR']}</td>
                <td>
                    <form style='display:inline;' method='POST' action='edita_veiculo.php'>
                        <input type='hidden' name='placa_veiculo' value='{$row['PLACA']}'>
                        <button type='submit' class='btn btn-primary btn-sm'>Editar</button>
                    </form>
                    <form style='display:inline;' method='POST' action='exclui_veiculo.php' onsubmit='return confirm(\"Tem certeza que deseja excluir este veículo?\");'>
                        <input type='hidden' name='placa_veiculo' value='{$row['PLACA']}'>
                        <button type='submit' class='btn btn-danger btn-sm'>Excluir</button>
                    </form>
                </td>
              </tr>";
    }

    echo "</tbody>";
    echo "</table>";
} else {
    echo "<div class='alert alert-warning text-center'>Nenhum veículo cadastrado.</div>";
}

echo '</div>';

// Fechando a conexão
$conn->close();
?>

<script>
    // Função para filtrar a tabela
    function filterTable() {
        const input = document.getElementById("searchInput");
        const filter = input.value.toUpperCase();
        const table = document.getElementById("veiculosTable");
        const rows = table.getElementsByTagName("tr");

        for (let i = 1; i < rows.length; i++) {
            const cells = rows[i].getElementsByTagName("td");
            let match = false;

            for (let j = 0; j < cells.length; j++) {
                if (cells[j] && cells[j].innerText.toUpperCase().includes(filter)) {
                    match = true;
                    break;
                }
            }

            rows[i].style.display = match ? "" : "none";
        }
    }
</script>
