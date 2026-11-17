
<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require('conexao.php');

$titulo = "Amigos";

// Verifica se o usuário está logado
if (!isset($_SESSION['id_usuario']) || empty($_SESSION['id_usuario'])) {
    echo "<p class='aviso'>Você precisa estar logado para ver seus amigos.</p>";
    echo "<a href='login.php'>Fazer login</a>";
    exit;
}

$id = $_SESSION['id_usuario'];

echo "<h1>Amigos</h1>";

// SOLICITAÇÕES RECEBIDAS
$comando = "SELECT pendente.id, usuarios.nome
            FROM pendente
            JOIN usuarios ON usuarios.id = pendente.id_usuario
            WHERE pendente.id_amigo = ?
            ORDER BY pendente.id DESC";

$stm = $conexao->prepare($comando);
$stm->execute([$id]);

echo "<h2>Solicitações recebidas</h2>";

$quantidade = 0;

while ($p = $stm->fetch(PDO::FETCH_ASSOC)) {
    $quantidade++;
    ?>
    <div class="pessoa">
        <span><?= htmlspecialchars($p['nome']) ?> quer ser seu amigo(a)</span>

        <form action="responde_amizade.php" method="post">
            <input type="hidden" name="id" value="<?= $p['id'] ?>">
            <button type="submit" name="acao" value="aprovar" class="pequeno">Aprovar</button>
            <button type="submit" name="acao" value="recusar" class="pequeno recusar">Recusar</button>
        </form>
    </div>
    <?php
}

if ($quantidade == 0) {
    echo "<p>Nenhuma solicitação para aprovar.</p>";
}

// MEUS AMIGOS
$comando = "SELECT usuarios.id, usuarios.nome
            FROM amigos
            JOIN usuarios ON usuarios.id = amigos.id_amigo
            WHERE amigos.id_usuario = ?
            ORDER BY usuarios.nome";

$stm = $conexao->prepare($comando);
$stm->execute([$id]);

echo "<h2>Meus amigos</h2>";

$quantidade = 0;

while ($a = $stm->fetch(PDO::FETCH_ASSOC)) {
    $quantidade++;
    echo "<div class='pessoa'><span>" . htmlspecialchars($a['nome']) . "</span></div>";
}

if ($quantidade == 0) {
    echo "<p>Você ainda não tem amigos.</p>";
}

// SOLICITAÇÕES ENVIADAS
$comando = "SELECT usuarios.nome
            FROM pendente
            JOIN usuarios ON usuarios.id = pendente.id_amigo
            WHERE pendente.id_usuario = ?
            ORDER BY pendente.id DESC";

$stm = $conexao->prepare($comando);
$stm->execute([$id]);

echo "<h2>Solicitações enviadas</h2>";

$quantidade = 0;

while ($p = $stm->fetch(PDO::FETCH_ASSOC)) {
    $quantidade++;
    echo "<div class='pessoa'><span>" . htmlspecialchars($p['nome']) . " (aguardando aprovação)</span></div>";
}

if ($quantidade == 0) {
    echo "<p>Nenhuma solicitação aguardando aprovação.</p>";
}

// OUTRAS PESSOAS
$comando = "SELECT id, nome FROM usuarios
            WHERE id <> ?
            AND id NOT IN (
                SELECT id_amigo FROM amigos WHERE id_usuario = ?
            )
            AND id NOT IN (
                SELECT id_amigo FROM pendente WHERE id_usuario = ?
            )
            AND id NOT IN (
                SELECT id_usuario FROM pendente WHERE id_amigo = ?
            )
            ORDER BY nome";

$stm = $conexao->prepare($comando);
$stm->execute([$id, $id, $id, $id]);

echo "<h2>Outras pessoas</h2>";

$quantidade = 0;

while ($u = $stm->fetch(PDO::FETCH_ASSOC)) {
    $quantidade++;
    ?>
    <div class="pessoa">
        <span><?= htmlspecialchars($u['nome']) ?></span>

        <form action="solicita_amizade.php" method="post">
            <input type="hidden" name="id_amigo" value="<?= $u['id'] ?>">
            <button type="submit" class="pequeno">Solicitar amizade</button>
        </form>
    </div>
    <?php
}

if ($quantidade == 0) {
    echo "<p>Não há mais ninguém para adicionar.</p>";
}

?>
