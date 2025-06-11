<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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

/**
 * Calcula o status da atividade conforme as regras:
 * - Se data_fim preenchida: 'Concluído'
 * - Se data_tarefa está mais de 30 dias atrás: 'Parado'
 * - Se data_inicio preenchida: 'Em andamento'
 * - Senão: 'Desconhecido'
 */
function calcularStatus($data_tarefa, $data_inicio, $data_fim) {
    $hoje = new DateTime();
    $tarefa = $data_tarefa ? new DateTime($data_tarefa) : null;
    $inicio = $data_inicio ? new DateTime($data_inicio) : null;
    $fim = $data_fim ? new DateTime($data_fim) : null;

    if ($fim) {
        return 'Concluído';
    }

    if ($inicio && !$tarefa) {
        $diff = $inicio->diff($hoje)->days;
        return $diff > 30 ? 'Parado' : 'Em andamento';
    }

    if ($inicio && $tarefa) {
        $diff_tarefa = $tarefa->diff($hoje)->days;
        return $diff_tarefa > 30 ? 'Parado' : 'Em andamento';
    }

    return 'Desconhecido';
}

function listarUsuarios() {
    require("conexao.php");
    $stmt = $pdo->query("SELECT id, nome FROM usuarios ORDER BY nome");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function atualizarAtividade($id, $usuario_id, $data_inicio, $data_fim, $data_tarefa) {
    require("conexao.php");

    $atividade_antiga = buscarAtividade($id);

    // Calcula status com 3 parâmetros
    $status = calcularStatus($data_tarefa, $data_inicio, $data_fim);

    $data_fim = empty($data_fim) ? null : $data_fim;
    $data_tarefa = empty($data_tarefa) ? null : $data_tarefa;
    $data_inicio = empty($data_inicio) ? null : $data_inicio;

    try {
        $pdo->beginTransaction();

        $stmtUser = $pdo->prepare("SELECT nome FROM usuarios WHERE id = ?");
        $stmtUser->execute([$usuario_id]);
        $usuario_nome = $stmtUser->fetchColumn();

        $sql = "UPDATE atividades 
                SET usuario_id = ?, status = ?, data_inicio = ?, data_fim = ?, data_tarefa = ?
                WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$usuario_id, $status, $data_inicio, $data_fim, $data_tarefa, $id]);

        $pdo->commit();

        // Auditoria
        $alteracoes = [];

        if ($atividade_antiga['usuario_id'] != $usuario_id) {
            $alteracoes[] = "Desenvolvedor: ID {$atividade_antiga['usuario_id']} → ID $usuario_id";
        }
        if ($atividade_antiga['data_inicio'] != $data_inicio) {
            $alteracoes[] = "Data Início: {$atividade_antiga['data_inicio']} → $data_inicio";
        }
        if ($atividade_antiga['data_fim'] != $data_fim) {
            $alteracoes[] = "Data Fim: {$atividade_antiga['data_fim']} → " . ($data_fim ?? 'NULL');
        }
        if ($atividade_antiga['data_tarefa'] != $data_tarefa) {
            $alteracoes[] = "Data Tarefa: {$atividade_antiga['data_tarefa']} → " . ($data_tarefa ?? 'NULL');
        }
        if ($atividade_antiga['status'] != $status) {
            $alteracoes[] = "Status: {$atividade_antiga['status']} → $status";
        }

        $log = sprintf(
            "[%s] ID %d (%s) editada por %s (ID %d) - %s\n",
            date('Y-m-d H:i:s'),
            $id,
            $atividade_antiga['tarefa_nome'] ?? 'Tarefa desconhecida',
            $usuario_nome ?? 'Usuário desconhecido',
            $usuario_id,
            count($alteracoes) ? implode(" | ", $alteracoes) : "Nenhuma alteração detectada"
        );

        if (!is_dir("logs")) mkdir("logs", 0777, true);
        file_put_contents("logs/atividades.log", $log, FILE_APPEND);

        header("Location: atividades.php");
        exit;
    } catch (Exception $e) {
        $pdo->rollBack();
        echo '<p class="text-danger">Erro ao atualizar: ' . $e->getMessage() . '</p>';
    }
}

// --- EXECUÇÃO ---

if (!isset($_GET['id'])) die("ID da atividade não informado.");

$id = $_GET['id'];
$atividade = buscarAtividade($id);
$usuarios = listarUsuarios();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario_id = $_POST['usuario_id'];
    $data_inicio = $_POST['data_inicio'];
    $data_fim = $_POST['data_fim'];
    $data_tarefa = $_POST['data_tarefa'];
    atualizarAtividade($id, $usuario_id, $data_inicio, $data_fim, $data_tarefa);
}

$status = calcularStatus($atividade['data_tarefa'], $atividade['data_inicio'], $atividade['data_fim']);
$cores = ['Concluído' => 'success', 'Em andamento' => 'warning', 'Parado' => 'danger', 'Desconhecido' => 'secondary'];
$cor = $cores[$status] ?? 'secondary';
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
        <label for="data_tarefa" class="form-label">Modificado em</label>
        <input type="date" class="form-control" name="data_tarefa" id="data_tarefa"
               value="<?= $atividade['data_tarefa'] ?>">
        <small class="form-text text-muted">Para mostrar se está em andamento ou parada.</small>
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

<?php require_once("footer.php"); ?>
