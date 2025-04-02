<?php
    $servername = "localhost";  // O IP público da instância EC2
    $username = "root";
    $password = "";
    $dbname = "sistema_cadastro";

    $conn = new mysqli($servername, $username, $password, $dbname);     

    if ($conn->connect_error) {
        die("Falha na Conexao ao DB...". $conn->connect_error);
    }

?>