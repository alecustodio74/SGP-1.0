<?php
    require_once("header.php");
  
    function retornaDadosUsuario(){
        require("conexao.php");
        try { //aqui consultamos se o usuário existe
            $sql = "SELECT * FROM usuarios WHERE id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$_SESSION['id']]);
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!$usuario){
            } else {
            return $usuario;
            }
        } catch (Exception $e) {
            die("Erro ao consultar o usuário");
        }
    }
        function alterarDadosUsuario($nome, $email){
            require("conexao.php");
            try{
                $sql = "UPDATE usuarios SET nome = ?, email = ? WHERE id = ?";
                $stmt = $pdo->prepare($sql);
                if ($stmt->execute([$nome, $email, $_SESSION['id']]))
                    echo "<p>Dados alterados com sucesso!</p>";
                else
                    echo "<p class='text-danger'> Erro ao alterar dados! </p>";
            } catch (Exception $e){
                die("Erro ao alterar dados do usuário: ".$e->getMessage());
            }
        }

        function alterarSenha($senhaAntiga, $novaSenha, $novaSenhaConfirm){
            require("conexao.php");
            try{
                if ($novaSenha == $novaSenhaConfirm){
                    $usuario = retornaDadosUsuario();
                    if (password_verify($senhaAntiga, $usuario['senha'])){
                        $sql = "UPDATE usuarios SET senha = ? WHERE id = ?";
                        $stmt = $pdo->prepare($sql);
                        $novaSenha = password_hash($novaSenha, PASSWORD_BCRYPT);
                        if ($stmt->execute([$novaSenha, $_SESSION['id']])){
                            require("sair.php");
                        } else {
                            echo "<p class='text-danger'>Erro ao alterar a senha!</p>";
                        }
                    }
                } else {
                    echo "<p class='text-danger'> Senhas não conferem! </p>";
                }
            } catch (Exception $e){
                die("Erro ao alterar senha: ". $e->getMessage());
            }
        }
     //aqui chamamos definitiavamente a função para alterar
    if ($_SERVER['REQUEST_METHOD'] == "POST"){
        if (isset($_POST['nome']) && isset($_POST['email'])){
            alterarDadosUsuario($_POST['nome'], $_POST['email']);
        } else if (isset($_POST['nova_senha'])){
            alterarSenha($_POST['senha_antiga'],$_POST['nova_senha'], $_POST['nova_senha_confirm']);
        }
    }
    $usuario = retornaDadosUsuario();
  ?>
  <head>
    <title>Alterar dados</title>
  </head>

  <body>
    <main class="container">
    
        <h4>Alteração de dados pessoais</h4>
    
            <form method="post">
                        
                        <div class="mb-3">
                            <label for="nome" class="form-label">Nome do usuário</label>
                            <input value="<?= $usuario['nome']?>" type="text" id="nome" name="nome" class="form-control" required="">
                        </div>
                    
                        <div class="mb-3">
                            <label for="email" class="form-label">E-mail do usuário</label>
                            <input value="<?= $usuario['email']?>" type="email" id="email" name="email" class="form-control" required="">
                        </div>
                    
                    <button type="submit" class="btn btn-primary">Alterar</button>
            </form>
    
    <p></p>
    <h4>Alteração de senha</h4>
    
        <form method="post">
                        
                        <div class="mb-3">
                            <label for="senha_antiga" class="form-label">Informe a senha antiga</label>
                            <input type="password" id="senha_antiga" name="senha_antiga" class="form-control" required="">
                        </div>
                    
                        <div class="mb-3">
                            <label for="nova_senha" class="form-label">Informe a nova senha</label>
                            <input type="password" id="nova_senha" name="nova_senha" class="form-control" required="">
                        </div>
                    
                        <div class="mb-3">
                            <label for="nova_senha_confirm" class="form-label">Repita a nova senha</label>
                            <input type="password" id="nova_senha_confirm" name="nova_senha_confirm" class="form-control" required="">
                        </div>
                    
                    <button type="submit" class="btn btn-primary">Alterar</button>
        </form>
    
            
            
  <!-- o arquivo termina o código html no footer.php -->

  

<?php
  require_once("footer.php");