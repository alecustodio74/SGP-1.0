<?php
require_once("header.php");
  
  function retornaClientes(){
    require("conexao.php");
    try{
        $sql = "SELECT * FROM clientes";
        $stmt = $pdo->query($sql);
        return $stmt->fetchAll();
    }catch (Exception $e){
        die("Erro ao consultar os clientes: " . $e->getMessage());
    }
  }

  $clientes = retornaClientes();
?>

<head>
    <title>Clientes</title>
</head>
 
    <h4>Clientes</h4>
    <a href="novo_cliente.php" class="btn btn-success mb-3">Novo Registro</a>

    <?php
        if (isset($_GET['cadastro']) && $_GET['cadastro'] == true){
            echo '<p class="text-success">Registro salvo com sucesso!</p>';
        } else if (isset($_GET['cadastro']) && $_GET['cadastro'] == false){
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
                <th>NOME</th><th>EMAIL</th><th style="text-align: center;">AÇÕES</th>
            </tr>
        </thead>
        <tbody>
            <?php
                foreach($clientes as $c):
            ?>
                <tr>
                    <td><?= $c['id'] ?></td>
                    <td><?= $c['nome'] ?></td>
                    <td><?= $c['email'] ?></td>
                    <td  style="text-align: center;">
                        <a href="editar_cliente.php?id=<?= $c['id'] ?>" class="btn btn-warning">Editar</a>
                        <a href="consultar_cliente.php?id=<?= $c['id'] ?>" class="btn btn-info">Consultar</a>
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