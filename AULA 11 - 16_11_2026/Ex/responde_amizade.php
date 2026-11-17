<?php

require('conexao.php');

session_start();

$id_pendente = (int) ($_POST['id'] ?? 0);
$acao = $_POST['acao'] ?? '';

if (!isset($_SESSION['id_usuario'])) {
    $mensagem = "Você precisa estar logado para responder uma solicitação.";
} else {
    $id = $_SESSION['id_usuario'];


    $stm = $conexao->prepare("SELECT `id_usuario` FROM `pendente` WHERE `id` = ? AND `id_amigo` = ?");
    $stm->execute([$id_pendente, $id]);

    $pendente = $stm->fetch(PDO::FETCH_ASSOC);

    if (!$pendente) {
        $mensagem = "Solicitação não encontrada.";
    } elseif ($acao != 'aprovar' && $acao != 'recusar') {
        $mensagem = "Ação inválida.";
    } else {
        if ($acao == 'aprovar') {

            $comando = "INSERT INTO `amigos` (`id`, `id_usuario`, `id_amigo`) VALUES (NULL, ?, ?), (NULL, ?, ?)";

            $stm = $conexao->prepare($comando);
            $stm->execute([$id, $pendente['id_usuario'], $pendente['id_usuario'], $id]);
        }


        $stm = $conexao->prepare("DELETE FROM `pendente` WHERE `id` = ?");
        $stm->execute([$id_pendente]);

        header('Location: amigos.php');
        exit;
    }
}

$titulo = "Responder solicitação";
require('topo.php');

?>
    <p class="aviso"><?= $mensagem ?></p>
<?php if (isset($_SESSION['id_usuario'])) { ?>
    <a href="amigos.php">Voltar para amigos</a>
<?php } else { ?>
    <a href="login.php">Fazer login</a>
<?php } ?>

