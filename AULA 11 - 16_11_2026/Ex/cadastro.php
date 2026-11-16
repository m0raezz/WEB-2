<?php
$titulo = "Cadastro de usuário";
require('topo.php');
?>
    <h1>Cadastro de usuário</h1>

    <!-- $_POST[] -->
    <form action="salva_usuario.php" method="post" class="caixa">
        <label for="nome">Nome:</label>
        <input type="text" name="nome" id="nome" maxlength="200" required>

        <label for="email">E-mail:</label>
        <input type="email" name="email" id="email" maxlength="200" required>

        <label for="nascimento">Data de nascimento:</label>
        <input type="date" name="nascimento" id="nascimento" max="<?= date('Y-m-d') ?>" required>

        <label for="senha">Senha:</label>
        <input type="password" name="senha" id="senha" required>

        <input type="submit" value="Cadastrar">
    </form>
<?php require('rodape.php'); ?>
