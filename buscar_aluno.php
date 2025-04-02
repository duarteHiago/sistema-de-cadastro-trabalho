<?php
include('config.php');

$mensagem = "";
$dados_aluno = "";

if (isset($_GET['nome_busca'])) {
    $nome_busca = $_GET['nome_busca'];
    $nome_busca = strtolower($nome_busca);

    $sql = $conn->prepare("SELECT * FROM alunos WHERE LOWER(nome) LIKE CONCAT(?, '%')");
    $sql->bind_param('s', $nome_busca);
    $sql->execute();

    $result = $sql->get_result();
    if ($result->num_rows > 0) {
        $dados_aluno = $result->fetch_assoc();
    } else {
        $mensagem = "Aluno não encontrado!";
    }
    $sql->close();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado da Busca</title>
    <style>
        table {
            width: 50%;
            border-collapse: collapse;
            margin: 20px auto;
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        .mensagem {
            text-align: center;
            color: red;
            font-size: 1.2em;
        }
    </style>
</head>
<body>
    <h2 style="text-align: center;">Resultado da Busca</h2>
    <?php if ($dados_aluno): ?>
        <table>
            <tr>
                <th>Campo</th>
                <th>Valor</th>
            </tr>
            <tr>
                <td>Nome</td>
                <td><?php echo htmlspecialchars($dados_aluno['nome']); ?></td>
            </tr>
            <tr>
                <td>RG</td>
                <td><?php echo htmlspecialchars($dados_aluno['rg']); ?></td>
            </tr>
            <tr>
                <td>CPF</td>
                <td><?php echo htmlspecialchars($dados_aluno['cpf']); ?></td>
            </tr>
            <tr>
                <td>CEP</td>
                <td><?php echo htmlspecialchars($dados_aluno['cep']); ?></td>
            </tr>
            <tr>
                <td>Matrícula</td>
                <td><?php echo htmlspecialchars($dados_aluno['matricula']); ?></td>
            </tr>
            <tr>
                <td>Endereço</td>
                <td><?php echo htmlspecialchars($dados_aluno['endereco']); ?></td>
            </tr>
            <tr>
                <td>Telefone</td>
                <td><?php echo htmlspecialchars($dados_aluno['telefone']); ?></td>
            </tr>
        </table>
    <?php else: ?>
        <p class="mensagem"><?php echo $mensagem; ?></p>
    <?php endif; ?>

    <!-- Botão para voltar à página principal -->
    <div style="text-align: center; margin-top: 20px;">
        <a href="index.php">
            <button style="padding: 10px 20px; background-color: #007BFF; color: white; border: none; border-radius: 5px; cursor: pointer; font-size: 1em;">
                Voltar à Página Principal
            </button>
        </a>
    </div>
</body>
</html>