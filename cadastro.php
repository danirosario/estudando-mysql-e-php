<?php
session_start();

require_once("config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name     = $_POST["name"];
    $age      = $_POST["age"];
    $email    = $_POST["email"];
    $password = $_POST["password"];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = "Por favor, insira um e-mail válido.";
    } elseif (!filter_var($age, FILTER_VALIDATE_INT) || (int) $age <= 0) {
        $_SESSION['error'] = "Por favor, insira uma idade válida.";
    } else {

        //VERIFICAR SE A SENHA É FORTE O SUFICIENTE (EXEMPLO: MINIMO 8 CARACTERES, UMA LETRA MAIUSCULA, UM NUMERO E UM CARACTERE ESPECIAL)
        // Regex de validação de senha:
        // ^ -> Início | (?=.*[A-Z]) -> Mín. 1 maiúscula | (?=.*\d) -> Mín. 1 número
        // (?=.*[#@$!%*?&]) -> Mín. 1 caractere especial | [A-Za-z\d#@$!%*?&]{8,} -> Permitidos e Mín. 8 caracteres | $ -> Fim
        $passwordPattern = "/^(?=.*[A-Z])(?=.*\d)(?=.*[#@$!%*?&])[A-Za-z\d#@$!%*?&]{8,}$/";

        // preg_match testa a senha contra a Regex.
        if (!preg_match($passwordPattern, $password)) {
            $_SESSION['error'] = "A senha deve conter pelo menos 8 caracteres, uma letra maiúscula, um número e um caractere especial.";
        } else {
            // Aplica o hash logo após passar na validação da Regex
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

            //PREPARAR O COMANDO SQL PARA INSERÇÃO DOS DADOS (Previne ataques de SQL Injection usando Prepared Statements)
            $stmt = $conn->prepare("INSERT INTO cliente (nome, idade, email, senha) VALUES (?,?,?,?)");

            // VINCULANDO OS PARAMETROS: "siss" indica os tipos (s = string, i = inteiro, s = string, s = string)
            $stmt->bind_param("siss", $name, $age, $email, $hashedPassword);

            //EXECUTAR O SQL e verificar se a operação no banco de dados foi bem-sucedida
            if ($stmt->execute()) {
                // Guarda a mensagem na sessão antes de redirecionar
                $_SESSION['success'] = "Cadastro realizado com sucesso!";
            } else {
                $_SESSION['error'] = "Erro ao cadastrar: " . $stmt->error;
            }
            $stmt->close();
        }
    }

    // Redireciona para a mesma página limpa (via GET)
    header("Location: " . $_SERVER['PHP_SELF']);
    exit(); // Interrompe a execução para garantir o redirecionamento
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
</head>

<body>
    <?php
    // Exibe e limpa as mensagens da tela para não repetirem na próxima atualização
    if (isset($_SESSION['success'])) {
        echo "<p style='color: green;'>" . $_SESSION['success'] . "</p>";
        unset($_SESSION['success']);
    }
    if (isset($_SESSION['error'])) {
        echo "<p style='color: red;'>" . $_SESSION['error'] . "</p>";
        unset($_SESSION['error']);
    }
    ?>
    <form action="" method="POST">
        <label>Nome:</label>
        <input type="text" name="name" required>
        <br><br>
        <label>Idade:</label>
        <input type="number" name="age" required>
        <br><br>
        <label>Email:</label>
        <input type="email" name="email" required>
        <br><br>
        <label>Senha:</label>
        <input type="password" name="password" required>
        <br><br>
        <button type="submit">Cadastrar</button>
    </form>
</body>

</html>