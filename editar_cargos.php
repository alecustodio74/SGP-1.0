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

    function alterarCargos($nome, $descricao, $id){
        require("conexao.php");
        try{
            $sql = "UPDATE cargo SET nome = ?, descricao = ? WHERE id = ?";
            $stmt = $pdo->prepare($sql);
            if ($stmt->execute([$nome, $descricao, $id])){
                header('location: cargos.php?modificado=true');
            } else{
                header('location: cargos.php?modificado=false');
            }
        } catch (Exception $e){
            die("Erro ao alterar o cargo: " . $e->getMessage());
        }
    }
    if ($_SERVER['REQUEST_METHOD'] == "POST"){
        $nome = $_POST['nome'];
        $descricao = $_POST['descricao'];
        $id = $_POST['id'];
        alterarCargos($nome, $descricao, $id);
    } else{
        $cargo = consultaCargos($_GET['id']);
    }
?>

<h2>Alterar Categoria</h2>
<!-- página criada em 24/4/2025 -->

<form method="post"> 
    <input type="hidden" name="id" value="<?= $cargo['id'] ?>">

    <div class="mb-3">
        <label for="nome" class="form-label">Informe o Nome</label>
        <input value="<?= $cargo['nome'] ?>" type="text" id="nome" name="nome" class="form-control" required="">
    </div>

    <div class="mb-3">
        <label for="descricao" class="form-label">Informe a Descrição</label>
        <textarea id="descricao" name="descricao" class="form-control" rows="4"><?= $cargo['descricao'] ?></textarea>
    </div>

    <button type="submit" class="btn btn-primary">Confirmar</button>
    <button type="button" class="btn btn-secondary" onclick="history.back()">Voltar</button>
</form>
            
<?php
    require_once("footer.php");
?>