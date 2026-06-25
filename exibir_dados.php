<?php
require_once('config.php');

// CONSULTA COM SQL 
$sql = "SELECT * FROM cliente";
$result = $conn->query($sql);

// VERIFICAR SE HÁ RESULTADOS 
if ($result === false) {
    echo "Error: " . $conn->error;
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exibir dados</title>
    <style>
        table {
            width: 50%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    <h2>Lista</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Idade</th>
            <th>Email</th>
            <th>Ações</th>
        </tr>
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['nome']; ?></td>
                    <td><?php echo $row['idade']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td><a href="editar.php?id=<?php echo $row['id']; ?>">Editar</a></td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td style="text-align:center" colspan="3">No records found.</td>
            </tr>
        <?php endif; ?>
    </table>
</body>

</html>

<!-- fetch_assoc() transforma cada registro em um array associativo. -->