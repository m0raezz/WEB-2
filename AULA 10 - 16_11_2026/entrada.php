
<?php
require('conexao.php');

$email = $_POST['email'] ?? '';
$senha = $_POST['senha'] ?? '';

$comando = "SELECT id, nome FROM usuarios WHERE email = ? AND senha = ?";

$stm = $conexao->prepare($comando);
$stm->execute([$email, $senha]);

$resultado = $stm->fetch(PDO::FETCH_ASSOC);

if ($resultado) {
    $_SESSION['id'] = $resultado['id'];
    $_SESSION['nome'] = $resultado['nome'];

    header('Location: ofertas.php');
    exit;
} else {
    echo "Usuário ou senha incorretos!";
    echo "<a href='login.php'>Fazer login</a>";
}
?>
