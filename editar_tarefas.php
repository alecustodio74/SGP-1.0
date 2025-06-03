<?php
require_once("header.php");

function consultaTarefa($id) {
    require("conexao.php");
    try {
        $sql = "SELECT * FROM tarefas WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
        $tarefa = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$tarefa) {
            die("Tarefa não encontrada!");
        }
        return $tarefa;
    } catch (Exception $e) {
        die("Erro ao consultar tarefa: " . $e->getMessage());
    }
}

function alterarTarefa($nome, $descricao, $id) {
    require("conexao.php");
    try {
        $sql = "UPDATE tarefas SET nome = ?, descricao = ? WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        if ($stmt->execute([$nome, $descricao, $id])) {
            header('location: tarefas.php?alterado=true');
        } else {
            header('location: tarefas.php?alterado=false');
        }
    } catch (Exception $e) {
        die("Erro ao alterar a tarefa: " . $e->getMessage());
    }
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $id = $_POST['id'];
    alterarTarefa($nome, $descricao, $id);
} else {
    $tarefa = consultaTarefa($_GET['id']);
}
?>

<h2>Editar Tarefa</h2>

<form method="post">
    <input type="hidden" name="id" value="<?= $tarefa['id'] ?>">

    <div class="mb-3">
        <label for="nome" class="form-label">Nome da Tarefa</label>
        <input value="<?= $tarefa['nome'] ?>" type="text" id="nome" name="nome" class="form-control" required>
    </div>

    <div class="mb-3">
        <label for="descricao" class="form-label">Descrição</label>
        <textarea id="descricao" name="descricao" class="form-control" rows="4" required><?= $tarefa['descricao'] ?></textarea>
    </div>

    <button type="submit" class="btn btn-primary">Confirmar</button>
    <a href="tarefas.php" class="btn btn-secondary">Voltar</a>
</form>

<?php require_once("footer.php"); ?>
