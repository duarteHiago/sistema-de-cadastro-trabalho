<?php
// Inclui o arquivo de configuração para conectar ao banco de dados
include('config.php');

// Inicializa a variável de erro e sucesso
$mensagem = "";
$dados_aluno = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST' && !isset($_POST['buscar'])) {
    // Recebe os dados do formulário
    $nome = $_POST['nome'] ?? '';
    $rg = $_POST['rg'] ?? '';
    $cpf = $_POST['cpf'] ?? '';
    $cep = $_POST['cep'] ?? '';
    $matricula = $_POST['matricula'] ?? '';
    $endereco = $_POST['endereco'] ?? '';
    $telefone = $_POST['telefone'] ?? '';

    // Insere os dados no banco de dados
    $sql = $conn->prepare("INSERT INTO alunos (nome, rg, cpf, cep, matricula, endereco, telefone) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $sql->bind_param("sssssss", $nome, $rg, $cpf, $cep, $matricula, $endereco, $telefone);

    // Verifica se a execução foi bem-sucedida
    if ($sql->execute()) {
        $mensagem = "Aluno cadastrado com sucesso!";
    } else {
        $mensagem = "Erro ao cadastrar aluno: " . $sql->error;
    }

    // Fecha a conexão preparada
    $sql->close();
}

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['buscar'])) {
    $nome_busca = $_POST['nome_busca'];
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
    <title>Cadastro de Alunos</title>
    <style>
        /* Centralizar o conteúdo */
        body {
            display: flex;
            flex-direction: column;  /* Organiza os elementos em coluna */
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        h2 {
            margin-bottom: 20px;  /* Espaçamento entre o título e o formulário */
        }

        form {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            width: 300px;
        }

        label {
            margin-bottom: 5px;
        }

        input {
            margin-bottom: 10px;
            padding: 8px;
            width: 100%;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            padding: 10px 20px;
            background-color: rgb(17, 0, 255);
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color:rgb(17, 0, 255);
        }

        .mensagem {
            margin-top: 10px;
            color: green;  /* Cor da mensagem de sucesso */
        }

        .erro {
            color: red;  /* Cor da mensagem de erro */
        }
    </style>
</head>
<body>

    <h2>Cadastro de Aluno</h2>

    <form method="POST" action="">
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" required><br><br>

        <label for="rg">RG:</label>
        <input type="text" id="rg" name="rg" required><br><br>

        <label for="cpf">CPF:</label>
        <input type="text" id="cpf" name="cpf" required><br><br>

        <label for="cep">CEP:</label>
        <input type="text" id="cep" name="cep" required><br><br>

        <label for="matricula">Matricula:</label>
        <input type="text" id="matricula" name="matricula" required><br><br>

        <label for="endereco">Endereco:</label>
        <input type="text" id="endereco" name="endereco" required><br><br>

        <label for="telefone">Telefone:</label>
        <input type="text" id="telefone" name="telefone" required><br><br>

        <button type="submit">Cadastrar</button>
    </form>

    <h2>Buscar Aluno</h2>
    <form method="POST" action="">
        <label for="nome_busca">Nome:</label>
        <input type="text" id="nome_busca" name="nome_busca" required><br><br>

        <button type="submit" name="buscar">Buscar</button>
    </form>

    <?php if ($dados_aluno): ?>
        <div class="resultado">
            <h3>Dados do Aluno</h3>
            <p><strong>Nome:</strong> <?php echo htmlspecialchars($dados_aluno['nome']); ?></p>
            <p><strong>RG:</strong> <?php echo htmlspecialchars($dados_aluno['rg']); ?></p>
            <p><strong>CPF:</strong> <?php echo htmlspecialchars($dados_aluno['cpf']); ?></p>
            <p><strong>CEP:</strong> <?php echo htmlspecialchars($dados_aluno['cep']); ?></p>
            <p><strong>Matrícula:</strong> <?php echo htmlspecialchars($dados_aluno['matricula']); ?></p>
            <p><strong>Endereço:</strong> <?php echo htmlspecialchars($dados_aluno['endereco']); ?></p>
            <p><strong>Telefone:</strong> <?php echo htmlspecialchars($dados_aluno['telefone']); ?></p>
        </div>
    <?php endif; ?>

    <?php if ($mensagem): ?>
        <p class="<?php echo ($dados_aluno || strpos($mensagem, 'sucesso') !== false) ? 'mensagem' : 'erro'; ?>">
            <?php echo $mensagem; ?>
        </p>
    <?php endif; ?>
</body>
</html>