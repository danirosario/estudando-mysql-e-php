<?php
session_start();

require_once("config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $senha = $_POST["senha"];

    // Prepara a consulta para buscar o usuário pelo e-mail
    $stmt = $conn->prepare("SELECT id, nome, email, senha FROM cliente WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();

    $result = $stmt->get_result();

    // Verificar se encontramos um usuário com o e-mail fornecido
    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        $hashed_password_from_db = $row['senha'];

        // Verifica se a senha digitada bate com o HASH do banco
        if (password_verify($senha, $hashed_password_from_db)) {

            // Senha correta, preenche a sessão
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['user_name'] = $row['nome'];

            // Redireciona imediatamente
            header("Location: exibir_dados.php");
            exit();

        } else {
            // Senha incorreta
            $erro = "Email ou senha inválidos.";
        }
    } else {
        // Email não encontrado
        $erro = "Email ou senha inválidos.";
    }

    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>

<body>
    <h1>Login</h1>

    <?php if (isset($erro)): ?>
        <p style="color: red;"><?php echo $erro; ?></p>
    <?php endif; ?>

    <form action="" method="post">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        <br><br>
        <label for="senha">Senha:</label>
        <input type="password" id="senha" name="senha" required>
        <br><br>
        <input type="submit" value="Entrar">
    </form>
</body>

</html>