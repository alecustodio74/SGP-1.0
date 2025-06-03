<?php
    require_once("header.php");

function buscarAtividade($id) {
    require("conexao.php");
    $sql = "SELECT a.*, 
                   t.id AS tarefa_id, t.nome AS tarefa_nome,
                   p.nome AS projeto_nome, 
                   c.nome AS cliente_nome
            FROM atividades a
            JOIN tarefas t ON a.tarefa_id = t.id
            JOIN projetos p ON a.projeto_id = p.id
            JOIN clientes c ON a.cliente_id = c.id
            WHERE a.id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function calcularStatus($data_inicio, $data_fim) {
    $hoje = new DateTime();
    $inicio = $data_inicio ? new DateTime($data_inicio) : null;
    $fim = $data_fim ? new DateTime($data_fim) : null;

    if ($inicio && $fim) {
        return 'Concluído';
    } elseif ($inicio && !$fim) {
        $dias = $inicio->diff($hoje)->days;
        return $dias > 30 ? 'Parado' : 'Em andamento';
    }
    return 'Desconhecido';
}

function calcularStatusCor($data_inicio, $data_fim) {
    $status = calcularStatus($data_inicio, $data_fim);
    $cores = [
        'Concluído' => 'success',
        'Em andamento' => 'warning',
        'Parado' => 'danger',
        'Desconhecido' => 'secondary'
    ];
    return [$status, $cores[$status] ?? 'secondary'];
}

function atualizarAtividade($id, $usuario_id, $data_inicio, $data_fim) {
    require("conexao.php");

    $status = calcularStatus($data_inicio, $data_fim);
    $data_fim = empty($data_fim) ? null : $data_fim;

    try {
        $pdo->beginTransaction();

        $sql = "UPDATE atividades 
                SET usuario_id = ?, status = ?, data_inicio = ?, data_fim = ?
                WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$usuario_id, $status, $data_inicio, $data_fim, $id]);

        $pdo->commit();
        header("Location: atividades.php");
        exit;
    } catch (Exception $e) {
        $pdo->rollBack();
        echo '<p class="text-danger">Erro ao atualizar: ' . $e->getMessage() . '</p>';
    }
}

function listarUsuarios() {
    require("conexao.php");
    $stmt = $pdo->query("SELECT id, nome FROM usuarios ORDER BY nome");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

if (!isset($_GET['id'])) {
    die("ID da atividade não informado.");
}

$id = $_GET['id'];
$atividade = buscarAtividade($id);
$usuarios = listarUsuarios();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario_id = $_POST['usuario_id'];
    $data_inicio = $_POST['data_inicio'];
    $data_fim = $_POST['data_fim'];
    atualizarAtividade($id, $usuario_id, $data_inicio, $data_fim);
}

list($status, $cor) = calcularStatusCor($atividade['data_inicio'], $atividade['data_fim']);
?>

<h2>Editar Atividade</h2>

<form method="post">
    <div class="row mb-3">
        <div class="col-md-4">
            <label class="form-label">Projeto</label>
            <input type="text" class="form-control" 
                   value="<?= $atividade['projeto_id'] . ' - ' . htmlspecialchars($atividade['projeto_nome']) ?>" 
                   readonly>
        </div>
        <div class="col-md-4">
            <label class="form-label">Tarefa</label>
            <input type="text" class="form-control" 
                   value="<?= $atividade['tarefa_id'] . ' - ' . htmlspecialchars($atividade['tarefa_nome']) ?>" 
                   readonly>
        </div>
        <div class="col-md-4">
            <label class="form-label">Cliente</label>
            <input type="text" class="form-control" 
                   value="<?= $atividade['cliente_id'] . ' - ' . htmlspecialchars($atividade['cliente_nome']) ?>" 
                   readonly>
        </div>
    </div>

    <div class="mb-3">
        <label for="usuario_id" class="form-label">Desenvolvedor</label>
        <select id="usuario_id" name="usuario_id" class="form-control" required>
            <option value="">-- Selecione um desenvolvedor --</option>
            <?php foreach ($usuarios as $u): ?>
                <option value="<?= $u['id'] ?>" <?= $u['id'] == $atividade['usuario_id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($u['nome']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="mb-3">
        <label class="form-label">Status Atual</label><br>
        <span class="badge bg-<?= $cor ?>"><?= $status ?></span>
    </div>

    <div class="mb-3">
        <label for="data_inicio" class="form-label">Data de Início</label>
        <input type="date" class="form-control" name="data_inicio" id="data_inicio"
               value="<?= $atividade['data_inicio'] ?>">
    </div>

    <div class="mb-3">
        <label for="data_fim" class="form-label">Data de Fim</label>
        <input type="date" class="form-control" name="data_fim" id="data_fim"
               value="<?= $atividade['data_fim'] ?>">
        <small class="form-text text-muted">Deixe em branco se ainda não foi finalizada.</small>
    </div>

    <button type="submit" class="btn btn-primary">Atualizar</button>
    <button type="button" class="btn btn-secondary" onclick="location.href='atividades.php'">Cancelar</button>
</form>

<?php
    require_once("footer.php");
?>
