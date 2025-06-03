<?php
    require_once("header.php");

function retornaTarefas(){
    require("conexao.php");
    try {
        $sql = "SELECT * FROM tarefas ORDER BY id DESC";
        $stmt = $pdo->query($sql);
        return $stmt->fetchAll();
    } catch (Exception $e) {
        die("Erro ao consultar as tarefas: " . $e->getMessage());
    }
}

$tarefas = retornaTarefas();
?>

<head>
    <title>Tarefas</title>
</head>

<h4>Tarefas</h4>
<a href="nova_tarefa.php" class="btn btn-success mb-3">Nova Tarefa</a>

<?php
    if (isset($_GET['cadastro']) && $_GET['cadastro'] == "true") {
        echo '<p class="text-success">Tarefa cadastrada com sucesso!</p>';
    } else if (isset($_GET['cadastro']) && $_GET['cadastro'] == "false") {
        echo '<p class="text-danger">Erro ao cadastrar a tarefa!</p>';
    }

    if (isset($_GET['alterado']) && $_GET['alterado'] == "true") {
        echo '<p class="text-success">Tarefa alterada com sucesso!</p>';
    } else if (isset($_GET['alterado']) && $_GET['alterado'] == "false") {
        echo '<p class="text-danger">Erro ao alterar a tarefa!</p>';
    }

    if (isset($_GET['excluido']) && $_GET['excluido'] == "true") {
        echo '<p class="text-success">Tarefa excluída com sucesso!</p>';
    } else if (isset($_GET['excluido']) && $_GET['excluido'] == "false") {
        echo '<p class="text-danger">Erro ao excluir a tarefa!</p>';
    }
?>

<table class="table table-hover table-striped" id="tabela">
    <thead>
        <tr>
            <th>ID</th>
            <th>NOME DA TAREFA</th>
            <th>DESCRIÇÃO</th>
            <th style="text-align: center;">AÇÕES</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($tarefas as $t): ?>
            <tr>
                <td><?= $t['id'] ?></td>
                <td><?= htmlspecialchars($t['nome']) ?></td>
                <td><?= htmlspecialchars($t['descricao']) ?></td>
                <td style="text-align: center;">
                    <a href="editar_tarefas.php?id=<?= $t['id'] ?>" class="btn btn-warning">Editar</a>
                    <a href="consultar_tarefas.php?id=<?= $t['id'] ?>" class="btn btn-info">Consultar</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php
    require_once("footer.php");
?>
