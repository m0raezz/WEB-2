<?php
$servidor = "localhost";
$usuario = "root";
$senha = "";
$banco = "barrefilmes";
$conexao = new PDO("mysql:host=$servidor;dbname=$banco;charset=utf8mb4", $usuario, $senha);
?>
