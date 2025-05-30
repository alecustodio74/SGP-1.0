<?php
    require_once("header.php");

    function inserirCargo($nome, $descricao){
        require("conexao.php");
        try{
            $sql = "INSERT INTO cargo (nome, descricao) VALUES (?,?)";
            $stmt = $pdo->prepare($sql);
            if ($stmt->execute([$nome, $descricao])){
                header('location: cargos.php?cadastro=true');
            } else{
                header('location: cargos.php?cadastro=false');
            }
        } catch (Exception $e){
            die("Erro ao inserir o cargo: " . $e->getMessage());
        }
    }
    if ($_SERVER['REQUEST_METHOD'] == "POST"){
        $nome = $_POST['nome'];
        $descricao = $_POST['descricao'];
        inserirCargo($nome, $descricao);
    }
?>

<h2>Criar Novo Cargo</h2>

<form method="post"> 
    <div class="mb-3">
        <label for="nome" class="form-label">Informe o Nome do Cargo</label>
        <input type="text" id="nome" name="nome" class="form-control" required="">
    </div>

    <div class="mb-3">
        <label for="descricao" class="form-label">Informe a Descrição</label>
        <textarea id="descricao" name="descricao" class="form-control" rows="4"></textarea>
    </div>

<button type="submit" class="btn btn-primary">Cadastrar</button>
<button type="button" class="btn btn-secondary" onclick="history.back()">Voltar</button>

</form>
            
<?php
    require_once("footer.php");
?>