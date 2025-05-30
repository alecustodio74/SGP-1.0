<?php
    require_once("conexao.php"); //conectando ao banco de dados
    if ($_SERVER['REQUEST_METHOD'] == "POST"){
        try{
            $nome = $_POST['nome'];
            $email = $_POST['email'];
            $senha = ($_POST['senha']);
            $confirmaSenha = ($_POST['confirmaSenha']);

            // Verifica se email já existe
            $check = $pdo->prepare("SELECT id FROM usuarios WHERE email = ?");
            $check->execute([$email]);
            if ($check->rowCount() > 0) {
                $mensagem['erro'] = "Email já existe no sistema. Cadastre-se com outro e-mail ! ";
            } else {
                if ($senha === $confirmaSenha){
                    $senha = password_hash($_POST['senha'], PASSWORD_BCRYPT); //Criptografando a senha de usuário
                    $stmt = $pdo->prepare("INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)");
                    //para conferir as senhas
                    //$stmt prepara o sql para inserir os dados
                    if ($stmt->execute([$nome, $email, $senha])){ //inserie os dados no DB como um array
                        header("location: index.php?cadastro=true");
                    } else {
                        echo "<p>Erro ao inserir usuário!</p>";
                    }
                } else {
                    $mensagem['erro'] = "Senhas não conferem. Redigite e confirme a senha!";
                }
            }
        } catch (Exception $e) {
            echo "Erro ao inserir usuário". $e->getMessage();
        }
    }
?>

<div class="errologin">
<?php //para exibir a mensagem de erro em caso de entrada de e-mail e/ou senha incorretos no login
    if (isset($mensagem['erro'])): ?>
    <div class="alert alert-danger mt-3 mb-3">
        <?= $mensagem['erro'] ?>
    </div>
    <?php endif; ?>
    
    <?php //para exibir a mensagem de erro ao tentar acessar alguma página pela url sem estar logado
    if ((isset($_GET['mensagem'])) && ($_GET['mensagem'] == "acesso_negado")): ?>
    <div class="alert alert-danger mt-3 mb-3">
        Você precisa informar seus dados de acesso para entrar no sistema!
    </div>
    <?php endif; ?>
</div> <!-- erro login -->

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Alexandre Ricardo Custódio de Souza">
    <title>Novo usuário</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="estilos.css">
    <!-- colocar aqui o cdn do sweet alert -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.5/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.5/dist/sweetalert2.all.min.js"></script>
</head>
<body>
    <div class="container">
        <div class="left-side">
            <h1><a class="navbar-brand" href="index.php"><p><img src="img/Logo_SGP_dado.png" style="width: 40%;"></p>Sistema de Gerenciamento<p>de Projetos 1.0</p></a></h1>
        </div>
    
    <div class="login-container">
        <div class="login-header">
            <h2>Cadastro de novo usuário</h2>
        </div>
            <form method="post" class="login-form" id="formNovoUsuario">
                <div class="input-group">         
                    <label for="nome" class="form-label">Nome completo:</label>
                    <input type="text" id="nome" name="nome" class="form-control" required="">
                </div>
                <div class="input-group">
                    <label for="email" class="form-label">Informe seu email:</label>
                    <input type="email" id="email" name="email" class="form-control" required="">
                </div>
                <div class="input-group">
                    <label for="senha" class="form-label">Digite a senha:</label>
                    <input type="password" id="senha" name="senha" class="form-control" maxlength="15" placeholder="Máximo de 15 caracteres" required="">
                </div>
                <div class="input-group">
                    <label for="confirmaSenha" class="form-label">Confirme a sua senha:</label>
                    <input type="password" id="confirmaSenha" name="confirmaSenha" class="form-control" maxlength="15" placeholder="Máximo de 15 caracteres" required="">
                </div>
                <!-- 02/05/2025 Implementado a confirmação da senha ao realizar novo cadastro -->
                <div class="input-group">
                    
                    <div class="lgpd">
                        <input type="checkbox" id="lgpd" name="lgpd" class="form-check-input" required="">
                        <label for="lgpd" class="form-check-label">Ao submeter esse formulário, declaro que li e entendi que o tratamento de dados pessoais será realizado nos termos da Política de Privacidade do SGP</label>
                    </div>               
            </div>
            <button type="submit" class="btn btn-primary" id="btnNovoUsuario">Cadastrar</button>
        </form>
       
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>     

<?php
  require_once("footer.php"); //chama o rodapé da página com o script
?>