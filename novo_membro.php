<?php
require_once("header.php");

function retornaCargos(){
    require("conexao.php");
    try {
        $sql = "SELECT * FROM cargo";
        $stmt = $pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch(Exception $e) {
        die("Erro ao consultar cargos: " . $e->getMessage());
    }
}

$cargos = retornaCargos();
$mensagem = [];

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    inserirMembros();
}

function inserirMembros() {
    require("conexao.php");
    global $mensagem;

    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $confirmaSenha = $_POST['confirmaSenha'];
    $salario = $_POST['salario'];
    $cargo_id = $_POST['cargo_id'];

    try {
        // Verifica se email já existe
        $check = $pdo->prepare("SELECT id FROM usuarios WHERE email = ?");
        $check->execute([$email]);

        if ($check->rowCount() > 0) {
            $mensagem['erro'] = "Email já existe no sistema. Cadastre-se com outro e-mail!";
        } else {
            if ($senha === $confirmaSenha) {
                $senha = password_hash($senha, PASSWORD_BCRYPT); // Criptografando com bcrypt
                $stmt = $pdo->prepare("INSERT INTO usuarios (nome, email, senha, salario, cargo_id) VALUES (?, ?, ?, ?, ?)");
                
                if ($stmt->execute([$nome, $email, $senha, $salario, $cargo_id])) {
                    header("location: membros.php?cadastro=true");
                    exit;
                } else {
                    $mensagem['erro'] = "Erro ao inserir membro!";
                }
            } else {
                $mensagem['erro'] = "Senhas não conferem. Redigite e confirme a senha!";
            }
        }
    } catch (Exception $e) {
        $mensagem['erro'] = "Erro ao inserir usuário: " . $e->getMessage();
    }
}
?>

<h4>Cadastrar Novo Membro</h4>

<?php if (!empty($mensagem['erro'])): ?>
    <div class="alert alert-danger"><?= $mensagem['erro'] ?></div>
<?php endif; ?>

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
        <label for="senha" class="form-label">Senha</label>
        <input type="password" id="senha" name="senha" class="form-control" required maxlength="15" placeholder="Máximo de 15 caracteres">
    </div>

    <div class="mb-3">
        <label for="confirmaSenha" class="form-label">Repetir a Senha</label>
        <input type="password" id="confirmaSenha" name="confirmaSenha" class="form-control" required maxlength="15" placeholder="Máximo de 15 caracteres">
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

<?php require_once("footer.php"); ?>
