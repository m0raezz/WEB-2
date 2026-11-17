<?php
require('conexao.php');

session_start();

$id_amigo = (int) ($_POST['id_amigo'] ?? 0);

if (!isset($_SESSION['id_usuario'])) {
    $mensagem = "Você precisa estar logado para solicitar amizade.";
} else {
    $id = $_SESSION['id_usuario'];


    $stm = $conexao->prepare("SELECT `id` FROM `usuarios` WHERE `id` = ?");
    $stm->execute([$id_amigo]);
    $existe = $stm->fetch(PDO::FETCH_ASSOC);


    $stm = $conexao->prepare("SELECT `id` FROM `amigos` WHERE `id_usuario` = ? AND `id_amigo` = ?");
    $stm->execute([$id, $id_amigo]);
    $ja_amigos = $stm->fetch(PDO::FETCH_ASSOC);


    $comando = "SELECT `id` FROM `pendente`
                WHERE (`id_usuario` = ? AND `id_amigo` = ?)
                   OR (`id_usuario` = ? AND `id_amigo` = ?)";
    $stm = $conexao->prepare($comando);
    $stm->execute([$id, $id_amigo, $id_amigo, $id]);
    $ja_pendente = $stm->fetch(PDO::FETCH_ASSOC);

    if ($id_amigo == $id) {
        $mensagem = "Você não pode solicitar amizade para você mesmo.";
    } elseif (!$existe) {
        $mensagem = "Usuário não encontrado.";
    } elseif ($ja_amigos) {
        $mensagem = "Vocês já são amigos.";
    } elseif ($ja_pendente) {
        $mensagem = "Já existe uma solicitação pendente entre vocês.";
    } else {
        $comando = "INSERT INTO `pendente` (`id`, `id_usuario`, `id_amigo`) VALUES (NULL, ?, ?)";

        $stm = $conexao->prepare($comando);
        $stm->execute([$id, $id_amigo]);

        header('Location: amigos.php');
        exit;
    }
}

$titulo = "Solicitar amizade";
require('topo.php');
?>
    <p class="aviso"><?= $mensagem ?></p>
<?php if (isset($_SESSION['id_usuario'])) { ?>
    <a href="amigos.php">Voltar para amigos</a>
<?php } else { ?>
    <a href="login.php">Fazer login</a>
<?php } ?>
<?php require('rodape.php'); ?>
