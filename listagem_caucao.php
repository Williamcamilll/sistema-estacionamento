# Updating 'listagem_caucao.php' to include a button for exporting to Excel
updated_listagem_caucao_with_export = """
<?php
require("conecta.php");

// Query para buscar todas as cauções
$query = "
    SELECT 
        Cartao_Caucao.ID_CARTAO,
        Cartao_Caucao.NOME_CARTAO,
        Cartao_Caucao.NUMERO_CARTAO,
        Cartao_Caucao.DT_VENCTO_CARTAO,
        Cartao_Caucao.CVC_CARTAO,
        Cliente.NOME AS CLIENTE_NOME,
        Cliente.CPF AS CLIENTE_CPF
    FROM Cartao_Caucao
    INNER JOIN Cliente ON Cartao_Caucao.CLIENTE = Cliente.CPF
";
$result = $conn->query($query);

echo '<div class="container mt-5">';
echo '<h1 class="text-center mb-4">Lista de Cauções</h1>';

if ($result->num_rows > 0) {
    // Botão de exportação
    echo '<div class="mb-3 text-end">';
    echo '<a href="exporta_caucao_excel.php" class="btn btn-success">Exportar para Excel</a>';
    echo '</div>';

    // Campo de busca
    echo '<div class="mb-3">';
    echo '<input type="text" id="searchInput" class="form-control" placeholder="Digite para buscar..." onkeyup="filterTable()">';
    echo '</div>';

    // Tabela
    echo "<table class='table table-striped table-bordered' id='caucaoTable'>";
    echo "<thead class='table-dark'>
            <tr>
                <th>ID</th>
                <th>Nome no Cartão</th>
                <th>Número do Cartão</th>
                <th>Data de Vencimento</th>
                <th>CVC</th>
                <th>Cliente</th>
                <th>CPF do Cliente</th>
            </tr>
          </thead>";
    echo "<tbody>";

    // Exibindo os resultados
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['ID_CARTAO']}</td>
                <td>{$row['NOME_CARTAO']}</td>
                <td>{$row['NUMERO_CARTAO']}</td>
                <td>{$row['DT_VENCTO_CARTAO']}</td>
                <td>{$row['CVC_CARTAO']}</td>
                <td>{$row['CLIENTE_NOME']}</td>
                <td>{$row['CLIENTE_CPF']}</td>
              </tr>";
    }

    echo "</tbody>";
    echo "</table>";
} else {
    echo "<div class='alert alert-warning text-center'>Nenhuma caução cadastrada.</div>";
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
        const table = document.getElementById("caucaoTable");
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
"""

# Save the updated 'listagem_caucao.php' with export button
with open(listagem_caucao_php_path, 'w', encoding='utf-8') as file:
    file.write(updated_listagem_caucao_with_export)

# Confirming the update
updated_listagem_caucao_with_export
