<?php
require_once("header.php"); //chama o cabeçalho da página
//require_once é mais seguro que o include pois se der erro com o include_once, 
// ele continua a rodar a página mesmo mostrando os erros
  //session_start(); aqui comentado pq inicializei a sessão lá no topo
  
  function retornaCategorias(){
    require("conexao.php");
    try{
      $sql = "SELECT * FROM categoria"; //comandos para buscar os dados no DB
      $stmt = $pdo->query($sql); //solicita ao DB fazer a consulta
      return $stmt->fetchALL(); //retorna todos os registros do DB no formato de um array
    }catch (Exception $e){
      die("Erro ao consultar as categorias: " . $e->getMessage());
    }
  }

  $categorias = retornaCategorias();
?>

<head>
    <title>Categorias</title>
</head>

    <h4>Categorias</h4>
      <a href="nova_categoria.php" class="btn btn-success mb-3">Novo Registro</a>

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
          echo '<p class="text-success">Registro excluído com sucesso!</p>';
        } else if (isset($_GET['excluido']) && $_GET['excluido'] == false){
          echo '<p class="text-danger">Erro ao excluir o registro!</p>';
        }
      ?>

      <table class="table table-hover table-striped" id="tabela">
          <thead>
              <tr>
                  <th>ID</th>
                  <th>NOME</th><th>DESCRIÇÃO</th><th  style="text-align: center;">AÇÕES</th>
              </tr>
          </thead>
          <tbody>
              <?php
                foreach($categorias as $c):
              ?>
                  <tr>
                      <td><?= $c['id'] ?></td>
                      <td><?= $c['nome'] ?></td>
                      <td><?= $c['descricao'] ?></td>
                      <td  style="text-align: center;">
                          <a href="editar_categoria.php?id=<?= $c['id'] ?>" class="btn btn-warning">Editar</a>
                          <a href="consultar_categoria.php?id=<?= $c['id'] ?>" class="btn btn-info">Consultar</a>
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

