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

function excluirTarefa($id) {
    require("conexao.php");
    try {
        $sql = "DELETE FROM tarefas WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        if ($stmt->execute([$id])) {
            header('location: tarefas.php?excluido=true');
        } else {
            header('location: tarefas.php?excluido=false');
        }
    } catch (Exception $e) {
        die("Erro ao excluir a tarefa: " . $e->getMessage());
    }
}

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['confirmar']) && $_POST['confirmar'] == 'sim') {
    excluirTarefa($_POST['id']);
} else {
    $tarefa = consultaTarefa($_GET['id']);
}
?>

<h2>Consultar Tarefa</h2>

<form method="post" id="formExclusao">
    <input type="hidden" name="id" value="<?= $tarefa['id'] ?>">
    <input type="hidden" name="confirmar" value="sim">

    <div class="mb-3">
        <p><strong>Nome:</strong> <?= $tarefa['nome'] ?></p>
    </div>

    <div class="mb-3">
        <p><strong>Descrição:</strong> <?= $tarefa['descricao'] ?></p>
    </div>

    <div class="mb-3">
        <button type="button" class="btn btn-danger" id="btnExcluir">Excluir</button>
        <a href="tarefas.php" class="btn btn-secondary">Voltar</a>
    </div>
</form>

<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.getElementById('btnExcluir').addEventListener('click', function(e) {
    e.preventDefault();
    Swal.fire({
        title: 'Tem certeza?',
        text: "Você não poderá reverter isso!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sim, excluir!',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('formExclusao').submit();
        }
    });
});
</script>

<?php
    require_once("footer.php");
?>
