<?php
// Aprova ou recusa uma solicitação de amizade.
// Aprovar: tira da tabela pendente e salva na tabela amigos.
// Recusar: só tira da tabela pendente.
require('conexao.php');

session_start();

$id_pendente = (int) ($_POST['id'] ?? 0);
$acao = $_POST['acao'] ?? '';

if (!isset($_SESSION['id_usuario'])) {
    $mensagem = "Você precisa estar logado para responder uma solicitação.";
} else {
    $id = $_SESSION['id_usuario'];

    // Só quem recebeu a solicitação (id_amigo) pode aprovar ou recusar
    $stm = $conexao->prepare("SELECT `id_usuario` FROM `pendente` WHERE `id` = ? AND `id_amigo` = ?");
    $stm->execute([$id_pendente, $id]);

    $pendente = $stm->fetch(PDO::FETCH_ASSOC);

    if (!$pendente) {
        $mensagem = "Solicitação não encontrada.";
    } elseif ($acao != 'aprovar' && $acao != 'recusar') {
        $mensagem = "Ação inválida.";
    } else {
        if ($acao == 'aprovar') {
            // Salva a amizade nos dois sentidos: eu -> ele e ele -> eu
            $comando = "INSERT INTO `amigos` (`id`, `id_usuario`, `id_amigo`) VALUES (NULL, ?, ?), (NULL, ?, ?)";

            $stm = $conexao->prepare($comando);
            $stm->execute([$id, $pendente['id_usuario'], $pendente['id_usuario'], $id]);
        }

        // Nos dois casos a solicitação deixa de ser pendente
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
<?php require('rodape.php'); ?>
