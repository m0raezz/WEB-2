<?php
$titulo = "Login";
require('topo.php');
?>
    <h1>Login</h1>

    <!-- $_POST[] -->
    <form action="entrada.php" method="post" class="caixa">
        <label for="email">E-mail:</label>
        <input type="email" name="email" id="email" required>

        <label for="senha">Senha:</label>
        <input type="password" name="senha" id="senha" required>

        <input type="submit" value="Entrar">
    </form>

    <p>Ainda não tem conta? <a href="cadastro.php">Cadastre-se</a></p>
<?php require('rodape.php'); ?>
