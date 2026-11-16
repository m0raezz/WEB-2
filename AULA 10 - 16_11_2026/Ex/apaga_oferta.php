<?php
// Exercício da aula 10: apagar oferta.
require('conexao.php');

session_start();

$id = (int) ($_POST['id'] ?? 0);

if (!isset($_SESSION['id'])) {
    $mensagem = "Você precisa estar logado para apagar uma oferta.";
} else {
    // Busca a oferta para saber de quem é
    $stm = $conexao->prepare("SELECT `id_usuario` FROM `ofertas` WHERE `id` = ?");
    $stm->execute([$id]);

    $oferta = $stm->fetch(PDO::FETCH_ASSOC);

    if (!$oferta) {
        $mensagem = "Oferta não encontrada.";
    } elseif ($oferta['id_usuario'] != $_SESSION['id']) {
        $mensagem = "Você só pode apagar as suas próprias ofertas.";
    } else {
        // Primeiro apaga os comentários da oferta, depois a oferta
        $stm = $conexao->prepare("DELETE FROM `comentarios` WHERE `id_oferta` = ?");
        $stm->execute([$id]);

        $stm = $conexao->prepare("DELETE FROM `ofertas` WHERE `id` = ?");
        $stm->execute([$id]);

        // Oferta apagada: volta para a lista
        header('Location: ofertas.php');
        exit;
    }
}

$titulo = "Apagar oferta";

?>
    <p class="aviso"><?= $mensagem ?></p>
    <a href="ofertas.php">Voltar para as ofertas</a>

