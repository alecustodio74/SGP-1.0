<?php
    require_once("header.php");

    function consultaCargos($id){
        require("conexao.php");
        try{
            $sql = "SELECT * FROM cargo WHERE id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$id]);
            $cargo = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!$cargo){
                die("Erro ao consultar o registro!");
            } else{
                return $cargo;
            }
        } catch(Exception $e){
            die("Erro ao consultar cargo: " . $e->getMessage());
        }
    }

    function excluirCargos($id){
        require("conexao.php");
        try{
            $sql = "DELETE FROM cargo WHERE id = ?";
            $stmt = $pdo->prepare($sql);
            if ($stmt->execute([$id])){
                header('location: cargos.php?excluido=true');
            } else{
                header('location: cargos.php?excluido=false');
            }
        } catch (Exception $e){
            die("Erro ao excluir o cargo: " . $e->getMessage());
        }
    }
      

    if ($_SERVER['REQUEST_METHOD'] == "POST"){
        $id = $_POST['id'];
        excluirCargos($id);
    } else{
        $cargo = consultaCargos($_GET['id']);
    }

?>

<h2>Consultar Cargos</h2>

<form method="post"> 
    <input type="hidden" name="id" value="<?= $cargo['id'] ?>">

    <div class="mb-3">
        <p>Nome do cargo: <b><?= $cargo['nome'] ?></b></p>
    </div>

    <div class="mb-3">
        <p>Descrição do cargo: <b><?= $cargo['descricao'] ?></b></p>
    </div>

    <div class="mb-3">
        <p class="text-danger">Deseja excluir este registro?</p>
        <button type="submit" class="btn btn-danger" id="btnEexcluirCat">Excluir</button>
        <!-- Sugestão: colocar um Sweet Alert para confirmar a exclusão -->
        <a href="cargos.php" class="btn btn-secondary" onclick="history.back()">Voltar</a>
    </div>

</form>
            
<?php
    require_once("footer.php");
?>