<?php
    $mensagem = "";
    if (isset($_GET['erro'])) {
        $mensagem = "<div class='alert alert-danger'>E-mail não encontrado em nossa base de dados.</div>";
    } elseif (isset($_GET['sucesso'])) {
        $mensagem = "<div class='alert alert-success'>Um link para redefinição de senha foi enviado para o seu e-mail. Verifique sua caixa de entrada e spam.</div>";
    }
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redefinir Senha</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <meta name="author" content="Alexandre Ricardo Custódio de Souza">
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
                    <img src="img/Logo_SGP_dado.png" style="width: 30%; margin: auto;">
                    <div class="card-header">
                        Redefinir sua senha
                    </div>
                    <div class="card-body">
                        <?php echo $mensagem; ?>
                        <p>Informe o seu endereço de e-mail para enviarmos um link de redefinição de senha.</p>
                        <form action="enviar_email_redefinicao.php" method="POST">
                            <div class="mb-3">
                                <label for="email" class="form-label">E-mail:</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Enviar link de redefinição</button>
                            <div class="mt-3">
                                <a href="index.php">Voltar para o login</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>