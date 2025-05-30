<?php
require_once("header.php");
require("conexao.php");

if (!isset($_GET['id'])) {
    die("ID do membro não informado.");
}

$id = $_GET['id'];

// Buscar o membro
$sql = "SELECT * FROM usuarios WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id]);
$membro = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$membro) {
    die("Membro não encontrado.");
}

// Buscar todos os cargos
$sql = "SELECT * FROM cargo";
$cargos = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);

// Atualizar
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $cargo_id = $_POST['cargo_id'];
    $salario = $_POST['salario'];

    try {
        $sql = "UPDATE usuarios SET nome=?, email=?, cargo_id=?, salario=? WHERE id=?";
        $stmt = $pdo->prepare($sql);
        if ($stmt->execute([$nome, $email, $cargo_id, $salario, $id])) {
            header("Location: membros.php?alterado=true");
        } else {
            header("Location: membros.php?alterado=false");
        }
    } catch (Exception $e) {
        die("Erro ao atualizar membro: " . $e->getMessage());
    }
}
?>

<h4>Editar Membro</h4>

<form method="post">
    <div class="mb-3">
        <label for="nome" class="form-label">Nome</label>
        <input type="text" name="nome" id="nome" class="form-control" value="<?= $membro['nome'] ?>" required>
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" name="email" id="email" class="form-control" value="<?= $membro['email'] ?>" required>
    </div>
    <div class="mb-3">
        <label for="cargo_id" class="form-label">Cargo</label>
        <select name="cargo_id" id="cargo_id" class="form-select">
            <?php foreach ($cargos as $cargo): ?>
                <option value="<?= $cargo['id'] ?>" <?= $cargo['id'] == $membro['cargo_id'] ? 'selected' : '' ?>>
                    <?= $cargo['nome'] ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="mb-3">
        <label for="salario" class="form-label">Salário</label>
        <input type="number" step="0.01" name="salario" id="salario" class="form-control" value="<?= $membro['salario'] ?>" required>
    </div>
    <button type="submit" class="btn btn-primary">Salvar</button>
    <a href="membros.php" class="btn btn-secondary">Voltar</a>
</form>

<?php require_once("footer.php"); ?>
