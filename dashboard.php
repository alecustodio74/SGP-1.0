<?php
    require_once("header.php");
?>

<?php
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

<h2>Dashboard</h2>
<a href="relatorio.php" class="btn btn-success mb-3" target="_blank">Relatório de Produtos</a>

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<!-- gstatc é a biblioteca do google que contém os tipos de gráfico -->
    <div id="chart_div"></div>
    <script>
    google.charts.load('current', {packages: ['corechart', 'bar']});
    google.charts.setOnLoadCallback(drawBasic); //carrega os gráficos do google

    function drawBasic() {

    var data = google.visualization.arrayToDataTable([
        ['Produto', 'Preço'],
          <?php
                foreach($produtos as $p){
                    $nome = $p['nome'];
                    $preco = $p['preco'];
                    echo "['$nome', $preco],";
                }
            ?>
    ]);

    var options = {
        title: 'Preço dos produtos',
        chartArea: {width: '50%', height: '60%'},
        hAxis: { //hAxix é o eixo horizontal
        title: 'Preço',
        minValue: 0
    },
    vAxis: { //vAxis é o eixo vertical
        title: 'Nome do Produto'
        }
    };

    var chart = new google.visualization.BarChart(document.getElementById('chart_div'));

    chart.draw(data, options);
    }
    </script>

<?php
    require_once("footer.php");
