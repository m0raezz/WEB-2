<?php
// Exercício da aula 10: apagar comentário.
require('conexao.php');

session_start();

$id = (int) ($_POST['id'] ?? 0);

if (!isset($_SESSION['id'])) {
    $mensagem = "Você precisa estar logado para apagar um comentário.";
} else {
    // Busca o comentário para saber de quem é e de qual oferta
    $stm = $conexao->prepare("SELECT `id_usuario`, `id_oferta` FROM `comentarios` WHERE `id` = ?");
    $stm->execute([$id]);

    $comentario = $stm->fetch(PDO::FETCH_ASSOC);

    if (!$comentario) {
        $mensagem = "Comentário não encontrado.";
    } elseif ($comentario['id_usuario'] != $_SESSION['id']) {
        $mensagem = "Você só pode apagar os seus próprios comentários.";
    } else {
        $stm = $conexao->prepare("DELETE FROM `comentarios` WHERE `id` = ?");
        $stm->execute([$id]);

        // Comentário apagado: volta para a página da oferta
        header("Location: detalhe_oferta.php?id={$comentario['id_oferta']}");
        exit;
    }
}

$titulo = "Apagar comentário";

?>
    <p class="aviso"><?= $mensagem ?></p>
    <a href="ofertas.php">Voltar para as ofertas</a>

