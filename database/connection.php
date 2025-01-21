<?php
error_reporting( E_ALL & ~ E_NOTICE & ~ E_DEPRECATED );

$host = 'localhost';
$user = 'root';
$pass = '166';
$db = 'previsaoTempo';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    echo "Conexão com o MySQL estabelecida com sucesso!";
} catch (PDOException $e) {
    die("Erro: " . $e->getMessage());
}
