<?php require_once("header.php"); ?>

<?php
function retornaUsuarios() {
    require("conexao.php");
    try {
        $sql = "SELECT nome, salario FROM usuarios WHERE salario IS NOT NULL";
        $stmt = $pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        die("Erro ao consultar os usuários: " . $e->getMessage());
    }
}

$usuarios = retornaUsuarios();
?>
<title>Dashboard Colaboradores</title>
<h4>Salários dos Colaboradores</h4>

<?php if (count($usuarios) === 0): ?>
    <div class="alert alert-warning">Nenhum usuário com salário encontrado.</div>
<?php else: ?>

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <div id="chart_div" style="width: 100%; height: 500px;"></div>

    <script>
    google.charts.load('current', { packages: ['corechart'] });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        const data = new google.visualization.DataTable();
        data.addColumn('string', 'Usuário');
        data.addColumn('number', 'Salário');
        data.addColumn({ type: 'string', role: 'annotation' }); // valor visível dentro da barra
        data.addColumn({ type: 'string', role: 'style' }); // cor da barra

        const rows = [
            <?php
            $cores = ['#3366cc', '#dc3912', '#ff9900', '#109618', '#990099', '#0099c6', '#dd4477', '#66aa00', '#b82e2e', '#316395'];
            $i = 0;
            foreach ($usuarios as $u):
                $nome = addslashes($u['nome']);
                $salario = (float) $u['salario'];
                $salarioFormatado = 'R$ ' . number_format($salario, 2, ',', '.');
                $cor = $cores[$i % count($cores)];
                echo "['$nome', $salario, '$salarioFormatado', 'color: $cor'],\n";
                $i++;
            endforeach;
            ?>
        ];

        data.addRows(rows);

        const options = {
            title: 'Salários dos Colaboradores',
            legend: 'none',
            chartArea: { width: '60%', height: '70%' },
            hAxis: {
                title: 'Salários',
                minValue: 0
            },
            vAxis: {
                title: 'Colaboradores'
            },
            annotations: {
                textStyle: {
                    fontSize: 12,
                    color: '#fff', // branco para melhor contraste dentro da barra
                    auraColor: 'none'
                }
            }
        };

        const chart = new google.visualization.BarChart(document.getElementById('chart_div'));
        chart.draw(data, options);
    }
    </script>

<?php endif; ?>

<?php require_once("footer.php"); ?>
