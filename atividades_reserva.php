<?php
require_once("header.php");

function calcularStatus($data_tarefa, $data_fim) {
    $hoje = new DateTime();
    $inicio = $data_tarefa ? new DateTime($data_tarefa) : null;
    $fim = $data_fim ? new DateTime($data_fim) : null;

    if ($inicio && $fim) {
        return 'Concluído';
    } elseif ($inicio && !$fim) {
        $dias = $inicio->diff($hoje)->days;
        return $dias > 30 ? 'Parado' : 'Em andamento';
    }
    return 'Desconhecido';
}

function calcularStatusCor($data_tarefa, $data_fim) {
    $status = calcularStatus($data_tarefa, $data_fim);
    $cores = [
        'Concluído' => 'success',
        'Em andamento' => 'warning',
        'Parado' => 'danger',
        'Desconhecido' => 'secondary'
    ];
    return [$status, $cores[$status] ?? 'secondary'];
}

function retornaAtividades() {
    require("conexao.php");
    try {
        $sql = "SELECT a.*, 
                       p.nome AS nome_projeto, 
                       t.nome AS nome_tarefa, 
                       t.data_inicio AS data_tarefa,
                       u.nome AS nome_usuario, 
                       c.nome AS nome_cliente
                FROM atividades a
                INNER JOIN projetos p ON p.id = a.projeto_id
                INNER JOIN tarefas t ON t.id = a.tarefa_id
                INNER JOIN usuarios u ON u.id = a.usuario_id
                INNER JOIN clientes c ON c.id = a.cliente_id";
        $stmt = $pdo->query($sql);
        return $stmt->fetchAll();
    } catch (Exception $e) {
        die("Erro ao consultar atividades: " . $e->getMessage());
    }
}

function formatarDataBR($data) {
    if (!$data) return 'N/A';
    $dt = new DateTime($data);
    return $dt->format('d/m/Y');
}

$atividades = retornaAtividades();
?>

<style>
.botao-status {
    height: 30px;
    width: 30px;
    padding: 0;
    font-size: 18px;
    line-height: 30px;
    text-align: center;
    vertical-align: middle;
}
.badge{
    width: 95px;
    height: 30px;
    padding: 0;
    line-height: 30px;
    text-align: center; 
}
</style>

<h4>Atividades</h4>
<a href="nova_atividade.php" class="btn btn-success mb-3">Nova Atividade</a>

<?php if (isset($_GET['cadastro']) && $_GET['cadastro'] == true): ?>
    <p class="text-success">Registro salvo com sucesso!</p>
<?php elseif (isset($_GET['cadastro']) && $_GET['cadastro'] == false): ?>
    <p class="text-danger">Erro ao inserir o registro!</p>
<?php endif; ?>

<table class="table table-hover table-striped" id="tabela">
    <thead>
        <tr>
            <th>ID</th>
            <th>PROJETO</th>
            <th>TAREFA</th>
            <th>DESENVOLVEDOR</th>
            <th>STATUS</th>
            <th style="text-align: center;">AÇÕES</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($atividades as $a): ?>
            <?php list($status, $cor) = calcularStatusCor($a['data_tarefa'], $a['data_fim']); ?>
            <tr>
                <td><?= $a['id'] ?></td>
                <td><?= htmlspecialchars($a['nome_projeto']) ?></td>
                <td><?= htmlspecialchars($a['nome_tarefa']) ?></td>
                <td><?= htmlspecialchars($a['nome_usuario']) ?></td>
                <td>
                    <span class="badge bg-<?= $cor ?> text-white">
                        <?= $status ?>
                    </span>
                    <button class="btn btn-sm btn-light border rounded-circle ms-2 botao-status" onclick="mostrarDetalhes(this)">
                        +
                    </button>
                    <div class="mt-2 detalhes d-none">
                        <small>Cliente: <strong><?= htmlspecialchars($a['nome_cliente']) ?></strong></small><br>
                        <small>Início da Atividade: <strong><?= formatarDataBR($a['data_inicio']) ?: 'N/A' ?></strong></small><br>
                        <small>Fim: <strong><?= formatarDataBR($a['data_fim']) ?: 'N/A' ?></strong></small><br>
                        <small>Início da Tarefa: <strong><?= formatarDataBR($a['data_tarefa']) ?: 'N/A' ?></strong></small>
                    </div>
                </td>
                <td style="text-align: center;">
                    <a href="editar_atividade.php?id=<?= $a['id'] ?>" class="btn btn-warning">Editar</a>
                    <a href="consultar_atividades.php?id=<?= $a['id'] ?>" class="btn btn-info">Consultar</a>
                </td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>

<script>
    function mostrarDetalhes(botao) {
        const div = botao.nextElementSibling;
        div.classList.toggle('d-none');
    }
</script>

<?php
require_once("footer.php");
?>
