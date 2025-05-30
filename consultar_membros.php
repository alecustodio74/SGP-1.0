<?php
require_once("header.php");

function consultaMembro($id){
    require("conexao.php");
    try{
        $sql = "SELECT usuarios.*, cargo.nome AS nome_cargo 
                FROM usuarios 
                LEFT JOIN cargo ON usuarios.cargo_id = cargo.id 
                WHERE usuarios.id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
        $membro = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$membro){
            die("Erro ao consultar o registro");
        } else {
            return $membro;
        }
    } catch(Exception $e){
        die("Erro ao consultar membro: " . $e->getMessage());
    }
}

function excluirMembro($id){
    require("conexao.php");
    try{
        $sql = "DELETE FROM usuarios WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        if ($stmt->execute([$id])){
            header('Location: membros.php?excluido=true');
        } else {
            header('Location: membros.php?excluido=false');
        }
    } catch (Exception $e){
        die("Erro ao excluir o membro: " . $e->getMessage());
    }
}

if ($_SERVER['REQUEST_METHOD'] == "POST"){
    $id = $_POST['id'];
    excluirMembro($id);
} else {
    $membro = consultaMembro($_GET['id']);
}
?>

<h4>Consultar Membro</h4>

<form id="formExcluir" method="post"> 
    <input type="hidden" name="id" value="<?= $membro['id'] ?>">

    <div class="mb-3">
        <p>Nome: <b><?= $membro['nome'] ?></b></p>
    </div>

    <div class="mb-3">
        <p>Email: <b><?= $membro['email'] ?></b></p>
    </div>

    <div class="mb-3">
        <p>Cargo: <b><?= $membro['nome_cargo'] ?? 'Não informado' ?></b></p>
    </div>

    <div class="mb-3">
        <p>Salário: <b>R$ <?= number_format($membro['salario'], 2, ',', '.') ?></b></p>
    </div>

    <div class="mb-3">
        <p class="text-danger">Deseja excluir este registro?</p>
    </div>

    <div class="mb-3">
        <button type="button" id="btnExcluir" class="btn btn-danger">Excluir</button>
        <a href="membros.php" class="btn btn-secondary">Voltar</a>
    </div>
</form>

<!-- Importa SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.getElementById("btnExcluir").addEventListener("click", function(){
    Swal.fire({
        title: 'Tem certeza?',
        text: "Você não poderá reverter isso!",
        icon: 'warning',
        iconColor: "#ffa500",
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sim, excluir!',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById("formExcluir").submit();
        }
    });
});
</script>

<?php require_once("footer.php"); ?>
