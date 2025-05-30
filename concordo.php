<?php
// Página limpa sem header ou menu
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Termo de Consentimento - LGPD</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(to right,#3e6fca,#083b6e);
            margin: 0;
            padding: 40px;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .termo-container {
            max-width: 700px;
            padding: 30px;
            border: 1px solid #ccc;
            border-radius: 12px;
            background-color: white;
            position: relative;
            box-shadow: 0 0 12px rgba(0, 0, 0, 0.1);
        }
        .fechar {
            position: absolute;
            top: 10px;
            right: 15px;
            font-size: 22px;
            font-weight: bold;
            color: #aaa;
            text-decoration: none;
        }
        .fechar:hover {
            color: #000;
        }
        .termo-container h2 {
            margin-top: 0;
        }
        .termo-container p {
            text-align: justify;
            margin-bottom: 20px;
        }
        .btn-concordar {
            background-color: #007bff;
            border: none;
            color: white;
            padding: 12px 24px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            display: block;
            margin: 20px auto 0 auto;
        }
        .btn-concordar:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<div class="termo-container">
    <a href="novo_usuario.php" class="fechar" title="Fechar">&times;</a>

    <h2>Termo de Consentimento para Tratamento de Dados – LGPD</h2>

    <p>
        Ao submeter esse formulário, declaro que li e entendi que o tratamento de dados pessoais será realizado
        nos termos da Política de Privacidade do Sistema de Gerenciamento de Projetos (SGP), em conformidade com a
        Lei Geral de Proteção de Dados (Lei nº 13.709/2018).
    </p>

    <p>
        Autorizo de forma expressa e inequívoca que meus dados pessoais, fornecidos neste formulário, sejam coletados,
        tratados e armazenados com a finalidade de viabilizar minha participação e acesso às funcionalidades oferecidas
        pelo SGP.
    </p>

    <p>
        Estou ciente de que:
        <ul>
            <li>Meus dados serão utilizados exclusivamente para fins relacionados à operação e melhoria do sistema.</li>
            <li>Tenho o direito de solicitar a correção, exclusão ou restrição do uso dos meus dados pessoais a qualquer momento.</li>
            <li>O SGP adota medidas de segurança adequadas para proteger minhas informações pessoais contra acessos não autorizados, perda ou alteração.</li>
        </ul>
    </p>

    <p>
        Declaro, portanto, estar de acordo com os termos aqui descritos, consentindo com o uso dos meus dados pessoais conforme especificado.
    </p>

    <form action="novo_usuario.php" method="get">
        <button type="submit" class="btn-concordar">Li e concordo</button>
    </form>
</div>

</body>
</html>
