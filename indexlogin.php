<!-- Esta é a tela antiga de Login -->
 <!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Alexandre Ricardo Custódio de Souza">
    <title>Sessions e Cookies</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body class="container">

    <?php
    require_once('conexao.php'); //inicia conexao com o banco de dados.
    //neste exercicio é o dbname=projetophp que declaramos no conexao.php
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
    
    <form action="" method="POST">
        <div class="mb-3">
            <div class="col-3">
            <label for="email" class="form-label">E-mail de acesso</label>
            <input type="email" id="email" name="email" class="form-control" required="">
        </div>
        </div>

        <div class="mb-3">
        <div class="col-3">
            <label for="senha" class="form-label">Senha</label>
            <input type="password" id="senha" name="senha" class="form-control" required="">
        </div>
        </div>
        <div class="mb-3">
            <div class="col-3">
                <button type="submit" class="btn btn-primary">Acessar</button>
            </div>
        </div>
        <div class="row">
            <div class="col">
                Não possui acesso? Clique <a href="/novo_usuario.php">aqui</a>
            </div>
        </div>
    </form>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>     
</body>
</html>