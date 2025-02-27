<?php
// Inclui o arquivo de configuração para conectar ao banco de dados
include('config.php');

// Verifica se o formulário foi enviado
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Recebe os dados do formulário
        $nome = $_POST['nome'];
        $rg = $_POST['rg'];
        $cpf = $_POST['cpf'];
        $cep = $_POST['cep'];

    // Insere os dados no banco de dados
    $sql = "INSERT INTO alunos (nome, rg, cpf, cep) VALUES ('$nome', '$rg', '$cpf', '$cep')";

    if ($conn->query($sql) === TRUE) {
        echo "Novo aluno cadastrado com sucesso!";
    } else {
        echo "Erro: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Alunos</title>
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
