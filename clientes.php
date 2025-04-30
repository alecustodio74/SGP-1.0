<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Clientes</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Cadastro de Clientes</h1>
    <form action="" method="POST">
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email">

        <label for="cargo">Cargo:</label>
        <input type="text" id="cargo" name="cargo">

        <button type="submit">Cadastrar Cliente</button>
    </form>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        require 'conexao.php';

        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $cargo = $_POST['cargo'];

        $sql = "INSERT INTO cliente (nome, email, cargo) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$nome, $email, $cargo]);

        echo "Cliente cadastrado com sucesso!";
    }
    ?>
</body>
</html>