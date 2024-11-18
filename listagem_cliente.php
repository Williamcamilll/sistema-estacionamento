<?php
require("conecta.php");

// Query para buscar todos os clientes
$query = "SELECT CPF, NOME, EMAIL, TELEFONE, CNH, DT_NASCTO FROM Cliente";
$result = $conn->query($query);

echo '<div class="container mt-5">';
echo '<h1 class="text-center mb-4">Lista de Clientes</h1>';

if ($result->num_rows > 0) {
    // Botão de exportação
    echo '<div class="mb-3 text-end">';
    echo '<a href="exporta_clientes_excel.php" class="btn btn-success">Exportar para Excel</a>';
    echo '</div>';

    // Campo de busca
    echo '<div class="mb-3">';
    echo '<input type="text" id="searchInput" class="form-control" placeholder="Digite para buscar..." onkeyup="filterTable()">';
    echo '</div>';

    // Tabela
    echo "<table class='table table-striped table-bordered' id='clientesTable'>";
    echo "<thead class='table-dark'>
            <tr>
                <th>CPF</th>
                <th>Nome</th>
                <th>Email</th>
                <th>Telefone</th>
                <th>CNH</th>
                <th>Data de Nascimento</th>
                <th>Ações</th>
            </tr>
          </thead>";
    echo "<tbody>";

    // Exibindo os resultados
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['CPF']}</td>
                <td>{$row['NOME']}</td>
                <td>{$row['EMAIL']}</td>
                <td>{$row['TELEFONE']}</td>
                <td>{$row['CNH']}</td>
                <td>{$row['DT_NASCTO']}</td>
                <td>
                    <form style='display:inline;' method='POST' action='edita_cliente.php'>
                        <input type='hidden' name='cpf_cliente' value='{$row['CPF']}'>
                        <button type='submit' class='btn btn-primary btn-sm'>Editar</button>
                    </form>
                    <form style='display:inline;' method='POST' action='exclui_cliente.php' onsubmit='return confirm(\"Tem certeza que deseja excluir este cliente?\");'>
                        <input type='hidden' name='cpf_cliente' value='{$row['CPF']}'>
                        <button type='submit' class='btn btn-danger btn-sm'>Excluir</button>
                    </form>
                </td>
              </tr>";
    }

    echo "</tbody>";
    echo "</table>";
} else {
    echo "<div class='alert alert-warning text-center'>Nenhum cliente cadastrado.</div>";
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
        const table = document.getElementById("clientesTable");
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
