<?php
    require_once("conexao.php"); // Inclui suas informações de conexão ao banco de dados

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);

    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // 1. Verificar se o e-mail existe no banco de dados
        $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario) {
            $user_id = $usuario['id'];

            // 2. Gerar um token único de redefinição de senha
            $token = bin2hex(random_bytes(32));
            $expiry_time = date("Y-m-d H:i:s", time() + (60 * 60)); // Validade de 1 hora

            // 3. Salvar o token no banco de dados associado ao usuário
            $stmt = $pdo->prepare("UPDATE usuarios SET reset_token = :token, reset_token_expiry = :expiry WHERE id = :id");
            $stmt->bindParam(':token', $token);
            $stmt->bindParam(':expiry', $expiry_time);
            $stmt->bindParam(':id', $user_id);
            $stmt->execute();

            // 4. Criar o link de redefinição de senha
            $reset_link = "http://seu_dominio.com/nova_senha.php?token=" . $token; // Substitua seu_dominio.com

            // 5. Enviar o e-mail com o link
            $assunto = "Redefinição de Senha - Seu Sistema";
            $corpo = "Olá,<br><br>Você solicitou a redefinição da sua senha em nosso sistema.<br><br>Para criar uma nova senha, clique no link abaixo ou copie e cole no seu navegador:<br><br><a href='" . $reset_link . "'>" . $reset_link . "</a><br><br>Este link é válido por 1 hora.<br><br>Se você não solicitou esta redefinição, ignore este e-mail.<br><br>Atenciosamente,<br>Sua Equipe.";
            $headers = "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
            $headers .= "From: seu_email@seu_dominio.com\r\n"; // Substitua seu_email@seu_dominio.com

            if (mail($email, $assunto, $corpo, $headers)) {
                header("Location: redefinir_senha.php?sucesso=1");
                exit();
            } else {
                die("Erro ao enviar o e-mail de redefinição."); // Log este erro
            }

        } else {
            // E-mail não encontrado
            header("Location: redefinir_senha.php?erro=1");
            exit();
        }

    } else {
        die("E-mail inválido.");
    }
} else {
    header("Location: redefinir_senha.php");
    exit();
}
?>