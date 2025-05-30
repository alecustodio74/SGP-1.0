<?php
require_once("header.php");
//os membros são os usuários com os dados atualizados

function retornaMembros(){
    require("conexao.php");
    try {
        $sql = "SELECT usuarios.*, cargo.nome AS nome_cargo 
                FROM usuarios 
                LEFT JOIN cargo ON usuarios.cargo_id = cargo.id";
        $stmt = $pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e){
        die("Erro ao consultar os membros: " . $e->getMessage());
    }
}

$membros = retornaMembros();
?>

<h4>Membros</h4>
<a href="novo_membro.php" class="btn btn-success mb-3">Novo Registro</a>

<?php
if (isset($_GET['cadastro'])) {
    echo $_GET['cadastro'] == "true"
        ? '<p class="text-success">Registro salvo com sucesso!</p>'
        : '<p class="text-danger">Erro ao inserir o registro!</p>';
}

if (isset($_GET['alterado'])) {
    echo $_GET['alterado'] == "true"
        ? '<p class="text-success">Registro alterado com sucesso!</p>'
        : '<p class="text-danger">Erro ao alterar o registro!</p>';
}

if (isset($_GET['excluido'])) {
    echo $_GET['excluido'] == "true"
        ? '<p class="text-success">Registro excluído com sucesso!</p>'
        : '<p class="text-danger">Erro ao excluir o registro!</p>';
}
?>

<table class="table table-hover table-striped" id="tabela">
    <thead>
        <tr>
            <th>ID</th>
            <th>NOME</th>
            <th>EMAIL</th>
            <th>CARGO</th>
            <th>SALÁRIO</th>
            <th style="text-align: center;">AÇÕES</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($membros as $m): ?>
            <tr>
                <td><?= $m['id'] ?></td>
                <td><?= $m['nome'] ?></td>
                <td><?= $m['email'] ?></td>
                <td><?= $m['nome_cargo'] ?? 'Não informado' ?></td>
                <td><?= number_format($m['salario'], 2, ',', '.') ?></td>
                <td style="text-align: center;">
                    <a href="editar_membros.php?id=<?= $m['id'] ?>" class="btn btn-warning">Editar</a>
                    <a href="consultar_membros.php?id=<?= $m['id'] ?>" class="btn btn-info">Consultar</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<script>
    setTimeout(() => {
        const alert = document.querySelector('.alert-success');
        if (alert) alert.remove();
    }, 5000); // desaparece a mensagem de confirmação do php  após 5 segundos
</script>

<?php require_once("footer.php"); ?>
