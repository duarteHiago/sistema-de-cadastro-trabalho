<?php
function gerarJSON($conn) {
    // Consulta todos os registros da tabela 'alunos'
    $sql = $conn->prepare("SELECT * FROM alunos");
    $sql->execute();
    $result = $sql->get_result();

    // Transforma os resultados em um array associativo
    $dados = [];
    while ($row = $result->fetch_assoc()) {
        $dados[] = $row;
    }

    // Salva os dados como JSON em um arquivo
    file_put_contents("tabela.json", json_encode($dados, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    $sql->close();
}

function gerarXML($conn) {
    // Consulta todos os registros da tabela 'alunos'
    $sql = $conn->prepare("SELECT * FROM alunos");
    $sql->execute();
    $result = $sql->get_result();

    // Cria a estrutura base do XML
    $xml = new SimpleXMLElement('<Alunos/>');

    // Adiciona os registros ao XML
    while ($row = $result->fetch_assoc()) {
        $aluno = $xml->addChild('Aluno');
        foreach ($row as $key => $value) {
            $aluno->addChild($key, htmlspecialchars($value));
        }
    }

    // Salva os dados no arquivo XML
    $xml->asXML("tabela.xml");
    $sql->close();
}
?>
