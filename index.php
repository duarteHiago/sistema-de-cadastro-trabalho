<?php
// Inclui o arquivo de configuração para conectar ao banco de dados
include('config.php');

// Inicializa a variável de erro e sucesso
$mensagem = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recebe os dados do formulário
    $nome = $_POST['nome'];
    $rg = $_POST['rg'];
    $cpf = $_POST['cpf'];
    $cep = $_POST['cep'];

    // Insere os dados no banco de dados
    $sql = $conn->prepare("INSERT INTO alunos (nome, rg, cpf, cep) VALUES (?, ?, ?, ?)");
    $sql->bind_param("ssss", $nome, $rg, $cpf, $cep);

    // Verifica se a execução foi bem-sucedida
    if ($sql->execute()) {
        $mensagem = "Aluno cadastrado com sucesso!";
    } else {
        $mensagem = "Erro ao cadastrar aluno: " . $sql->error;
    }

    // Fecha a conexão preparada
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
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
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

        <button type="submit">Cadastrar</button>
    </form>
</body>
</html>
