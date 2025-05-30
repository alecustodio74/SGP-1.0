<?php
    require_once("header.php");

    function retornaCategorias(){
        require("conexao.php");
        try{
            $sql = "SELECT * FROM categoria";
            $stmt = $pdo->query($sql);
            return $stmt->fetchALL();
        } catch(Exception $e){
            die("Erro ao consultar categorias: " . $e->getMessage());
        }
    }

    function inserirProduto($nome, $descricao, $preco, $categoria_id){
        require("conexao.php");
        try{
            $sql = "INSERT INTO produto (nome, descricao, preco, categoria_id) VALUES (?,?,?,?)";
            $stmt = $pdo->prepare($sql);
            if ($stmt->execute([$nome, $descricao, $preco, $categoria_id]))
                header('location: produtos.php?cadastro=true');
            else
                header('location: produtos.php?cadastro=false');
        } catch (Exception $e) {
            die("Erro ao inserir: " . $e->getMessage());
        }
    }
    
    $categorias = retornaCategorias();

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
                <label for="preco" class="form-label">Preço</label>
                <input type="number" id="preco" name="preco" class="form-control" required="">
            </div>
        
            <div class="mb-3">
                <label for="categoria" class="form-label">Categoria</label>
                 <select id="categoria" name="categoria_id" class="form-select" required="">
        <?php
                foreach($categorias as $c): //colocamos o número e o nome da categoria dentro do select
                    ?>
                <option value="<?= $c['id'] ?>"  <?php if ($c['id'] == $c['id']) echo "selected" ?> ><?= $c['id'] . ' - ' . $c['nome'] ?> </option>
            <?php
                endforeach;
            ?>
        </select>
            </div>
        
        <button type="submit" class="btn btn-primary">Enviar</button>
        <button type="button" class="btn btn-secondary" onclick="history.back();">Voltar</button>
    </form>
                
       
<?php
    require_once("footer.php");
?>
