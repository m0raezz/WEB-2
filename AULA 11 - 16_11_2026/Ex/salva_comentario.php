<?php
require('conexao.php');

session_start();

$id_filme = (int) ($_POST['id_filme'] ?? 0);
$comentario = trim($_POST['comentario'] ?? '');

if (!isset($_SESSION['id_usuario'])) {
    $mensagem = "Você precisa estar logado para comentar.";
} elseif ($comentario == '') {
    $mensagem = "Escreva um comentário.";
} else {
    $id = $_SESSION['id_usuario'];


    $stm = $conexao->prepare("SELECT `id_usuario` FROM `filmes` WHERE `id` = ?");
    $stm->execute([$id_filme]);

    $filme = $stm->fetch(PDO::FETCH_ASSOC);

    if (!$filme) {
        $mensagem = "Filme não encontrado.";
    } else {

        $stm = $conexao->prepare("SELECT `id` FROM `amigos` WHERE `id_usuario` = ? AND `id_amigo` = ?");
        $stm->execute([$id, $filme['id_usuario']]);

        if (!$stm->fetch(PDO::FETCH_ASSOC)) {
            $mensagem = "Você só pode comentar em filmes cadastrados por amigos.";
        } else {
            $comando = "INSERT INTO `comentarios` (`id`, `id_usuario`, `id_filme`, `comentario`) VALUES (NULL, ?, ?, ?)";

            $stm = $conexao->prepare($comando);
            $stm->execute([$id, $id_filme, $comentario]);

            if ($stm->rowCount() > 0) {

                header("Location: detalhe_filme.php?id=$id_filme");
                exit;
            } else {
                $mensagem = "Erro ao salvar o comentário.";
            }
        }
    }
}

$titulo = "Comentário";
require('topo.php');

?>
    <p class="aviso"><?= $mensagem ?></p>
<?php if (isset($_SESSION['id_usuario'])) { ?>
    <a href="detalhe_filme.php?id=<?= $id_filme ?>">Voltar para o filme</a>
<?php } else { ?>
    <a href="login.php">Fazer login</a>
<?php } ?>

