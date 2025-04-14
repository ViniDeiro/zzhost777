<?php

date_default_timezone_set("America/Sao_Paulo");
define('SITE_URL', 'https://' . $_SERVER['HTTP_HOST']);

$bd = array(
    'local' => '127.0.0.1',
    'usuario' => 'chinav2',
    'senha' => 'chinav2chinav2',
    'banco' => 'chinav2'
);

// Conexão MySQLi
$mysqli = new mysqli($bd['local'], $bd['usuario'], $bd['senha'], $bd['banco']);
if ($mysqli->connect_errno) {
    die("Erro ao conectar com MySQLi: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error);
}
$mysqli->set_charset("utf8");

// Conexão PDO
try {
    $pdo = new PDO("mysql:host={$bd['local']};dbname={$bd['banco']};charset=utf8", $bd['usuario'], $bd['senha']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro ao conectar com PDO: " . $e->getMessage());
}
