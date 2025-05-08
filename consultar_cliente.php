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

    function excluirCliente($id){
        require("conexao.php");
        try{
            $sql = "DELETE FROM clientes WHERE id = ?";
            $stmt = $pdo->prepare($sql);
            if ($stmt->execute([$id])){
                header('Location: clientes.php?excluido=true');
            } else{
                header('location: clientes.php?excluido=false');
            }
        } catch (Exception $e){
            die("Erro ao excluir o cliente: ". $e->getMessage());
        }
    }

    if ($_SERVER['REQUEST_METHOD'] == "POST"){
        $id = $_POST['id'];
        excluirCliente($id);
    } else{
        $cliente = consultaCliente($_GET['id']);
    }
?>

<h4>Consultar Cliente</h4>

<form method="post"> 
    <input type="hidden" name="id" value="<?= $cliente['id'] ?>">

    <div class="mb-3">
        <p>Nome: <b><?= $cliente['nome'] ?></b></p>
    </div>

    <div class="mb-3">
        <p>Email: <b><?= $cliente['email'] ?></b></p>
    </div>

<div class="mb-3">
        <p class="text-danger">Deseja excluir este registro?</p>
        <button type="submit" class="btn btn-danger">Excluir</button>
        <!-- Sugestão: colocar um Sweet Alert para confirmar a exclusão -->
        <a href="clientes.php" class="btn btn-secondary" onclick="history.back()">Voltar</a>
</div>

<?php
    require_once("footer.php");