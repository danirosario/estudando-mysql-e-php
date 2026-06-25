<?php
// aprendendo a conectar o php com o banco de dados

//CREDENCIAIS DO BANCO DE DADOS

$server = "localhost";
$user = "root";
$pass = "123456";
$db = "teste_db";

//CONEXÃO 

$conn = mysqli_connect($server, $user, $pass, $db);

// VERIFICAR CONEXÃO

if ($conn->connect_error) {
    die("connect error:" . $conn->connect_error);
}

//echo "Connection successfully established.";