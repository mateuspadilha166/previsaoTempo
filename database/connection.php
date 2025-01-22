<?php
//DEBUG para reportar o erro do pdo_mysql, obrigado youtube
error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);

// Carregar configurações do config.php
$config = require __DIR__ . '/config.php';

$host = $config['db']['host'];
$user = $config['db']['user'];
$pass = $config['db']['password'];
$db = $config['db']['dbname'];
$charset = $config['db']['charset'];

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=$charset", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //echo "Conexão com o banco de dados estabelecida com sucesso!";
} catch (PDOException $e) {
    die("Erro ao conectar ao banco de dados: " . $e->getMessage());
}
