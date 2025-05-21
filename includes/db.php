<?php
// Configurações do banco de dados
$host = 'localhost';      // Ou o IP do servidor
$dbname = 'convite_romantico';
$username = 'root';       // Usuário do MySQL
$password = '';           // Senha do MySQL (vazia se local)

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro ao conectar ao banco de dados: " . $e->getMessage());
}
