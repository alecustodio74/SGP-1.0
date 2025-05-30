
<?php
    require_once("header.php");
?>


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Tarefas</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Cadastro de Tarefas</h1>
    <form action="tarefas.php" method="POST">
        <label for="titulo">Título da Tarefa:</label>
        <input type="text" id="titulo" name="titulo" required>

        <label for="descricao">Descrição:</label>
        <textarea id="descricao" name="descricao"></textarea>

        <label for="status">Status:</label>
        <select id="status" name="status">
            <option value="Pendente">Pendente</option>
            <option value="Em andamento">Em andamento</option>
            <option value="Concluído">Concluído</option>
        </select>

        <label for="data_inicio">Data de Início:</label>
        <input type="date" id="data_inicio" name="data_inicio" required>

        <label for="data_fim">Data de Término:</label>
        <input type="date" id="data_fim" name="data_fim">

        <button type="submit">Cadastrar Tarefa</button>
    </form>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        require 'conexao.php';

        $titulo = $_POST['titulo'];
        $descricao = $_POST['descricao'];
        $status = $_POST['status'];
        $data_inicio = $_POST['data_inicio'];
        $data_fim = $_POST['data_fim'];

        $sql = "INSERT INTO tarefas (titulo, descricao, status, data_inicio, data_fim) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$titulo, $descricao, $status, $data_inicio, $data_fim]);

        echo "Tarefa cadastrada com sucesso!";
    }
    ?>

<?php
    require_once("footer.php");
?>
