<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "psab";

try {
    $conn = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    date_default_timezone_set('America/Sao_Paulo');
} catch (PDOException $e) {
    echo "Erro ao cenectar: " . $e->getMessage();
}