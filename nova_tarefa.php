<?php
require_once("header.php");

function inserirTarefa($nome, $descricao) {
    require("conexao.php");
    try {
        $sql = "INSERT INTO tarefas (nome, descricao) VALUES (?, ?)";
        $stmt = $pdo->prepare($sql);
        if ($stmt->execute([$nome, $descricao])) {
            header('location: tarefas.php?cadastro=true');
        } else {
            header('location: tarefas.php?cadastro=false');
        }
    } catch (Exception $e) {
        die("Erro ao inserir a tarefa: " . $e->getMessage());
    }
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    inserirTarefa($nome, $descricao);
}
?>

<h2>Nova Tarefa</h2>

<form method="post">
    <div class="mb-3">
        <label for="nome" class="form-label">Nome da Tarefa</label>
        <input type="text" id="nome" name="nome" class="form-control" required>
    </div>

    <div class="mb-3">
        <label for="descricao" class="form-label">Descrição</label>
        <textarea id="descricao" name="descricao" class="form-control" rows="4" required></textarea>
    </div>

    <button type="submit" class="btn btn-primary">Cadastrar</button>
    <a href="tarefas.php" class="btn btn-secondary">Voltar</a>
</form>

<?php require_once("footer.php"); ?>
