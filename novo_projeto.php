<?php
    require_once("header.php");

function listarProjetos() {
    require("conexao.php");
    try {
        $sql = "SELECT id, nome FROM projetos ORDER BY id DESC";
        $stmt = $pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        die("Erro ao buscar projetos: " . $e->getMessage());
    }
}

function nomeProjetoExiste($nome) {
    require("conexao.php");
    try {
        $sql = "SELECT COUNT(*) FROM projetos WHERE nome = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$nome]);
        return $stmt->fetchColumn() > 0;
    } catch (Exception $e) {
        die("Erro ao verificar duplicidade: " . $e->getMessage());
    }
}

function inserirProjeto($nome) {
    require("conexao.php");
    try {
        $sql = "INSERT INTO projetos (nome) VALUES (?)";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([$nome]);
    } catch (Exception $e) {
        die("Erro ao inserir projeto: " . $e->getMessage());
    }
}

$erro = "";
if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $nome = trim($_POST['nome']);

    if (nomeProjetoExiste($nome)) {
        $erro = "Já existe um projeto com este nome!";
    } else {
        if (inserirProjeto($nome)) {
            header('location: projetos.php?cadastro=true');
            exit;
        } else {
            $erro = "Erro ao cadastrar projeto.";
        }
    }
}

$projetos = listarProjetos();
?>

<title>Novo Projeto</title>

<h4>Novo Projeto</h4>

<?php if ($erro): ?>
    <div class="alert alert-danger"><?= $erro ?></div>
<?php endif; ?>

<form method="post" class="mb-4">
    <div class="mb-3">
        <label for="nome" class="form-label">Nome do Projeto</label>
        <input type="text" id="nome" name="nome" class="form-control" required>
    </div>
    <div class="mb-3">
        <button type="submit" class="btn btn-primary">Cadastrar</button>
        <a href="projetos.php" class="btn btn-secondary">Voltar</a>
    </div>
</form>

<h5>Projetos já cadastrados</h5>
<table class="table table-hover table-striped" id="tabela">
    <thead>
        <tr>
            <th>ID</th>
            <th>NOME DO PROJETO</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($projetos as $p): ?>
            <tr>
                <td><?= $p['id'] ?></td>
                <td><?= htmlspecialchars($p['nome']) ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php
    require_once("footer.php");
?>
