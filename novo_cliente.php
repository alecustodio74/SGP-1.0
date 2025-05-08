<?php
    require_once("header.php");

    function inserirClientes($nome, $email){
        require("conexao.php");
        try{
            $sql = "INSERT INTO clientes (nome, email) VALUES (?,?)";
            $stmt = $pdo->prepare($sql);
            if ($stmt->execute([$nome, $email])){
                header('location: clientes.php?cadastro=true');
            } else{
                header('location: clientes.php?cadastro=false');
            }
        } catch (Exception $e){
            die("Erro ao inserir o cliente: " . $e->getMessage());
        }
   }
   if ($_SERVER['REQUEST_METHOD'] == "POST"){
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    inserirClientes($nome, $email);
   }
?>
<h4>Cadastrar Novo Cliente</h4>

<form method="post">           
    <div class="mb-3">
        <label for="nome" class="form-label">Nome</label>
        <input type="text" id="nome" name="nome" class="form-control" required="">
    </div>

    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" id="email" name="email" class="form-control" required="">
    </div>

    <button type="submit" class="btn btn-primary">Cadastrar</button>
    <button type="button" class="btn btn-secondary" onclick="history.back();">Voltar</button>
</form>
       
<?php
    require_once("footer.php");
