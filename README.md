# Documentação de Software: Sistema de Cadastro de Alunos v0.2

Essa documentacao visa simular um ambiente real de desenvolvivemento, apenas destrinchando a arquitetura e tecnologias utilizadas. Se vc busca algo mais educativo e didatico, confira a documentacao da primeira versao desse projeto, la eu ensino a configurar todo seu ambiente de desenvolvimento, ensino tbm a baixar as dependencias do projeto. E tbm ajudo a resolver alguns erros que tive durante o meu desenvolvimento. Segue o link: https://drive.google.com/file/d/1PMe-fE-W-eCPLR81zp9xU1uH33yKP72x/view?usp=drive_link

## 1 - Visao Geral do Software

O Software de Cadastro de Alunos foi construido sob um ambiente web em um servidor Apache, desenvolvido em PHP, e estruturado em HTML e CSS. Sua finalidade é o cadastro de alunos de qualquer tipo instituição de ensino, desde escolas, universidades ou qualquer  vertente na área. Com campos preenchíveis para dados pessoais do aluno, para documentação do mesmo na instituição.

## 2 - Requisitos para Desenvolvimento

- **Sistema Operacional**: Windows
- **Navegador**: Chrome, Firefox, Edge
- **Versão PHP**: v8.0 ou superior
- **Servidor Web**: Xampp v3.3.0 (MySql, Apache inclusos)
- **Ambiente de Desenvolvimento**: Qualquer um compatível com os requisitos listados acima

## **3 - Arquitetura do Sistema**

A arquitetura do sistema segue o padrão **MVC (Model-View-Controller)**, onde:

- **Model**: Representa os dados e regras de negócios, com a interação com o banco de dados (MySql).
- **View**: Interface do usuário, construída utilizando HTML, CSS e PHP.
- **Controller**: Processa as entradas do usuário, atualiza o modelo e retorna as respostas para a view.

O sistema foi desenvolvido utilizando as tecnologias:

- **Backend**: PHP
- **Frontend**: HTML, CSS e PHP
- **Banco de Dados**: MySql

## **4 - Como instalar?**

Clone o repositório na sua máquina.

```bash
git clone <https://github.com/Astrinn/sistema-de-cadastro-trabalho>

```

# Configuracao do Ambiente

```bash
📍 Ambiente Local (Desenvolvimento)
   ├── Desenvolver e testar localmente 🔧
   ├── Commitar alterações ✅
   ▼  
📍 Ambiente de Versionamento (GitHub)
   ├── Push da branch para GitHub ⬆️
   ├── Revisar e commitar na branch `main` 🔄
   ├── Criar nova release (se necessário) 🏷️
   ▼  
📍 Ambiente Web (AWS)
   ├── Atualizar código no servidor AWS ☁️
   ├── Executar testes no ambiente web 🖥️
   ├── Monitorar possíveis erros 🚨
   ✔️ Projeto atualizado com sucesso!
```

# V0.2 (Implementacao de Sistema de Busca e Arquivos JSON e XML)

### 1- Estrutura de Arquivos

```html
/sistema_cadastro
|-- index.php
|-- config.php
|-- gerador_arquivo.php
|-- style.css
```

### 2- Arquivo HTML (index.php)

