<?php
    require_once("header.php");
?>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $descricao = $_POST['descricao'];
        $data_inicio = $_POST['data_inicio'];
        $data_fim = $_POST['data_fim'];
        $id_membro = $_POST['id_membro'];
        $id_tarefa = $_POST['id_tarefa'];

        $sql = "INSERT INTO atividades (descricao, data_inicio, data_fim, id_membro, id_tarefa) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$descricao, $data_inicio, $data_fim, $id_membro, $id_tarefa]);

        echo "Atividade registrada com sucesso!";
    }
    ?>

<head>
    <title>Registro de Atividades</title>
</head>

    <h1>Registro de Atividades</h1>
    <form action="atividades.php" method="POST">
        <label for="descricao">Descrição da Atividade:</label>
        <textarea id="descricao" name="descricao" required></textarea>

        <label for="data_inicio">Data de Início:</label>
        <input type="date" id="data_inicio" name="data_inicio" required>

        <label for="data_fim">Data de Término:</label>
        <input type="date" id="data_fim" name="data_fim">

        <label for="id_membro">Selecione o Membro:</label>
        <select id="id_membro" name="id_membro" required>
            <?php
            require 'conexao.php';
            $stmt = $conn->query("SELECT id, nome FROM membros");
            while ($membro = $stmt->fetch()) {
                echo "<option value='{$membro['id']}'>{$membro['nome']}</option>";
            }
            ?>
        </select>

        <label for="id_tarefa">Selecione a Tarefa:</label>
        <select id="id_tarefa" name="id_tarefa" required>
            <?php
            $stmt = $conn->query("SELECT id, titulo FROM tarefas");
            while ($tarefa = $stmt->fetch()) {
                echo "<option value='{$tarefa['id']}'>{$tarefa['titulo']}</option>";
            }
            ?>
        </select>

        <button type="submit">Registrar Atividade</button>
    </form>

<?php
    require_once("footer.php");
?>