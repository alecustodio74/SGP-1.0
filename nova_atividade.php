<?php
require_once("header.php");

function inserirAtividade($projeto_id, $tarefa_id, $usuario_id, $status, $cliente_id){
    require("conexao.php");
    try {
        $sql = "INSERT INTO atividades (projeto_id, tarefa_id, usuario_id, status, cliente_id) VALUES (?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        if ($stmt->execute([$projeto_id, $tarefa_id, $usuario_id, $status, $cliente_id])){
            header('Location: atividades.php?cadastro=true');
            exit;
        } else {
            echo '<p class="text-danger">Erro ao inserir atividade.</p>';
        }
    } catch (Exception $e) {
        die("Erro ao inserir atividade: " . $e->getMessage());
    }
}

function listarProjetos(){
    require("conexao.php");
    $stmt = $pdo->query("SELECT id, nome FROM projetos ORDER BY nome");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function listarTarefas(){
    require("conexao.php");
    $stmt = $pdo->query("SELECT id, nome FROM tarefas ORDER BY nome");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function listarUsuarios(){
    require("conexao.php");
    $stmt = $pdo->query("SELECT id, nome FROM usuarios ORDER BY nome");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function listarClientes(){
    require("conexao.php");
    $stmt = $pdo->query("SELECT id, nome FROM clientes ORDER BY nome");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

$projetos = listarProjetos();
$tarefas = listarTarefas();
$usuarios = listarUsuarios();
$clientes = listarClientes();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $projeto_id = $_POST['projeto_id'];
    $tarefa_id = $_POST['tarefa_id'];
    $usuario_id = $_POST['usuario_id'];
    $status = $_POST['status'];
    $cliente_id = $_POST['cliente_id'];

    inserirAtividade($projeto_id, $tarefa_id, $usuario_id, $status, $cliente_id);
}
?>

<h2>Nova Atividade</h2>

<form method="post">
    <div class="mb-3">
        <label for="cliente_id" class="form-label">Cliente</label>
        <select id="cliente_id" name="cliente_id" class="form-control" required>
            <option value="">-- Selecione um cliente --</option>
            <?php foreach ($clientes as $c): ?>
                <option value="<?= $c['id'] ?>"><?= htmlspecialchars($c['nome']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="mb-3">
        <label for="projeto_id" class="form-label">Projeto</label>
        <select id="projeto_id" name="projeto_id" class="form-control" required>
            <option value="">-- Selecione um projeto --</option>
            <?php foreach ($projetos as $p): ?>
                <option value="<?= $p['id'] ?>"><?= htmlspecialchars($p['nome']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="mb-3">
        <label for="tarefa_id" class="form-label">Tarefa</label>
        <select id="tarefa_id" name="tarefa_id" class="form-control" required>
            <option value="">-- Selecione uma tarefa --</option>
            <?php foreach ($tarefas as $t): ?>
                <option value="<?= $t['id'] ?>"><?= htmlspecialchars($t['nome']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="mb-3">
        <label for="usuario_id" class="form-label">Desenvolvedor</label>
        <select id="usuario_id" name="usuario_id" class="form-control" required>
            <option value="">-- Selecione um desenvolvedor --</option>
            <?php foreach ($usuarios as $u): ?>
                <option value="<?= $u['id'] ?>"><?= htmlspecialchars($u['nome']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="mb-3">
        <label for="status" class="form-label">Status</label>
        <select id="status" name="status" class="form-control" required>
            <option value="">-- Selecione o status --</option>
            <option value="Concluído">Concluído</option>
            <option value="Em andamento">Em andamento</option>
            <option value="Parado">Parado</option>
        </select>
    </div>

    <button type="submit" class="btn btn-primary">Cadastrar</button>
    <button type="button" class="btn btn-secondary" onclick="location.href='atividades.php'">Voltar</button>
</form>

<?php
require_once("footer.php");
?>