```html
<?php
// Inclui o arquivo de configuração para conectar ao banco de dados
include('config.php');
include('gerador_arquivo.php');

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

    if ($sql->execute()) {
        $mensagem = "Aluno cadastrado com sucesso!";
        // Gera os arquivos JSON e XML após o cadastro
        gerarJSON($conn);
        gerarXML($conn);
    } else {
        $mensagem = "Erro ao cadastrar aluno: " . $sql->error;
    }

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
        /* Resetando margens e padding para evitar problemas com o layout */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        h2 {
            margin-bottom: 20px;
            color: #333;
        }

        /* Definindo o layout de 2 colunas */
        form {
            display: grid;
            grid-template-columns: repeat(2, 1fr);  /* Duas colunas de largura igual */
            gap: 15px;  /* Espaçamento entre os campos */
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            background-color: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 90%;
            max-width: 600px;  /* Tamanho máximo do formulário */
            margin: 20px;
        }

        label {
            margin-bottom: 5px;
            color: #333;
        }

        input {
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
            width: 100%;
            box-sizing: border-box;
        }

        button {
            grid-column: span 2;  /* O botão ocupa ambas as colunas */
            padding: 10px 20px;
            background-color: rgb(17, 0, 255);
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin-top: 10px;
        }

        button:hover {
            background-color: rgb(17, 0, 255);
        }

        .mensagem {
            margin-top: 8px;
            color: green;
        }

        .erro {
            color: red;
        }

        /* Responsividade para telas pequenas */
        @media (max-width: 768px) {
            form {
                grid-template-columns: 1fr;  /* Em telas pequenas, os campos ficam em uma coluna */
                padding: 15px;
            }

            h2 {
                font-size: 1.5em;
            }

            label {
                font-size: 1.1em;
            }

            input {
                font-size: 1em;
            }

            button {
                font-size: 1.2em;
            }
        }
    </style>
</head>
<body>

    <h2>Cadastro de Aluno</h2>
    <form method="POST" action="">
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" required>

        <label for="rg">RG:</label>
        <input type="text" id="rg" name="rg" required>

        <label for="cpf">CPF:</label>
        <input type="text" id="cpf" name="cpf" required>

        <label for="cep">CEP:</label>
        <input type="text" id="cep" name="cep" required>

        <label for="matricula">Matrícula:</label>
        <input type="text" id="matricula" name="matricula" required>

        <label for="endereco">Endereço:</label>
        <input type="text" id="endereco" name="endereco" required>

        <label for="telefone">Telefone:</label>
        <input type="text" id="telefone" name="telefone" required>

        <!-- Botão de envio -->
        <button type="submit">Cadastrar</button>
    </form>

    <h2>Buscar Aluno</h2>
    <form method="POST" action="">
        <label for="nome_busca">Nome:</label>
        <input type="text" id="nome_busca" name="nome_busca" required><br>
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

    <h2>Baixar Arquivos</h2>
    <div class="botoes-download">
        <a href="tabela.json" download="tabela.json">
            <button>Baixar JSON</button>
        </a>
        <a href="tabela.xml" download="tabela.xml">
            <button>Baixar XML</button>
        </a>
    </div>

    <?php if ($mensagem): ?>
        <p><?php echo $mensagem; ?></p>
    <?php endif; ?>
</body>
</html>

```

### 3- **Configuração da Conexão de Banco de Dados (*config.php*)**

```html
<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "sistema_cadastro";

    $conn = new mysqli($servername, $username, $password, $dbname);     

    if ($conn->connect_error) {
        die("Falha na Conexao ao DB...". $conn->connect_error);
    }
?>
```

### 4- **Configuração CSS (*style.css*)**

```css
#container{
    display: flexbox;
    justify-content: space-between;
    align-items: center;

    top: 200px;
    bottom: 200px;
    left: 200px;
    right: 200px;

}
.botoes-download {
    position: fixed; /* Fixa os botões na tela */
    top: 20px; /* Distância do canto superior */
    left: 20px; /* Distância do canto esquerdo */
    display: flex;
    flex-direction: column; /* Botões em coluna */
    gap: 10px; /* Espaço entre os botões */
    z-index: 9999; /* Garante que os botões estejam acima de tudo */
}
```

### 5- Arquivo de Geracao de XML e JSON (gerador_arquivo.php)

```css
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

```

### **8 - Conclusão**

Este documento fornece um guia básico para configuração e execução da aplicação. Certifique-se de configurar corretamente o ambiente para evitar erros de conexão ao banco de dados.

### **9 -Trabalho Acadêmico**

Este trabalho foi desenvolvido para a disciplina de Engenharia de Software, ministrada pelo professor Felipe, na Faculdade de Ciências da Computação. Aluno responsável: Hiago Duarte.
