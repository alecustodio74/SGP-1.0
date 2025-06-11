<?php
require_once("header.php");
require("conexao.php");

function calcularStatus($data_tarefa, $data_inicio, $data_fim) {
    $hoje = new DateTime();
    $tarefa = $data_tarefa ? new DateTime($data_tarefa) : null;
    $inicio = $data_inicio ? new DateTime($data_inicio) : null;
    $fim = $data_fim ? new DateTime($data_fim) : null;

    if ($fim) {
        return 'Concluído';
    }

    if ($inicio && !$tarefa) {
        // Se data_inicio preenchida e data_tarefa vazia
        $diff = $inicio->diff($hoje)->days;
        return $diff > 30 ? 'Parado' : 'Em andamento';
    }

    if ($inicio && $tarefa) {
        $diff_tarefa_hoje = $tarefa->diff($hoje)->days;
        $diff_tarefa_inicio = $inicio->diff($tarefa)->days;

        if ($diff_tarefa_hoje > 30) {
            return 'Parado';
        }
        if ($diff_tarefa_inicio > 30 && $diff_tarefa_hoje <= 30) {
            return 'Em andamento';
        }
        return 'Em andamento';
    }

    // Caso apenas data_tarefa esteja preenchida ou tudo esteja vazio
    return 'Desconhecido';
}


function buscarAtividades() {
    global $pdo;
    $sql = "SELECT a.id, a.usuario_id, a.data_inicio, a.data_fim, a.data_tarefa, 
                   t.nome AS tarefa_nome, p.nome AS projeto_nome, c.nome AS cliente_nome,
                   u.nome AS usuario_nome
            FROM atividades a
            JOIN tarefas t ON a.tarefa_id = t.id
            JOIN projetos p ON a.projeto_id = p.id
            JOIN clientes c ON a.cliente_id = c.id
            LEFT JOIN usuarios u ON a.usuario_id = u.id
            ORDER BY a.id DESC";
    $stmt = $pdo->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

$atividades = buscarAtividades();

$cores = ['Concluído' => 'success', 'Em andamento' => 'warning', 'Parado' => 'danger', 'Desconhecido' => 'secondary'];
?>

<h2>Lista de Atividades</h2>

<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Projeto</th>
            <th>Tarefa</th>
            <th>Cliente</th>
            <th>Desenvolvedor</th>
            <th>Data Início</th>
            <th>Data Tarefa</th>
            <th>Data Fim</th>
            <th>Status</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($atividades as $a): 
            $status = calcularStatus($a['data_tarefa'], $a['data_inicio'], $a['data_fim']);
            $cor = $cores[$status] ?? 'secondary';
        ?>
        <tr>
            <td><?= $a['id'] ?></td>
            <td><?= htmlspecialchars($a['projeto_nome']) ?></td>
            <td><?= htmlspecialchars($a['tarefa_nome']) ?></td>
            <td><?= htmlspecialchars($a['cliente_nome']) ?></td>
            <td><?= htmlspecialchars($a['usuario_nome'] ?? 'Não definido') ?></td>
            <td><?= $a['data_inicio'] ?? '-' ?></td>
            <td><?= $a['data_tarefa'] ?? '-' ?></td>
            <td><?= $a['data_fim'] ?? '-' ?></td>
            <td><span class="badge bg-<?= $cor ?>"><?= $status ?></span></td>
            <td>
                <a href="editar_atividade.php?id=<?= $a['id'] ?>" class="btn btn-sm btn-primary">Editar</a>
                <button class="btn btn-sm btn-danger btn-excluir" data-id="<?= $a['id'] ?>">Excluir</button>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.querySelectorAll('.btn-excluir').forEach(btn => {
    btn.addEventListener('click', () => {
        const id = btn.getAttribute('data-id');
        Swal.fire({
            title: 'Confirmar exclusão?',
            text: `Excluir a atividade ID ${id}? Esta ação não pode ser desfeita.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sim, excluir',
            cancelButtonText: 'Cancelar',
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(`excluir_atividade.php?id=${id}`, {
                    method: 'GET',
                    headers: {'Content-Type': 'application/json'}
                }).then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire('Excluído!', 'Atividade excluída com sucesso.', 'success')
                        .then(() => location.reload());
                    } else {
                        Swal.fire('Erro!', data.message || 'Erro ao excluir.', 'error');
                    }
                }).catch(() => {
                    Swal.fire('Erro!', 'Erro na comunicação com o servidor.', 'error');
                });
            }
        });
    });
});
</script>

<?php require_once("footer.php"); ?>
