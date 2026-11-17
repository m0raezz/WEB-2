<?php
$titulo = "Novo filme";



if (!isset($_SESSION['id_usuario'])) {
?>
    <p class="aviso">Você precisa estar logado para cadastrar um filme.</p>
    <a href="login.php">Fazer login</a>
<?php
} else {

    $maximo = min(18, $_SESSION['idade']);
?>
    <h1>Novo filme</h1>


    <form action="salva_filme.php" method="post" enctype="multipart/form-data" class="caixa">
        <label for="nome">Nome do filme:</label>
        <input type="text" name="nome" id="nome" maxlength="200" required>

        <label for="desc">Descrição:</label>
        <input type="text" name="desc" id="desc" maxlength="300" required>

        <label for="foto">Foto:</label>
        <input type="file" name="foto" id="foto" accept="image/*" required>

        <label for="link">Link:</label>
        <input type="text" name="link" id="link" maxlength="200" placeholder="https://..." required>

        <label for="classificacao">Classificação indicativa (em anos):</label>
        <input type="number" name="classificacao" id="classificacao" min="0" max="<?= $maximo ?>" required>
        <small>Para classificação L (livre) digite 0. Você tem <?= $_SESSION['idade'] ?> anos, então pode cadastrar filmes de até <?= $maximo ?> anos.</small>

        <label for="nota">Sua nota (0 a 10):</label>
        <input type="number" name="nota" id="nota" min="0" max="10" required>

        <input type="submit" value="Cadastrar filme">
    </form>
<?php
}


?>
