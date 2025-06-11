<?php
require_once("header.php");

function inserirAtividade($projeto_id, $tarefa_id, $usuario_id, $data_inicio, $status, $cliente_id) {
    require("conexao.php");
    try {
        $data_formatada = DateTime::createFromFormat('d/m/Y', $data_inicio)->format('Y-m-d');
        $sql = "INSERT INTO atividades (projeto_id, tarefa_id, usuario_id, data_inicio, status, cliente_id) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        if ($stmt->execute([$projeto_id, $tarefa_id, $usuario_id, $data_formatada, $status, $cliente_id])) {
            header('Location: atividades.php?cadastro=true');
            exit;
        } else {
            echo '<p class="text-danger">Erro ao inserir atividade.</p>';
        }
    } catch (Exception $e) {
        die("Erro ao inserir atividade: " . $e->getMessage());
    }
}

function listarProjetos() {
    require("conexao.php");
    $stmt = $pdo->query("SELECT id, nome FROM projetos ORDER BY nome");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function listarTarefas() {
    require("conexao.php");
    $stmt = $pdo->query("SELECT id, nome FROM tarefas ORDER BY nome");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function listarUsuarios() {
    require("conexao.php");
    $stmt = $pdo->query("SELECT id, nome FROM usuarios ORDER BY nome");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function listarClientes() {
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
    $data_inicio = $_POST['data_inicio'];
    $status = $_POST['status']; // "Em andamento"
    $cliente_id = $_POST['cliente_id'];

    inserirAtividade($projeto_id, $tarefa_id, $usuario_id, $data_inicio, $status, $cliente_id);
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
        <label for="data_inicio" class="form-label">Data de Início</label>
        <input type="text" id="data_inicio" name="data_inicio" class="form-control" value="<?= date('d/m/Y') ?>" required>
    </div>

    <!-- Campo oculto para status -->
    <input type="hidden" name="status" value="Em andamento">

    <button type="submit" class="btn btn-primary">Cadastrar</button>
    <button type="button" class="btn btn-secondary" onclick="location.href='atividades.php'">Voltar</button>
</form>

<script>
    // Máscara de data (dd/mm/aaaa)
    document.getElementById('data_inicio').addEventListener('input', function(e) {
        let v = e.target.value.replace(/\D/g, '').slice(0, 8);
        if (v.length >= 5)
            e.target.value = v.replace(/(\d{2})(\d{2})(\d{0,4})/, '$1/$2/$3');
        else if (v.length >= 3)
            e.target.value = v.replace(/(\d{2})(\d{0,2})/, '$1/$2');
        else
            e.target.value = v;
    });
</script>

<?php
require_once("footer.php");
?>
