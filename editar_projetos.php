<?php
    require_once("header.php");

$mensagemErro = '';

function consultaProjeto($id) {
    require("conexao.php");
    try {
        $sql = "SELECT * FROM projetos WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
        $projeto = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$projeto) {
            die("Erro ao consultar o registro!");
        } else {
            return $projeto;
        }
    } catch(Exception $e) {
        die("Erro ao consultar projeto: " . $e->getMessage());
    }
}

function alterarProjeto($nome, $id) {
    require("conexao.php");

    // Verifica se já existe outro projeto com o mesmo nome (mas id diferente)
    $verifica = $pdo->prepare("SELECT COUNT(*) FROM projetos WHERE nome = ? AND id != ?");
    $verifica->execute([$nome, $id]);
    $existe = $verifica->fetchColumn();

    if ($existe > 0) {
        return "Já existe outro projeto com esse nome.";
    }

    try {
        $sql = "UPDATE projetos SET nome = ? WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        if ($stmt->execute([$nome, $id])) {
            header('location: projetos.php?alterado=true');
            exit;
        } else {
            return "Erro ao salvar o projeto.";
        }
    } catch (Exception $e) {
        return "Erro ao alterar o projeto: " . $e->getMessage();
    }
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $nome = trim($_POST['nome']);
    $id = $_POST['id'];
    $resultado = alterarProjeto($nome, $id);

    if ($resultado !== null) {
        $mensagemErro = $resultado;
        $projeto = ['id' => $id, 'nome' => $nome]; // mantém os dados no form
    }
} else {
    $projeto = consultaProjeto($_GET['id']);
}
?>

<h2>Alterar Projeto</h2>
<!-- página criada em 2/6/2025 -->

<?php if ($mensagemErro): ?>
    <div class="alert alert-danger"><?= $mensagemErro ?></div>
<?php endif; ?>

<form method="post"> 
    <input type="hidden" name="id" value="<?= $projeto['id'] ?>">

    <div class="mb-3">
        <label for="nome" class="form-label">Informe o Nome do Projeto</label>
        <input value="<?= htmlspecialchars($projeto['nome']) ?>" type="text" id="nome" name="nome" class="form-control" required="">
    </div>

    <button type="submit" class="btn btn-primary">Confirmar</button>
    <button type="button" class="btn btn-secondary" onclick="window.location.href='projetos.php'">Voltar</button>
</form>

<?php
    require_once("footer.php");
?>
