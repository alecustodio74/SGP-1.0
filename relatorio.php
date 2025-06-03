<?php
    require_once("header.php");

function retornaUsuariosComCargo() {
    require("conexao.php");
    try {
        $sql = "SELECT u.id, u.nome, u.salario, c.nome AS nome_cargo, c.id AS cargo_id
                FROM usuarios u
                INNER JOIN cargo c ON u.cargo_id = c.id
                ORDER BY c.nome, u.nome";
        $stmt = $pdo->query($sql);
        return $stmt->fetchAll();
    } catch (Exception $e) {
        die("Erro ao consultar os usuários: " . $e->getMessage());
    }
}

$usuarios = retornaUsuariosComCargo();

// Processamento dos dados:
$totalUsuarios = count($usuarios);
$totalSalario = 0;
$cargos = [];

foreach ($usuarios as $u) {
    $salario = $u['salario'];
    $cargo = $u['nome_cargo'];

    $totalSalario += $salario;

    if (!isset($cargos[$cargo])) {
        $cargos[$cargo] = [
            'quantidade' => 0,
            'salario_total' => 0
        ];
    }

    $cargos[$cargo]['quantidade']++;
    $cargos[$cargo]['salario_total'] += $salario;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Relatório de Colaboradores</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
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

        @media print {
            .no-print {
                display: none !important;
            }

            html, body {
                margin: 0;
                padding: 0;
                width: 100%;
            }

            @page {
                margin: 10mm 10mm;
            }

            /* Forçar largura total nas tabelas e contêineres na impressão */
            body > * {
                width: 100% !important;
                max-width: 100% !important;
                margin: 0 !important;
                padding: 0 !important;
                box-sizing: border-box;
            }

            .tabela, 
            .resumo table {
                width: 100% !important;
                max-width: 100% !important;
                margin: 0;
                padding: 0;
                border-collapse: collapse;
            }

            .tabela th, .tabela td, 
            .resumo th, .resumo td {
                box-sizing: border-box;
                border: 1px solid #000 !important;
            }

            .tabela th, .resumo th {
                background-color: #f0f0f0 !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }

        .titulo {
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .tabela {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        .tabela th, .tabela td {
            border: 1px solid #000;
            padding: 6px 10px;
            text-align: left;
            box-sizing: border-box;
        }

        .tabela th {
            background-color: #f0f0f0;
        }

        .largura-nome {
            width: 40%;
        }

        .salario-direita {
            text-align: right;
            white-space: nowrap;
            display: inline-block;
            min-width: 100px;
            box-sizing: border-box;
        }

        .centro {
            text-align: center;
        }

        .resumo {
            margin-top: 20px;
        }

        .resumo h4 {
            margin-bottom: 10px;
        }

        .resumo table {
            width: 100%;
            border-collapse: collapse;
        }

        .resumo th, .resumo td {
            border: 1px solid #999;
            padding: 6px 8px;
            box-sizing: border-box;
        }

        .resumo th {
            background-color: #e8e8e8;
        }

        .porcentagem-direita {
            text-align: right;
            white-space: nowrap;
            min-width: 90px;
        }
    </style>
</head>
<body>

    <button class="print-button no-print" onclick="window.print()">Imprimir / Salvar como PDF</button>
    <div class="titulo">Relatório de Colaboradores</div>
    <div class="row">
        <div class="col">Data: <?= date('d/m/Y'); ?></div>
    </div>

    <!-- TABELA PRINCIPAL -->
    <table class="tabela">
        <thead>
            <tr>
                <th>ID</th>
                <th class="largura-nome">Nome</th>
                <th>Salário</th>
                <th>Cargo</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($usuarios as $u): ?>
            <tr>
                <td><?= $u['id'] ?></td>
                <td><?= htmlspecialchars($u['nome']) ?></td>
                <td><span class="salario-direita">R$ <?= number_format($u['salario'], 2, ',', '.') ?></span></td>
                <td><?= htmlspecialchars($u['nome_cargo']) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- RESUMO -->
    <div class="resumo">
        <h4>Resumo Geral</h4>
        <p><strong>Total de Usuários:</strong> <?= $totalUsuarios ?></p>
        <p><strong>Soma Total de Salários:</strong> <span class="salario-direita">R$ <?= number_format($totalSalario, 2, ',', '.') ?></span></p>

        <h4>Salários por Cargos</h4>
        <table>
            <thead>
                <tr>
                    <th>Cargo</th>
                    <th>Qtde. Funcionários</th>
                    <th>Total em Salários</th>
                    <th>% do Total Geral</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cargos as $cargo => $dados): 
                    $percentual = ($dados['salario_total'] / $totalSalario) * 100;
                ?>
                <tr>
                    <td><?= htmlspecialchars($cargo) ?></td>
                    <td class="centro"><?= $dados['quantidade'] ?></td>
                    <td><span class="salario-direita">R$ <?= number_format($dados['salario_total'], 2, ',', '.') ?></span></td>
                    <td class="porcentagem-direita"><?= number_format($percentual, 1, ',', '.') ?>%</td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script>
        window.addEventListener('beforeprint', () => console.log("Preparando para impressão..."));
        window.addEventListener('afterprint', () => console.log("Impressão concluída"));
    </script>

<?php
    require_once("footer.php");
?>
