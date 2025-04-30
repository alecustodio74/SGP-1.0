<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Projetos</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Cadastro de Projetos</h1>
    <form action="projetos.php" method="POST">
        <label for="nome">Nome do Projeto:</label>
        <input type="text" id="nome" name="nome" required>

        <label for="descricao">Descrição:</label>
        <textarea id="descricao" name="descricao"></textarea>

        <label for="data_inicio">Data de Início:</label>
        <input type="date" id="data_inicio" name="data_inicio" required>

        <label for="data_fim">Data de Término:</label>
        <input type="date" id="data_fim" name="data_fim">

        <button type="submit">Cadastrar Projeto</button>
    </form>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        require 'conexao.php';

        $nome = $_POST['nome'];
        $descricao = $_POST['descricao'];
        $data_inicio = $_POST['data_inicio'];
        $data_fim = $_POST['data_fim'];

        $sql = "INSERT INTO projetos (nome, descricao, data_inicio, data_fim) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$nome, $descricao, $data_inicio, $data_fim]);

        echo "Projeto cadastrado com sucesso!";
    }
    ?>
</body>
</html>