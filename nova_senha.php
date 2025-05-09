<?php
    $mensagem = "";
    $token = $_GET['token'] ?? null;

    if (!$token) {
        $mensagem = "<div class='alert alert-danger'>Link de redefinição inválido.</div>";
    } else {
        require_once("conexao.php");
        $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE reset_token = :token AND reset_token_expiry > NOW()");
        $stmt->bindParam(':token', $token);
        $stmt->execute();
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$usuario) {
            $mensagem = "<div class='alert alert-danger'>Link de redefinição inválido ou expirado. Solicite novamente a redefinição de senha.</div>";
            $token = null; // Para desabilitar o formulário
        }
    }

    if (isset($_GET['senha_sucesso'])) {
        $mensagem = "<div class='alert alert-success'>Sua senha foi redefinida com sucesso! <a href='index.php'>Faça login</a>.</div>";
        $token = null; // Para desabilitar o formulário após a redefinição
    } elseif (isset($_GET['senha_erro'])) {
        $mensagem = "<div class='alert alert-danger'>Erro ao redefinir a senha. Tente novamente.</div>";
    }
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Nova Senha</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <style>
        body {
            background: linear-gradient(to right,#3e6fca,#083b6e);
        }
        .container {
            margin-top: 50px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        Criar Nova Senha
                    </div>
                    <div class="card-body">
                        <?php echo $mensagem; ?>
                        <?php if ($token): ?>
                            <form action="atualizar_senha.php" method="POST">
                                <input type="hidden" name="token" value="<?php echo $token; ?>">
                                <div class="mb-3">
                                    <label for="nova_senha" class="form-label">Nova Senha:</label>
                                    <input type="password" class="form-control" id="nova_senha" name="nova_senha" required>
                                </div>
                                <div class="mb-3">
                                    <label for="confirmar_senha" class="form-label">Confirmar Nova Senha:</label>
                                    <input type="password" class="form-control" id="confirmar_senha" name="confirmar_senha" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Redefinir Senha</button>
                            </form>
                        <?php endif; ?>
                        <div class="mt-3">
                            <a href="index.php">Voltar para o login</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>