<?php
require_once("header.php"); //chama o cabeçalho da página
//require_once é mais seguro que o include pois se der erro com o include_once, 
// ele continua a rodar a página mesmo mostrando os erros
  //session_start(); aqui comentado pq inicializei a sessão lá no topo
  //echo "<h3> Usuário ".$_SESSION['usuario']." </h3>";
  ?>
  
    <head>
    <title>Página principal</title>
  </head>
  
  <body>
    <p></p>
    <h4>Página principal</h4>
    <figure>
        <img src="https://kinsta.com/wp-content/uploads/2022/09/computer-and-code-used-by-developers.jpg" alt="Imagem de um computador de um desenvolvedor" style="width: 50%; margin: auto; margin-top: 10%; display: flex; border-radius: 2%;">
   </figure>

    <!-- o arquivo termina o código html no footer.php -->

<?php
  require_once("footer.php"); //chama o rodapé da página com o script
?>