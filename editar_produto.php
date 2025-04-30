<?php
    require_once("header.php");

    function consultaProduto($id){
        require("conexao.php");
        try{
            $sql = "SELECT * FROM produto WHERE id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$id]);
            $produto = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!$produto){
                die("Erro ao consultar o registro");
            } else{
                return $produto;
            }
        } catch(Exception $e){
            die("Erro ao consultar produto: " . $e->getMessage());
        }
    }

    function alterarProduto($id, $nome, $descricao, $preco, $categoria_id){
        require("conexao.php");
        try{
            $sql = "UPDATE produto SET nome = ?, descricao = ?, preco = ?, categoria_id = ? WHERE id = ?";
            $stmt = $pdo->prepare($sql);
            //neste if o id precisa estar no final pois ele é a chave para a exclusão
            if ($stmt->execute([$nome, $descricao, $preco, $categoria_id, $id])){
                header('location: produtos.php?modificado=true');
            } else{
                header('location: produtos.php?modificado=false');
            }
        } catch (Exception $e){
            die("Erro ao alterar o produto: " . $e->getMessage());
        }
    }
        if ($_SERVER['REQUEST_METHOD'] == "POST"){
            $nome = $_POST['nome'];
            $descricao = $_POST['descricao'];
            $preco = $_POST['preco'];
            $categoria_id = $_POST['categoria_id'];
            $id = $_POST['id'];
            alterarProduto($id, $nome, $descricao, $preco, $categoria_id);
        } else{
            $produto = consultaProduto($_GET['id']);
        }
?>
<h4>Editar Produto</h4>

<form method="post">
    <input type="hidden" name="id" value="<?= $produto['id'] ?>">        
    
    <div class="mb-3">
        <label for="nome" class="form-label">Informe o Nome</label>
        <input value="<?= $produto['nome'] ?>" type="text" id="nome" name="nome" class="form-control" required="">
    </div>

    <div class="mb-3">
        <label for="descricao" class="form-label">Informe a Descrição</label>
        <textarea id="descricao" name="descricao" class="form-control" rows="4" required=""><?= $produto['descricao'] ?></textarea>
    </div>
    
    <div class="mb-3">
        <label for="preco" class="form-label">Preço</label>
        <input value="<?= $produto['preco'] ?>" type="number" id="preco" name="preco" class="form-control" required=""<?= $produto['preco'] ?>>
    </div>
    
    <div class="mb-3">
        <label for="categoria_id" class="form-label">Categoria</label>
        <input value="<?= $produto['categoria_id'] ?>" type="number" id="categoria_id" name="categoria_id" class="form-control" required=""<?= $produto['categoria_id'] ?>>
    </div>

    <button type="submit" class="btn btn-primary">Confirmar</button>
    <button type="button" class="btn btn-secondary" onclick="history.back();">Voltar</button>
</form>

<?php
    require_once("footer.php");
?>