<?php
require_once("header.php");
//os membros são os usuários do sistema (funcionários)
  
  function retornaMembros(){
    require("conexao.php");
    try{
        $sql = "SELECT * FROM usuarios";
        $stmt = $pdo->query($sql);
        return $stmt->fetchAll();
    }catch (Exception $e){
        die("Erro ao consultar os membros: " . $e->getMessage());
    }
  }

  $membros = retornaMembros();
?>

<head>
    <title>Membros</title>
</head>
 
    <h4>Membros</h4>
    <a href="novo_membro.php" class="btn btn-success mb-3">Novo Registro</a>

    <?php
        if (isset($_GET['usuarios']) && $_GET['usuarios'] == true){
            echo '<p class="text-success">Registro salvo com sucesso!</p>';
        } else if (isset($_GET['usuarios']) && $_GET['usuarios'] == false){
            echo '<p class="text-danger">Erro ao inserir o registro!</p>';
        }
    ?>

    <?php
        if (isset($_GET['alterado']) && $_GET['alterado'] == true){
            echo '<p class="text-success">Registro alterado com sucesso!</p>';
        } else if (isset($_GET['alterado']) && $_GET['alterado'] == false){
            echo '<p class="text-danger">Erro ao alterar o registro!</p>';
        }
    ?>

    <?php
        if (isset($_GET['excluido']) && $_GET['excluido'] == true){
            echo '<p class="text-success">Registro excluido com sucesso!</p>';
        } else if (isset($_GET['excluido']) && $_GET['excluido'] == true){
            echo '<p class="text-danger">Erro ao excluir o registro!</p>';
        }
    ?>

    <table class="table table-hover table-striped" id="tabela">
        <thead>
            <tr>
                <th>ID</th>
                <th>NOME</th><th>EMAIL</th><th>CARGO</th><th>SALÁRIO</th><th style="text-align: center;">AÇÕES</th>
            </tr>
        </thead>
        <tbody>
            <?php
                foreach($membros as $m):
            ?>
                <tr>
                    <td><?= $m['id'] ?></td>
                    <td><?= $m['nome'] ?></td>
                    <td><?= $m['email'] ?></td>
                    <td><?= $m['cargo'] ?></td>
                    <td><?= $m['salario'] ?></td>
                    <td  style="text-align: center;">
                        <a href="editar_membros.php?id=<?= $m['id'] ?>" class="btn btn-warning">Editar</a>
                        <a href="consultar_membros.php?id=<?= $m['id'] ?>" class="btn btn-info">Consultar</a>
                    </td>
                </tr>
            <?php
                endforeach
            ?>  
        </tbody>
    </table>
            
<?php
  require_once("footer.php"); //chama o rodapé da página com o script
?>