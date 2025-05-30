<?php
require_once("header.php");
//novo_membro.php

function retornaCargos(){
    require("conexao.php");
    try{
        $sql = "SELECT * FROM cargo";
        $stmt = $pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch(Exception $e){
        die("Erro ao consultar cargos: " . $e->getMessage());
    }
}

function inserirMembros($nome, $email, $salario, $cargo_id){
    require("conexao.php");
    try{
        $sql = "INSERT INTO usuarios (nome, email, cargo_id, salario) VALUES (?,?,?,?)";
        $stmt = $pdo->prepare($sql);
        if ($stmt->execute([$nome, $email, $cargo_id, $salario]))
            header('location: membros.php?cadastro=true');
        else
            header('location: membros.php?cadastro=false');
    } catch (Exception $e) {
        die("Erro ao inserir um membro: " . $e->getMessage());
    }
}

$cargos = retornaCargos();

if ($_SERVER['REQUEST_METHOD'] == "POST"){
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $cargo_id = $_POST['cargo_id'];
    $salario = $_POST['salario'];
    inserirMembros($nome, $email, $salario, $cargo_id);
}
?>

<h4>Cadastrar Novo Membro</h4>

<form method="post">
    <div class="mb-3">
        <label for="nome" class="form-label">Nome</label>
        <input type="text" id="nome" name="nome" class="form-control" required>
    </div>

    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" id="email" name="email" class="form-control" required>
    </div>

    <div class="mb-3">
        <label for="cargo" class="form-label">Cargo</label>
        <select id="cargo" name="cargo_id" class="form-select" required>
            <option value="">Selecione um cargo</option>
            <?php foreach($cargos as $c): ?>
                <option value="<?= $c['id'] ?>"><?= $c['id'] . ' - ' . $c['nome'] ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="mb-3">
        <label for="salario" class="form-label">Salário</label>
        <input type="number" id="salario" name="salario" class="form-control" required>
    </div>

    <button type="submit" class="btn btn-primary">Enviar</button>
    <button type="button" class="btn btn-secondary" onclick="history.back();">Voltar</button>
</form>

<?php
    require_once("footer.php");
?>
