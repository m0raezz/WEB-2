<?php

require('conexao.php');

session_start();

$id_filme = (int) ($_POST['id_filme'] ?? 0);

if (!isset($_SESSION['id_usuario'])) {
    $mensagem = "Você precisa estar logado para curtir um filme.";
} else {
    $id = $_SESSION['id_usuario'];

    // Confere se o filme existe
    $stm = $conexao->prepare("SELECT `id` FROM `filmes` WHERE `id` = ?");
    $stm->execute([$id_filme]);

    if (!$stm->fetch(PDO::FETCH_ASSOC)) {
        $mensagem = "Filme não encontrado.";
    } else {
        // Já curti este filme?
        $stm = $conexao->prepare("SELECT `id` FROM `curtidas` WHERE `id_usuario` = ? AND `id_filme` = ?");
        $stm->execute([$id, $id_filme]);

        if ($stm->fetch(PDO::FETCH_ASSOC)) {
            $comando = "DELETE FROM `curtidas` WHERE `id_usuario` = ? AND `id_filme` = ?";
        } else {
            $comando = "INSERT INTO `curtidas` (`id`, `id_usuario`, `id_filme`) VALUES (NULL, ?, ?)";
        }

        $stm = $conexao->prepare($comando);
        $stm->execute([$id, $id_filme]);

        header("Location: detalhe_filme.php?id=$id_filme");
        exit;
    }
}

$titulo = "Curtir";
require('topo.php');
?>
    <p class="aviso"><?= $mensagem ?></p>
<?php if (isset($_SESSION['id_usuario'])) { ?>
    <a href="filmes.php">Voltar para os filmes</a>
<?php } else { ?>
    <a href="login.php">Fazer login</a>
<?php } ?>
<?php require('rodape.php'); ?>
