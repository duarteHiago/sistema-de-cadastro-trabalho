<?php
// Gera um arquivo JSON com os dados da tabela do banco de dados
function gerarJSON($conn) {
    // Prepara a consulta para pegar todos os registros
    $sql = $conn->prepare("SELECT * FROM alunos");
    $sql->execute();
    $result = $sql->get_result();

    // Converte os resultados em um array associativo
    $dados = [];
    while ($row = $result->fetch_assoc()) {
        $dados[] = $row;
    }

    // Salva os dados no arquivo tabela.json
    file_put_contents("tabela.json", json_encode($dados, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

    // Fecha a conexão preparada
    $sql->close();
}

// Gera um arquivo XML com os dados da tabela do banco de dados
function gerarXML($conn) {
    // Prepara a consulta para pegar todos os registros
    $sql = $conn->prepare("SELECT * FROM alunos");
    $sql->execute();
    $result = $sql->get_result();

    // Cria a estrutura XML inicial
    $xml = new SimpleXMLElement('<Alunos/>');

    // Adiciona os registros ao XML
    while ($row = $result->fetch_assoc()) {
        $aluno = $xml->addChild('Aluno'); // Cada registro será um "Aluno"
        foreach ($row as $key => $value) {
            $aluno->addChild($key, htmlspecialchars($value)); // Adiciona cada campo como um nó filho
        }
    }

    // Salva o XML no arquivo tabela.xml
    $xml->asXML("tabela.xml");

    // Fecha a conexão preparada
    $sql->close();
}
?>
