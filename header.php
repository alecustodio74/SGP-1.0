<?php
//vamos utilizar este cabeçalho de página (header) para todas as páginas.
session_start();
    if(!$_SESSION['acesso']){ //não permite acessar a página pela sua url sem estar logado
        header("location: index.php?mensagem=acesso_negado"); //direciona para novo login
    }
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Alexandre Ricardo Custódio de Souza">
  
    <!-- <title>Cabeçalho de Menu</title> usamos em cada página o cabeçalho de cada uma-->
  
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  
    <!-- colocar aqui o cdn do sweet alert -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.5/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.5/dist/sweetalert2.all.min.js"></script>

    <!-- O link abaixo datatables usa codigo javascrip para carregar tabelas aos poucos -->
    <link href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css" rel="stylesheet">
</head>
<body>   
    <nav class="navbar  navbar-expand-lg navbar-dark" style="background-color: #083b6e;">
      <div class="container-fluid">
        <a class="navbar-brand" href="principal.php"><img src="img/Logo_SGP_dado.png" style="width: 5%; padding: 0; ">Sistema de Gerenciamento de Projetos 1.0</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">

        <div class="d-flex">
          <ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 100px;">
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Cadastro</a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="clientes.php">Clientes</a></li>
                <li><a class="dropdown-item" href="membros.php">Membros</a></li>
                <li><a class="dropdown-item" href="projetos.php">Projetos</a></li>
                <li><a class="dropdown-item" href="tarefas.php">Tarefas</a></li>
                <li><a class="dropdown-item" href="cargos.php">Cargos</a></li>
              </ul>
            </li>
          </ul>
        </div>

          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link" href="atividades.php">Atividades</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="dashboard.php">Dashboard</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="relatorio.php">Relatório</a>
            </li>
          </ul>
           
        <div class="d-flex">
          <ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 100px;">
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <?= $_SESSION['usuario'] ?>
              </a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="alterar_dados.php">Alterar Dados</a></li>
                <li><a class="dropdown-item" href="sobre.php">Sobre</a></li>
                <li><a class="dropdown-item btn btn-danger" href="sair.php" id="logoutButton">Sair</a></li>
              </ul>
            </li>
          </ul>
        </div>
  
  </nav>

<main class="container">