<?php
    declare(strict_types=1);

    $dominio = 'mysql:host=localhost;dbname=sgp'; 
    $usuario = 'root';
    $senha = '123456'; //usuario e senha no MySQL Workbank ou outro banco como o Xampp

    try{
        $pdo = new PDO($dominio, $usuario, $senha); //intancia o banco de dados
    } catch (PDOException $e) {
        die("Erro ao conectar com o banco!" .$e->getMessage());
    }
?>
