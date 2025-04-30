<?php
    require_once("header.php");

    function consultaCategoria($id){
        require("conexao.php");
        try{
            $sql = "SELECT * FROM categoria WHERE id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$id]);
            $categoria = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!$categoria){
                die("Erro ao consultar o registro!");
            } else{
                return $categoria;
            }
        } catch(Exception $e){
            die("Erro ao consultar categoria: " . $e->getMessage());
        }
    }

    function excluirCategoria($id){
        require("conexao.php");
        try{
            $sql = "DELETE FROM categoria WHERE id = ?";
            $stmt = $pdo->prepare($sql);
            if ($stmt->execute([$id])){
                header('location: categorias.php?excluido=true');
            } else{
                header('location: categorias.php?excluido=false');
            }
        } catch (Exception $e){
            die("Erro ao excluir a categoria: " . $e->getMessage());
        }
    }
      

    if ($_SERVER['REQUEST_METHOD'] == "POST"){
        $id = $_POST['id'];
        excluirCategoria($id);
    } else{
        $categoria = consultaCategoria($_GET['id']);
    }

?>

<h2>Consultar Categoria</h2><!-- página criada em 24/4/2025 -->

<form method="post"> 
    <input type="hidden" name="id" value="<?= $categoria['id'] ?>">

    <div class="mb-3">
        <p>Nome: <b><?= $categoria['nome'] ?></b></p>
    </div>

    <div class="mb-3">
        <p>Descrição: <b><?= $categoria['descricao'] ?></b></p>
    </div>

    <div class="mb-3">
        <p class="text-danger">Deseja excluir este registro?</p>
        <button type="submit" class="btn btn-danger" id="btnEexcluirCat">Excluir</button>
        <!-- Sugestão: colocar um Sweet Alert para confirmar a exclusão -->
        <a href="categorias.php" class="btn btn-secondary" onclick="history.back()">Voltar</a>
    </div>

</form>
            
<?php
    require_once("footer.php");
?>