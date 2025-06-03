<?php
    require_once("header.php");

    function consultaProjeto($id){
        require("conexao.php");
        try {
            $sql = "SELECT * FROM projetos WHERE id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$id]);
            $projeto = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!$projeto){
                die("Erro ao consultar o registro!");
            } else {
                return $projeto;
            }
        } catch(Exception $e){
            die("Erro ao consultar projeto: " . $e->getMessage());
        }
    }

    function excluirProjeto($id){
        require("conexao.php");
        try {
            $sql = "DELETE FROM projetos WHERE id = ?";
            $stmt = $pdo->prepare($sql);
            if ($stmt->execute([$id])){
                header('location: projetos.php?excluido=true');
            } else {
                header('location: projetos.php?excluido=false');
            }
        } catch (Exception $e){
            die("Erro ao excluir o projeto: " . $e->getMessage());
        }
    }

    if ($_SERVER['REQUEST_METHOD'] == "POST"){
        $id = $_POST['id'];
        excluirProjeto($id);
    } else {
        $projeto = consultaProjeto($_GET['id']);
    }
?>

<h2>Consultar Projeto</h2> <!-- página com SweetAlert criada em 2/6/2025 -->

<form method="post" id="formExcluirProjeto"> 
    <input type="hidden" name="id" value="<?= $projeto['id'] ?>">

    <div class="mb-3">
        <p>ID: <b><?= $projeto['id'] ?></b></p>
    </div>

    <div class="mb-3">
        <p>Nome: <b><?= htmlspecialchars($projeto['nome']) ?></b></p>
    </div>

    <div class="mb-3">
        <p class="text-danger">Deseja excluir este registro?</p>
        <button type="button" class="btn btn-danger" onclick="confirmarExclusao()">Excluir</button>
        <a href="projetos.php" class="btn btn-secondary">Voltar</a>
    </div>
</form>

<!-- Inclui SweetAlert2 via CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function confirmarExclusao() {
    Swal.fire({
        title: 'Tem certeza?',
        text: "Você não poderá reverter isso!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Sim, excluir!',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('formExcluirProjeto').submit();
        }
    });
}
</script>

<?php
    require_once("footer.php");
?>
