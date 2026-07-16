<?php
require_once("config.php");

//VERIFICAR SE RECEBEMOS UM POST COM O ID
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = isset($_POST["id"]) ? intval($_POST["id"]) : 0;
    if ($id <= 0) {
        echo "Invalid ID";
        exit;
    }

    //COMANDO SQL PARA DELETAR PELO ID
    $stmt = $conn->prepare("UPDATE cliente SET status='deletado' WHERE id = ?");
    $stmt->bind_param("i", $id);

    //EXECUTAR COMANDO SQL E OQUE ACONTECE SE EXECUTAR
    if ($stmt->execute() === TRUE) {
        echo "<span style='background:green; color:white; padding:5px;'>Deletado com sucesso!</span><br><br>";
        echo "<a href='exibir_dados_soft_del.php'>Voltar para a lista</a><br><br>";
    } else {
        echo "<span style='background:red; color:white; padding:5px;'>Erro ao deletar: " . $stmt->error . "</span><br>";
        echo "<a href='exibir_dados_soft_del.php'>Voltar para a lista</a><br><br>";
    }
} else {
    header("Location: exibir_dados_soft_del.php"); 
    exit;
}