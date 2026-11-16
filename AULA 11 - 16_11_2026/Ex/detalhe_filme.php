<?php
require('conexao.php');

$titulo = "Detalhe do filme";
require('topo.php');

$i = (int) ($_GET['id'] ?? 0);

// Busca o filme e o nome de quem cadastrou
$comando = "SELECT `filmes`.*, `usuarios`.`nome` AS `nome_usuario`
            FROM `filmes`
            LEFT JOIN `usuarios` ON `usuarios`.`id` = `filmes`.`id_usuario`
            WHERE `filmes`.`id` = ?";

$stm = $conexao->prepare($comando);
$stm->execute([$i]);

$filme = $stm->fetch(PDO::FETCH_ASSOC);

if (!$filme) {
    echo "<p class='aviso'>Filme não encontrado.</p>";
    echo "<a href='filmes.php'>Voltar para os filmes</a>";
    require('rodape.php');
    exit;
}

// id do usuário logado (0 se ninguém estiver logado)
$logado = $_SESSION['id_usuario'] ?? 0;

// O filme é meu?
$dono = ($logado == $filme['id_usuario']);

// Quem cadastrou o filme é meu amigo?
$stm = $conexao->prepare("SELECT `id` FROM `amigos` WHERE `id_usuario` = ? AND `id_amigo` = ?");
$stm->execute([$logado, $filme['id_usuario']]);
$amigo = (bool) $stm->fetch(PDO::FETCH_ASSOC);

// Quantidade de curtidas do filme
$stm = $conexao->prepare("SELECT COUNT(*) FROM `curtidas` WHERE `id_filme` = ?");
$stm->execute([$i]);
$curtidas = $stm->fetchColumn();

// Eu já curti este filme?
$stm = $conexao->prepare("SELECT `id` FROM `curtidas` WHERE `id_filme` = ? AND `id_usuario` = ?");
$stm->execute([$i, $logado]);
$curti = (bool) $stm->fetch(PDO::FETCH_ASSOC);

// Classificação 0 aparece como L
$classificacao = $filme['classificacao'] == 0 ? "L (livre)" : $filme['classificacao'] . " anos";

$nome_usuario = htmlspecialchars($filme['nome_usuario'] ?? 'usuário removido');
?>
    <div class="detalhe">
        <img src="<?= htmlspecialchars($filme['foto']) ?>" alt="Foto do filme">
        <h1><?= htmlspecialchars($filme['nome']) ?></h1>
        <p><?= htmlspecialchars($filme['descricao']) ?></p>
        <p>Classificação indicativa: <strong><?= $classificacao ?></strong></p>
        <p>Nota de <?= $nome_usuario ?>: <strong><?= $filme['nota_usuario'] ?>/10</strong></p>
        <p>Sugerido por: <?= $nome_usuario ?></p>
        <a href="<?= htmlspecialchars($filme['link']) ?>" target="_blank">Ver o filme</a>

        <h3>Curtidas: <?= $curtidas ?></h3>

<?php if ($logado) { ?>
        <!-- O mesmo botão curte e descurte -->
        <form action="curtir.php" method="post">
            <input type="hidden" name="id_filme" value="<?= $filme['id'] ?>">
            <button type="submit"><?= $curti ? "Descurtir" : "Curtir" ?></button>
        </form>
<?php } else { ?>
        <p><a href="login.php">Faça login</a> para curtir.</p>
<?php } ?>
    </div>

    <h2>Comentários</h2>

<?php
if (!$logado) {
    echo "<p><a href='login.php'>Faça login</a> para ver e escrever comentários.</p>";
} elseif (!$amigo && !$dono) {
    // Comentários só aparecem (e só podem ser escritos) em filmes de amigos
    echo "<p class='aviso'>Só amigos de $nome_usuario podem ver e escrever comentários neste filme. ";
    echo "<a href='amigos.php'>Solicitar amizade</a></p>";
} else {
    if ($amigo) {
?>
    <form action="salva_comentario.php" method="post" class="caixa">
        <input type="hidden" name="id_filme" value="<?= $filme['id'] ?>">
        <label for="comentario">Seu comentário:</label>
        <textarea name="comentario" id="comentario" rows="3" maxlength="300" required></textarea>
        <input type="submit" value="Comentar">
    </form>
    <br>
<?php
    } else {
        echo "<p>Este filme é seu. Veja abaixo o que seus amigos comentaram.</p>";
    }

    // Comentários do filme, os últimos primeiro
    $comando = "SELECT `comentarios`.*, `usuarios`.`nome` AS `nome_usuario`
                FROM `comentarios`
                LEFT JOIN `usuarios` ON `usuarios`.`id` = `comentarios`.`id_usuario`
                WHERE `comentarios`.`id_filme` = ?
                ORDER BY `comentarios`.`id` DESC";

    $stm = $conexao->prepare($comando);
    $stm->execute([$i]);

    $quantidade = 0;

    while ($c = $stm->fetch(PDO::FETCH_ASSOC)) {
        $quantidade++;
?>
    <div class="comentario">
        <strong><?= htmlspecialchars($c['nome_usuario'] ?? 'usuário removido') ?></strong>
        <p><?= nl2br(htmlspecialchars($c['comentario'])) ?></p>
    </div>
<?php
    }

    if ($quantidade == 0) {
        echo "<p>Nenhum comentário ainda.</p>";
    }
}

require('rodape.php');
?>
