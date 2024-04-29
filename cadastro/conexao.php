<?php

$host = 'localhost';
$db = 'Delta';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

// DSN (Data Source Name)
$dsn = "mysql:host=$host; dbname=$db;charset=$charset"; // sintaxe do PDO 

try{ // se tiver erro no comando do banco de dados irá ler o catch
$pdo = new PDO($dsn, $user, $pass);
} catch(PDOException $e){ // A classe PDOException é uma subclasse da classe Exception que é usada para representar exceções específicas relacionadas a erros de banco de dados quando você está trabalhando com o PDO
    echo "Erro ao tentar conectar com o banco de dados <p>" . $e;
}
?>