<?php
$servidor = "localhost";
$usuario = "root";
$senha = "";
$banco = "barrefertas";
session_start();
$conexao = new PDO("mysql:host=$servidor;dbname=$banco", $usuario, $senha);
?>