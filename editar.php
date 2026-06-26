<?php
// INCLUINDO O ARQUIVO DE CONFIGURAÇÃO
require_once("config.php");

//RECUPERAR O VALOR DO ID DO METODO GET
$id = isset($_GET["id"]) ? intval($_GET["id"]) :0;
if ($id <= 0) {
    echo"Invalid ID.";
    exit;
}

//BUSCAR OS DADOS VIA ID
$stmt = $conn->prepare("SELECT nome, idade, email FROM cliente WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result(); 
$cliente = $result->fetch_assoc();
if(!$cliente) {
    echo "not found";
    exit;
}


//VERIFICAR SE RECEBEMOS OS DADOS DO FORMULARIO PELO METODO POST

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //RECEBER OS DADOS DO FORMULARIO
    $nome = trim($_POST["nome"]); //trim remove espaços em branco 
    $idade = $_POST["idade"];
    $email = $_POST["email"];
    $id = $_POST["id"];

    //FAZER UMA VALIDAÇÃO SIMPLES DOS DADOS RECEBIDOS
    if (empty($nome) || empty($idade) || empty($email) || !is_numeric($idade)) {
        echo "Dados inválidos!";
    } else {
        $idade = (int) $idade; //converter idade para inteiro

        //PREPARAR O COMANDO SQL PARA INSERÇÃO DOS DADOS
        $stmt = $conn->prepare("UPDATE cliente SET nome = ?, idade = ?, email = ? WHERE id = ?");
        $stmt->bind_param("sisi", $nome, $idade, $email, $id); // VINCULANDO OS PARAMETROS

        //EXECUTAR O SQL
        if($stmt->execute()) {
            echo "Edição realizado com sucesso!";
        } else {
            echo "Erro ao editar: " . $stmt->error;
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
        <input type="hidden" name="id" value="<?php echo $id; ?>" required>
        <label>Nome:</label>
        <input type="text" name="nome" value="<?php echo $cliente['nome']; ?>" required>
        <br><br>
        <label>Idade:</label>
        <input type="number" name="idade" value="<?php echo $cliente['idade']; ?>" required>
        <br><br>
        <label>Email:</label>
        <input type="email" name="email" value="<?php echo $cliente['email']; ?>" required>
        <br><br>
        <button type="submit">Salvar</button>
    </form>
</body>

</html>  