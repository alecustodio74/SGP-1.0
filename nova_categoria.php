<?php
    require_once("header.php");

    function inserirCategoria($nome, $descricao){
        require("conexao.php");
        try{
            $sql = "INSERT INTO categoria (nome, descricao) VALUES (?,?)";
            $stmt = $pdo->prepare($sql);
            if ($stmt->execute([$nome, $descricao])){
                header('location: categorias.php?cadastro=true');
            } else{
                header('location: categorias.php?cadastro=false');
            }
        } catch (Exception $e){
            die("Erro ao inserir a categoria: " . $e->getMessage());
        }
    }
    if ($_SERVER['REQUEST_METHOD'] == "POST"){
        $nome = $_POST['nome'];
        $descricao = $_POST['descricao'];
        inserirCategoria($nome, $descricao);
    }
?>

<h2>Criar Nova Categoria</h2>
<!-- página criada em 24/4/2025 -->

<form method="post"> 
    <div class="mb-3">
        <label for="nome" class="form-label">Informe o Nome</label>
        <input type="text" id="nome" name="nome" class="form-control" required="">
    </div>

    <div class="mb-3">
        <label for="descricao" class="form-label">Informe a Descrição</label>
        <textarea id="descricao" name="descricao" class="form-control" rows="4" required=""></textarea>
    </div>

<button type="submit" class="btn btn-primary">Cadastrar</button>
<button type="button" class="btn btn-secondary" onclick="history.back()">Voltar</button>

</form>
            
<?php
    require_once("footer.php");
?>