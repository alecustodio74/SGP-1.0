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

    function excluirProduto($id){
        require("conexao.php");
        try{
            $sql = "DELETE FROM produto WHERE id = ?";
            $stmt = $pdo->prepare($sql);
            if ($stmt->execute([$id])){
                header('Location: produtos.php?excluido=true');
            } else{
                header('location: produtos.php?excluido=false');
            }
        } catch (Exception $e){
            die("Erro ao excluir o produto: ". $e->getMessage());
        }
    }

    if ($_SERVER['REQUEST_METHOD'] == "POST"){
        $id = $_POST['id'];
        excluirProduto($id);
    } else{
        $produto = consultaProduto($_GET['id']);
    }
?>

<h4>Consultar Produto</h4>

<form method="post"> 
    <input type="hidden" name="id" value="<?= $produto['id'] ?>">

    <div class="mb-3">
        <p>Nome: <b><?= $produto['nome'] ?></b></p>
    </div>

    <div class="mb-3">
        <p>Descrição: <b><?= $produto['descricao'] ?></b></p>
    </div>

    <div class="mb-3">
        <p>Preço: <b><?= $produto['preco'] ?></b></p>
    </div>

<div class="mb-3">
        <p class="text-danger">Deseja excluir este registro?</p>
        <button type="submit" class="btn btn-danger">Excluir</button>
        <!-- Sugestão: colocar um Sweet Alert para confirmar a exclusão -->
        <a href="produtos.php" class="btn btn-secondary" onclick="history.back()">Voltar</a>
</div>

<?php
    require_once("footer.php");