# Documentação de Software: Sistema de Cadastro de Alunos

## 1 - Visao Geral do Software

  O Software de Cadastro de Alunos foi construido sob um ambiente web em um servidor Apache, desenvolvido em PHP, e estruturado em HTML e CSS. Sua finalidade é o cadastro de alunos de qualquer tipo instituição de ensino, desde escolas, universidades ou qualquer  vertente na área. Com campos preenchíveis para dados pessoais do aluno, para documentação do mesmo na instituição.

## 2 - Requisitos

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

- **Backend**: PHP e Xampp
- **Frontend**: HTML, CSS e PHP
- **Banco de Dados**: MySql

## **4 - Como instalar?**

 Clone o repositório na sua máquina.

```bash
git clone https://github.com/Astrinn/sistema-de-cadastro-trabalho
```

Baixe o Xampp

### Usando o **curl**:

1. Abra o **Prompt de Comando** (CMD) no Windows.
2. Execute o comando para baixar o XAMPP (exemplo de versão):
    
    ```bash
    curl -L -o xampp-installer.exe https://www.apachefriends.org/xampp-files/8.1.6/xampp-windows-x64-8.1.6-0-VC15-installer.exe
    ```
    

### Usando o **wget**:

1. Caso tenha o **wget** instalado, use o comando abaixo:

```bash
wget https://www.apachefriends.org/xampp-files/8.1.6/xampp-windows-x64-8.1.6-0-VC15-installer.exe
```

## 5.1- Configurar Banco de Dados

Execute o Xammp e siga os passos da instalação (Obs: Não se esqueça de autorizar os recursos do Apache e do MySql).

Ao abri-lo inicie o servidor Apache e MySql, desta maneira:

![image.png](images/image.png)

Caso ao iniciar o servidor MySql um erro surja, certifique-se que não há nenhum outro processo em andamento na sua máquina que esteja utilizando as portas de rede :3306 ou :3307. Para remediar basta encerrar o processo por meio do Gerenciador de Tarefas. Se o erro persistir, ou outro erro aparecer, procure ajuda no forum da comunidade do Xampp, segue o link: [Apache Friends Support Forum - Index page](https://community.apachefriends.org/f/).

### 5.2 - phpMyAdmin

Apos a configuração do Xampp, abra o navegador de sua preferencia e digite na barra de URL:

```bash
//localhost/phpMyAdmin/
```

PhpMyAdmin é um serviço instalado juntamente ao Xampp, ele é responsável por toda configuração do banco de dados MySql. E é nele que faremos nossa conexão entre código e DB.

Agora para criar o Banco de Dados basta seguir esse passo a passo:

![Screenshot 2025-02-28 044933.png](images/image 1.png)

De um nome ao seu banco e em seguida crie as colunas com cada campo que armazenaram as informções inseridas pelos usuários (nome, rg, cpf, cep,etc). Crie tambem uma coluna chamada Id, para podermos fazer buscas mais rápidas pela tabela, apenas usando o id das colunas. Selecione o tipo de cada coluna de acordo com o valor a ser recebido por ela. E tambem ative o AUTO_INCREMENT para a coluna Id.

Assim seu DB esta praticamente configurado, agora vamos conecta-lo ao seu ambiente de desenvolvimento.

## 6.1 - Ambiente de Desenvolvimento

Nesta documentação usaremos o editor de texto Visual Studio Code. 

### 6.2 - Dependencias VisualStudio Code

- Extensão PHP Intellisense
- Extensão SQLTolls
- Extensão SQLTools MySql

### 6.3 - Conexão com o Banco de Dados

Configure seu painel de conexão com os seus dados.

![image.png](image%201.png)

Para certificar que a conexão com seu DB esteja online, esta janela precisa aparecer:

![image.png](images/image 2.png)

Agora seu banco de dados esta totalmente conectado e pronto para ser manipulado em seu código.

## 7 - Desenvolvimento do Software
