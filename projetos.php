<?php
require_once("header.php");

function retornaProjetos(){
  require("conexao.php");
  try{
    $sql = "SELECT * FROM projetos"; // Consulta todos os projetos
    $stmt = $pdo->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  } catch (Exception $e){
    die("Erro ao consultar os projetos: " . $e->getMessage());
  }
}

$projetos = retornaProjetos();
?>

<title>Projetos</title>

<h4>Projetos</h4>
<a href="novo_projeto.php" class="btn btn-success mb-3">Novo Projeto</a>

<?php
if (isset($_GET['cadastro']) && $_GET['cadastro'] == true){
  echo '<p class="text-success">Projeto cadastrado com sucesso!</p>';
} else if (isset($_GET['cadastro']) && $_GET['cadastro'] == false){
  echo '<p class="text-danger">Erro ao cadastrar o projeto!</p>';
}

if (isset($_GET['alterado']) && $_GET['alterado'] == true){
  echo '<p class="text-success">Projeto alterado com sucesso!</p>';
} else if (isset($_GET['alterado']) && $_GET['alterado'] == false){
  echo '<p class="text-danger">Erro ao alterar o projeto!</p>';
}

if (isset($_GET['excluido']) && $_GET['excluido'] == true){
  echo '<p class="text-success">Projeto excluído com sucesso!</p>';
} else if (isset($_GET['excluido']) && $_GET['excluido'] == false){
  echo '<p class="text-danger">Erro ao excluir o projeto!</p>';
}
?>

<table class="table table-hover table-striped" id="tabela">
    <thead>
        <tr>
            <th>ID</th>
            <th>NOME DO PROJETO</th>
            <th style="text-align: center;">AÇÕES</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($projetos as $p): ?>
            <tr>
                <td><?= $p['id'] ?></td>
                <td><?= $p['nome'] ?></td>
                <td style="text-align: center;">
                    <a href="editar_projetos.php?id=<?= $p['id'] ?>" class="btn btn-warning">Editar</a>
                    <a href="consultar_projetos.php?id=<?= $p['id'] ?>" class="btn btn-info">Consultar</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php
    require_once("footer.php");
?>