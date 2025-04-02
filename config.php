<?php
    $servername = "3.87.47.114";  // O IP público da instância EC2
    $username = "hiago";
    $password = "zqkwd10011";
    $dbname = "sistema_cadastro";

    $conn = new mysqli($servername, $username, $password, $dbname);     

    if ($conn->connect_error) {
        die("Falha na Conexao ao DB...". $conn->connect_error);
    }

?>