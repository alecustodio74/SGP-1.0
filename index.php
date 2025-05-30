<?php
require_once('conexao.php'); //inicia conexao com o banco de dados.
//o dbname=projetophp que declaramos no conexao.php

    if ($_SERVER['REQUEST_METHOD'] == "POST"){
        try{
                $email = $_POST['email'];
                $senha = $_POST['senha'];
                $stmt = $pdo->prepare('SELECT * FROM usuarios WHERE email = ?');
                $stmt->execute([$email]);
                //$stmt prepara o sql para inserir os dados
                $usuario = $stmt->fetch(PDO::FETCH_ASSOC); //variável que recebe todos os dados do SELECT
                    if ($usuario && password_verify($senha, $usuario['senha'])){
                    session_start();
                    //$_SESSION['usuario'] = $email;
                    $_SESSION['usuario'] = $usuario['nome'];
                    $_SESSION['acesso'] = true;
                    $_SESSION['id'] = $usuario['id']; //incluido em 03/04/2025
                    header('location: principal.php'); //muda o cabeçalho da resposta, como redirecionar para outra página.
                }else{
                    $mensagem['erro'] = "Usuário e/ou senha incorretos!";
                }
            } catch(Exception $e){
            echo "Erro: ".$e->getMessage();
            die(); //se der erro ele encerra a aplicação
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

    <?php //Para exibir a mensagem de primeiro login após se cadastrar
    if ((isset($_GET['cadastro'])) && ($_GET['cadastro'] == "true")): ?>
    <div class="alert alert-success mt-3 mb-3">
        Cadastro realizado com sucesso. Faça seu primeiro login!
    </div>
    <?php endif; ?>


     <?php //Para exibir a mensagem de primeiro login após se cadastrar
    if ((isset($_GET['alterado'])) && ($_GET['alterado'] == "true")): ?>
    <div class="alert alert-success mt-3 mb-3">
        Alteração realizada com sucesso. Faça login novamente!
    </div>
    <?php endif; ?>
</div> <!-- erro login -->

<!DOCTYPE html>
    <html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Alexandre Ricardo Custódio de Souza">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="estilos.css">
</head>

<body>

    <div class="container">
        <div class="left-side">
            <h1><p><img src="img/Logo_SGP_dado.png" style="width: 40%;"></p>Sistema de Gerenciamento<p>de Projetos 1.0</p></h1>
        </div>

        <div class="login-container">
            <div class="login-header">
                <h2>Acesso ao Sistema</h2>
            </div>
            <form action="" method="POST" class="login-form">
                <div class="input-group">
                    <label for="username">E-mail</label>
                    <input type="email" id="email" name="email" class="form-control" required="">
                </div>
                <div class="input-group">
                    <label for="password">Senha</label>
                    <input type="password" id="senha" name="senha" class="form-control" required="">
                </div>
                <button type="submit" class="login-button">Entrar</button>
                <div class="links">
                    <a href="atualizar_senha.php">Esqueceu sua senha?</a>
                    <a href="/novo_usuario.php">Não possui acesso? Cadastre-se!</a>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>     

<?php
  require_once("footer.php"); //chama o rodapé da página com o script
?>