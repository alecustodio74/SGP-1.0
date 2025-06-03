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
      
    <figure>
        <img src="img/Logo_SGP_dado.png" alt="Imagem de um computador de um desenvolvedor" style="width: 45%; margin: auto; display: flex;">
   </figure>

    <!-- o arquivo termina o código html no footer.php -->

<?php
  require_once("footer.php"); //chama o rodapé da página com o script
?>