<?php
    declare(strict_types=1);

    // $dominio: variável que recebe o string de conexão (é um padrão do PHP para
    //conexão com qualquer gerenciador de banco de dados)
    $dominio = 'mysql:host=localhost;dbname=projetophp'; 
    $usuario = 'root';
    $senha = '@Arcs1974'; //usuario e senha no MySQL Workbank ou outro banco como o Xampp

    try{
        $pdo = new PDO($dominio, $usuario, $senha); //intancia o banco de dados
    } catch (PDOException $e) {
        die("Erro ao conectar com banco!" .$e->getMessage());
    }
?>
