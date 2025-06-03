<?php
    require_once("header.php");
?>
<?php
//vamos utilizar este cabeçalho de página (header) para todas as páginas.
//session_start();
//    if(!$_SESSION['acesso']){ //não permite acessar a página pela sua url sem estar logado
//        header("location: index.php?mensagem=acesso_negado"); //direciona para novo login
//   }

    function retornaProdutos(){
    require("conexao.php");
    try{
        //$sql = "SELECT * FROM produto";
        $sql = "SELECT p.*, c.nome as nome_categoria FROM produto p INNER JOIN categoria c ON c.id = p.categoria_id"; 
        //08/05/2025 buscando o produto pelo nome da categoria
        //INNER JOIN: vou pegar todos os dados de uma categoria, especificamente o nome da categoria
        // antes estávamos exibindo apenas o id da categoria
        $stmt = $pdo->query($sql);
        return $stmt->fetchAll(); //retorna todos os dados do banco
    }catch (Exception $e){
        die("Erro ao consultar os produtos: " . $e->getMessage());
    }
  }

  $produtos = retornaProdutos();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Relatório de Produtos</title>
    <style>
        /* Estilo normal (tela) */
        body {
            font-family:Arial, Helvetica, sans-serif;
            font-size: 14px;
            padding: 20px;
        }
        .no-print {
            display: block;
        }
        .print-button {
            background: #4CAF50;
            color: white;
            border: none;
            padding: 10px 15px;
            cursor: pointer;
            border-radius: 4px;
        }

        /* Estilo para impressão */
        @media print { /* media print tira o botão imprimir/salvar na hora de imprimir */
            .no-print {
                display: none !important;
            }
            body {
                font-size: 12px;
                padding: 0;
            }
            .tabela th {
                background-color: #f0f0f0 !important;
                print-color-adjust: exact;
            }
        }

        /* Seu CSS original */
        .titulo { text-align: center; font-size: 18px; font-weight: bold; }
        .tabela { width: 100%; border-collapse: collapse; }
        .tabela th, .tabela td { border: 1px solid #000; padding: 6px 10px; text-align: left; }
        .tabela th { background-color: #f0f0f0; }
    </style>
</head>
<body>

    <!-- Botão para impressão (não aparece no PDF) -->
    <button class="print-button no-print" onclick="window.print()">Imprimir / Salvar como PDF</button>
    <!-- window.print é quem mostra a jánela com as informações para ser impresso -->
    <div class="titulo">Relatório de Produtos</div>
    <div class="row">
        <div class="col">Data: <?php echo date('d/m/Y'); ?></div>
    </div>

    <table class="tabela">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Preço</th>
                <th>Categoria</th>
            </tr>
        </thead>
        <tbody>
            <?php
                foreach($produtos as $p):
            ?>
            <tr>
                <td><?= $p['id'] ?></td>
                <td><?= $p['nome'] ?></td>
                <td>R$<?= $p['preco'] ?></td>
                <td><?= $p['nome_categoria'] ?></td>
            </tr>
            <?php
                endforeach;
            ?>
            <!-- Adicione mais linhas dinamicamente com PHP -->
        </tbody>
    </table>

    <script>
        // Opcional: Configuração para melhor experiência de impressão
        function beforePrint() {
            console.log("Preparando para impressão...");
        }
        function afterPrint() {
            console.log("Impressão concluída");
        }
        window.addEventListener('beforeprint', beforePrint);
        window.addEventListener('afterprint', afterPrint);
    </script>

<?php
    require_once("footer.php");
?>