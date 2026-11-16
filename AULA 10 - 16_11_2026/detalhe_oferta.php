
<?php
require('conexao.php');

$id = (int) ($_GET['id'] ?? 0);
$logado = $_SESSION['id'] ?? 0;

$stm = $conexao->prepare("SELECT ofertas.*, usuarios.nome AS nome_usuario FROM ofertas LEFT JOIN usuarios ON usuarios.id = ofertas.id_usuario WHERE ofertas.id = ?");
$stm->execute([$id]);
$oferta = $stm->fetch(PDO::FETCH_ASSOC);

if (!$oferta) {
    echo "Oferta não encontrada.";
    echo "<a href='ofertas.php'>Voltar para as ofertas</a>";
    require('rodape.php');
    exit;
}
?>

<div>
    <img src="<?= htmlspecialchars($oferta['foto']) ?>" alt="Foto da oferta">
    <h1><?= htmlspecialchars($oferta['nome']) ?></h1>
    <p><?= htmlspecialchars($oferta['descricao']) ?></p>
    <h3><?= htmlspecialchars($oferta['preco']) ?></h3>
    <p>Oferta enviada por: <?= htmlspecialchars($oferta['nome_usuario'] ?? 'Usuário removido') ?></p>
    <a href="<?= htmlspecialchars($oferta['link']) ?>" target="_blank" rel="noopener noreferrer">Comprar</a>

    <?php if ($logado && $logado == $oferta['id_usuario']) { ?>
        <form action="apaga_oferta.php" method="post" onsubmit="return confirm('Apagar esta oferta e todos os comentários dela?')">
            <input type="hidden" name="id" value="<?= $oferta['id'] ?>">
            <button type="submit">Apagar oferta</button>
        </form>
    <?php } ?>
</div>

<h2>Comentários</h2>

<?php if ($logado) { ?>
    <form action="salva_comentario.php" method="post">
        <input type="hidden" name="id_oferta" value="<?= $oferta['id'] ?>">
        <label for="comentario">Seu comentário:</label>
        <textarea name="comentario" id="comentario" maxlength="300" required></textarea>
        <input type="submit" value="Comentar">
    </form>
<?php } else { ?>
    <p><a href="login.php">Faça login</a> para comentar.</p>
<?php } ?>

<?php
$stm = $conexao->prepare("SELECT comentarios.*, usuarios.nome AS nome_usuario FROM comentarios LEFT JOIN usuarios ON usuarios.id = comentarios.id_usuario WHERE comentarios.id_oferta = ? ORDER BY comentarios.id DESC");
$stm->execute([$id]);

$quantidade = 0;

while ($c = $stm->fetch(PDO::FETCH_ASSOC)) {
    $quantidade++;
?>

    <div>
        <strong><?= htmlspecialchars($c['nome_usuario'] ?? 'Usuário removido') ?></strong>
        <p><?= nl2br(htmlspecialchars($c['comentario'])) ?></p>

        <?php if ($logado && $logado == $c['id_usuario']) { ?>
            <form action="apaga_comentario.php" method="post" onsubmit="return confirm('Apagar este comentário?')">
                <input type="hidden" name="id" value="<?= $c['id'] ?>">
                <button type="submit">Apagar</button>
            </form>
        <?php } ?>
    </div>

<?php
}

if ($quantidade == 0) {
    echo "<p>Nenhum comentário ainda.</p>";
}
?>
