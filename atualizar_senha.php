<?php
require_once("conexao.php"); // Inclui suas informações de conexão ao banco de dados

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $token = filter_input(INPUT_POST, 'token');
    $nova_senha = filter_input(INPUT_POST, 'nova_senha');
    $confirmar_senha = filter_input(INPUT_POST, 'confirmar_senha');

    if ($nova_senha === $confirmar_senha && strlen($nova_senha) >= 6) { // Adicione validações de senha
        $senha_hash = password_hash($nova_senha, PASSWORD_DEFAULT);

        $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE reset_token = :token AND reset_token_expiry > NOW()");
        $stmt->bindParam(':token', $token);
        $stmt->execute();
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario) {
            $user_id = $usuario['id'];

            $stmt = $pdo->prepare("UPDATE usuarios SET senha = :senha, reset_token = NULL, reset_token_expiry = NULL WHERE id = :id");
            $stmt->bindParam(':senha', $senha_hash);
            $stmt->bindParam(':id', $user_id);

            if ($stmt->execute()) {
                header("Location: nova_senha.php?senha_sucesso=1");
                exit();
            } else {
                header("Location: nova_senha.php?senha_erro=1");
                exit();
            }
        } else {
            header("Location: nova_senha.php?erro=1"); // Link inválido ou expirado
            exit();
        }
    } else {
        header("Location: nova_senha.php?erro=2"); // Senhas não coincidem ou são muito curtas
        exit();
    }
} else {
    header("Location: redefinir_senha.php");
    exit();
}
?>