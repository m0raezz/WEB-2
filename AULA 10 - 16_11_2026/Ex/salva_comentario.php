<?php
require('conexao.php');

session_start();

$id_oferta = (int) ($_POST['id_oferta'] ?? 0);
$comentario = trim($_POST['comentario'] ?? '');

if (!isset($_SESSION['id'])) {
    $mensagem = "Você precisa estar logado para comentar.";
} elseif ($comentario == '') {
    $mensagem = "Escreva um comentário.";
} else {
    // Confere se a oferta existe
    $stm = $conexao->prepare("SELECT `id` FROM `ofertas` WHERE `id` = ?");
    $stm->execute([$id_oferta]);

    if (!$stm->fetch(PDO::FETCH_ASSOC)) {
        $mensagem = "Oferta não encontrada.";
    } else {
        $comando = "INSERT INTO `comentarios` (`id`, `id_usuario`, `id_oferta`, `comentario`) VALUES (NULL, ?, ?, ?)";

        $stm = $conexao->prepare($comando);
        $stm->execute([$_SESSION['id'], $id_oferta, $comentario]);

        if ($stm->rowCount() > 0) {
            // Comentário salvo: volta para a página da oferta
            header("Location: detalhe_oferta.php?id=$id_oferta");
            exit;
        } else {
            $mensagem = "Erro ao salvar o comentário.";
        }
    }
}

$titulo = "Comentário";

?>
    <p class="aviso"><?= $mensagem ?></p>
<?php if (isset($_SESSION['id'])) { ?>
    <a href="detalhe_oferta.php?id=<?= $id_oferta ?>">Voltar para a oferta</a>
<?php } else { ?>
    <a href="login.php">Fazer login</a>
<?php } ?>
