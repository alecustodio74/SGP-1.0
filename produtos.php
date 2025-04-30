<?php
require_once("header.php"); //chama o cabeçalho da página
//require_once é mais seguro que o include pois se der erro com o include_once, 
// ele continua a rodar a página mesmo mostrando os erros
  //session_start(); aqui comentado pq inicializei a sessão lá no topo
  
  function retornaProdutos(){
    require("conexao.php");
    try{
        $sql = "SELECT * FROM produto";
        $stmt = $pdo->query($sql);
        return $stmt->fetchAll();
    }catch (Exception $e){
        die("Erro ao consultar os produtos: " . $e->getMessage());
    }
  }

  $produtos = retornaProdutos();
?>

<head>
    <title>Produtos</title>
</head>
 
    <h4>Produtos</h4>
    <a href="novo_produto.php" class="btn btn-success mb-3">Novo Registro</a>

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
            echo '<p class="text-success">Registro excluido com sucesso"</p>';
        } else if (isset($_GET['excluido']) && $_GET['excluido'] == true){
            echo '<p class="text-danger">Erro ao excluir o registro!</p>';
        }
    ?>

    <table class="table table-hover table-striped" id="tabela">
        <thead>
            <tr>
                <th>ID</th>
                <th>NOME</th><th>DESCRIÇÃO</th><th>PREÇO</th><th style="text-align: center;">CATEGORIA</th><th style="text-align: center;">AÇÕES</th>
            </tr>
        </thead>
        <tbody>
            <?php
                foreach($produtos as $p):
            ?>
                <tr>
                    <td><?= $p['id'] ?></td>
                    <td><?= $p['nome'] ?></td>
                    <td><?= $p['descricao'] ?></td>
                    <td><?= $p['preco'] ?></td>
                    <td style="text-align: center;"><?= $p['categoria_id'] ?></td>
                    <td  style="text-align: center;">
                        <a href="editar_produto.php?id=<?= $p['id'] ?>" class="btn btn-warning">Editar</a>
                        <a href="consultar_produto.php?id=<?= $p['id'] ?>" class="btn btn-info">Consultar</a>
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