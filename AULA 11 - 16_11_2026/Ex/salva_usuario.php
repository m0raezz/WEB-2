<?php
require('conexao.php');

$nome = trim($_POST['nome'] ?? '');
$email = trim($_POST['email'] ?? '');
$nascimento = $_POST['nascimento'] ?? '';
$senha = $_POST['senha'] ?? '';

$sucesso = false;


$data = DateTime::createFromFormat('Y-m-d', $nascimento);

if ($nome == '' || $email == '' || $nascimento == '' || $senha == '') {
    $mensagem = "Preencha todos os campos.";
} elseif (!$data || $data->format('Y-m-d') != $nascimento || $data > new DateTime()) {
    $mensagem = "Data de nascimento inválida.";
} else {

    $stm = $conexao->prepare("SELECT `id` FROM `usuarios` WHERE `email` = ?");
    $stm->execute([$email]);

    if ($stm->fetch(PDO::FETCH_ASSOC)) {
        $mensagem = "Este e-mail já está cadastrado.";
    } else {

        $senha_hash = hash("sha256", $senha);

        $comando = "INSERT INTO `usuarios` (`id`, `nome`, `email`, `nascimento`, `senha`) VALUES (NULL, ?, ?, ?, ?)";

        $stm = $conexao->prepare($comando);
        $stm->execute([$nome, $email, $nascimento, $senha_hash]);

        if ($stm->rowCount() > 0) {
            $sucesso = true;
            $mensagem = "Usuário cadastrado com sucesso!";
        } else {
            $mensagem = "Erro no cadastro.";
        }
    }
}

$titulo = "Cadastro de usuário";
require('topo.php');

?>
    <p class="aviso"><?= $mensagem ?></p>
<?php if ($sucesso) { ?>
    <a href="login.php">Fazer login</a>
<?php } else { ?>
    <a href="cadastro.php">Voltar ao cadastro</a>
<?php } ?>

