<?php
// INCLUINDO O ARQUIVO DE CONFIGURAÇÃO
require_once("config.php");

//RECUPERAR O VALOR DO ID DO METODO GET
$id = isset($_GET["id"]) ? intval($_GET["id"]) :0;
if ($id <= 0) {
    echo"Invalid ID.";
    exit;
}


//VERIFICAR SE RECEBEMOS OS DADOS DO FORMULARIO PELO METODO POST

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //RECEBER OS DADOS DO FORMULARIO
    $nome = trim($_POST["nome"]); //trim remove espaços em branco 
    $idade = $_POST["idade"];
    $email = $_POST["email"];

    //FAZER UMA VALIDAÇÃO SIMPLES DOS DADOS RECEBIDOS
    if (empty($nome) || empty($idade) || empty($email) || !is_numeric($idade)) {
        echo "Dados inválidos!";
    } else {
        $idade = (int) $idade; //converter idade para inteiro

        //PREPARAR O COMANDO SQL PARA INSERÇÃO DOS DADOS
        $stmt = $conn->prepare("INSERT INTO cliente (nome, idade, email) VALUES (?,?,?)");
        $stmt->bind_param("sis", $nome, $idade, $email); // VINCULANDO OS PARAMETROS

        //EXECUTAR O SQL
        if($stmt->execute()) {
            echo "Cadastro realizado com sucesso!";
        } else {
            echo "Erro ao cadastrar: " . $stmt->error;
        }

        //FECHAR A CONEXÃO
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar</title>
</head>

<body>
    <form action="" method="POST">
        <label>Nome:</label>
        <input type="text" name="nome" required>
        <br><br>
        <label>Idade:</label>
        <input type="number" name="idade" required>
        <br><br>
        <label>Email:</label>
        <input type="email" name="email" required>
        <br><br>
        <button type="submit">Salvar</button>
    </form>
</body>

</html>