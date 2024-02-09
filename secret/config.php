<?php

$dbHost = 'localhost:3306';
$dbUsername = 'root';
$dbPassword = '';
$dbName = 'registro';

$conexao = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

// if ($conexao->connect_errno) {
//     debug_to_console("Erro ao conectar com o banco de dados: " . $conexao->connect_error);
// } else {
//     debug_to_console("Conectado");
// }