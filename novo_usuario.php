<?php
    require_once("conexao.php"); //conectando ao banco de dados
    if ($_SERVER['REQUEST_METHOD'] == "POST"){
        try{
            $nome = $_POST['nome'];
            $email = $_POST['email'];
            $senha = password_hash($_POST['senha'], PASSWORD_BCRYPT); //Criptografando a senha de usuário
            $stmt = $pdo->prepare("INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)");
            //$stmt prepara o sql para inserir os dados
            if ($stmt->execute([$nome, $email, $senha])){ //inserie os dados como um array
                    header("location: index.php?cadastro=true");
            } else {
                echo "<p>Erro ao inserir usuário!</p>";
            }

        } catch (Exception $e) {
            echo "Erro ao inserir usuário". $e->getMessage();
        }
    }
?>
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
    <main>
        <h1 class="mt-5">Novo usuário</h1>
            <form method="post">                     
                <div class="mb-3">
                    <div class="col-3">
                        <label for="nome" class="form-label">Informe o nome:</label>
                        <input type="text" id="nome" name="nome" class="form-control" required="">
                    </div>
                </div>
            
                <div class="mb-3">
                    <div class="col-3">
                        <label for="email" class="form-label">Informe o email:</label>
                        <input type="email" id="email" name="email" class="form-control" required="">
                    </div>
                </div>
            
                <div class="mb-3">
                    <div class="col-3">
                        <label for="senha" class="form-label">Digite a senha:</label>
                        <input type="password" id="senha" name="senha" class="form-control" required="">
                    </div>
                </div>
                <!-- 10/04/2025 Bom seria pedir para repetir a senha nova antes de continuar
                    e realizar uma validação
                <div class="mb-3">
                    <label for="senha" class="form-label">Confirme a senha:</label>
                    <input type="password" id="senha" name="senha" class="form-control" required="">
                </div>
                
                -->
                <button type="submit" class="btn btn-primary">Enviar</button>
            </form>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>     
</body>
</html>