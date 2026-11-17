<?php
require('conexao.php');

$email = $_POST['email'] ?? '';
$senha = $_POST['senha'] ?? '';


$senha_hash = hash("sha256", $senha);

$comando = "SELECT `id`, `nome`, `nascimento` FROM `usuarios` WHERE `email` = ? AND `senha` = ?";

$stm = $conexao->prepare($comando);
$stm->execute([$email, $senha_hash]);

$resultado = $stm->fetch(PDO::FETCH_ASSOC);

if (isset($resultado['id'])) {

    $nascimento = new DateTime($resultado['nascimento']);
    $hoje = new DateTime();
    $idade = $nascimento->diff($hoje)->y;


    session_start();
    $_SESSION['id_usuario'] = $resultado['id'];
    $_SESSION['nome'] = $resultado['nome'];
    $_SESSION['idade'] = $idade;

    header('Location: filmes.php');
    exit;
}

$titulo = "Login";
require('topo.php');

?>
    <p class="aviso">E-mail ou senha incorretos!</p>
    <a href="login.php">Fazer login</a>

