<?php
// Topo usado em todas as páginas: inicia a sessão e mostra o menu.
// Antes de chamar, defina a variável $titulo.
// Na sessão ficam: id_usuario, nome e idade.
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($titulo) ?></title>
    <link rel="stylesheet" href="estilo.css">
</head>
<body>
    <nav>
        <a href="filmes.php">Filmes</a>
<?php if (isset($_SESSION['id_usuario'])) { ?>
        <a href="novo_filme.php">Novo filme</a>
        <a href="amigos.php">Amigos</a>
        <span>Olá, <?= htmlspecialchars($_SESSION['nome']) ?> (<?= $_SESSION['idade'] ?> anos)</span>
        <a href="sair.php">Sair</a>
<?php } else { ?>
        <a href="login.php">Login</a>
        <a href="cadastro.php">Cadastro</a>
<?php } ?>
    </nav>
