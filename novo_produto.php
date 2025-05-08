<?php
    require_once("header.php");

    function inserirProduto($nome, $descricao, $preco, $categoria_id){
        require("conexao.php");
        try{
            $sql = "INSERT INTO produto (nome, descricao, preco, categoria_id) VALUES (?,?,?,?)";
            $stmt = $pdo->prepare($sql);
            if ($stmt->execute([$nome, $descricao, $preco, $categoria_id])){
                header('location: produtos.php?cadastro=true');
            } else{
                header('location: produtos.php?cadastro=false');
            }
        } catch (Exception $e){
            die("Erro ao inserir o produto: " . $e->getMessage());
        }
   }
   if ($_SERVER['REQUEST_METHOD'] == "POST"){
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $preco = $_POST['preco'];
    $categoria_id = $_POST['categoria_id'];
    inserirProduto($nome, $descricao, $preco, $categoria_id);
   }
?>
<h4>Cadastrar Novo Produto</h4>

<form method="post">           
    <div class="mb-3">
        <label for="nome" class="form-label">Nome</label>
        <input type="text" id="nome" name="nome" class="form-control" required="">
    </div>

    <div class="mb-3">
        <label for="descricao" class="form-label">Descrição</label>
        <textarea id="descricao" name="descricao" class="form-control" rows="4" required=""></textarea>
    </div>

    <div class="mb-3">
        <label for="valor" class="form-label">Preço</label>
        <input type="number" id="preco" name="preco" class="form-control" required="">
    </div>

    <div class="mb-3">
        <label for="categoria_id" class="form-label">Categoria</label>
        <select id="categoria_id" name="categoria_id" class="form-select" required="">
            <option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option><option value="11">11</option><option value="12">12</option><option value="13">13</option><option value="14">14</option><option value="15">15</option>
        </select>
    </div>
    
    <button type="submit" class="btn btn-primary">Confirmar</button>
    <button type="button" class="btn btn-secondary" onclick="history.back();">Voltar</button>
</form>
       
<?php
    require_once("footer.php");
