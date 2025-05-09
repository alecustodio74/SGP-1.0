<?php
    require_once("header.php");

    function consultaCliente($id){
        require("conexao.php");
        try{
            $sql = "SELECT * FROM clientes WHERE id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$id]);
            $cliente = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!$cliente){
                die("Erro ao consultar o registro");
            } else{
                return $cliente;
            }
        } catch(Exception $e){
            die("Erro ao consultar cliente: " . $e->getMessage());
        }
    }

    function alterarCliente($id, $nome, $email){
        require("conexao.php");
        try{
            $sql = "UPDATE clientes SET nome = ?, email = ? WHERE id = ?";
            $stmt = $pdo->prepare($sql);
            //neste if o id precisa estar no final pois ele é a chave para a exclusão
            if ($stmt->execute([$nome, $email, $id])){
                header('location: clientes.php?modificado=true');
            } else{
                header('location: clientes.php?modificado=false');
            }
        } catch (Exception $e){
            die("Erro ao alterar o cliente: " . $e->getMessage());
        }
    }
        if ($_SERVER['REQUEST_METHOD'] == "POST"){
            $nome = $_POST['nome'];
            $email = $_POST['email'];
            $id = $_POST['id'];
            alterarCliente($id, $nome, $email);
        } else{
            $cliente = consultaCliente($_GET['id']);
        }
?>
<h4>Editar Cliente</h4>

<form method="post">
    <input type="hidden" name="id" value="<?= $cliente['id'] ?>">        
    
    <div class="mb-3">
        <label for="nome" class="form-label">Informe o Nome</label>
        <input value="<?= $cliente['nome'] ?>" type="text" id="nome" name="nome" class="form-control" required="">
    </div>

    <div class="mb-3">
        <label for="email" class="form-label">Informe o Email</label>
        <input value="<?= $cliente['email'] ?>" type="email" id="email" name="email" class="form-control" required="">
    </div>
   
    <button type="submit" class="btn btn-primary">Confirmar</button>
    <button type="button" class="btn btn-secondary" onclick="history.back();">Voltar</button>
</form>

<?php
    require_once("footer.php");
?>