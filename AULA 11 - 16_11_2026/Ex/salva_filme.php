<?php
require('conexao.php');

session_start();

if (!isset($_SESSION['id_usuario'])) {
    $mensagem = "Você precisa estar logado para cadastrar um filme.";
} else {
    $id = $_SESSION['id_usuario'];
    $idade = $_SESSION['idade'];

    $n = trim($_POST['nome'] ?? '');
    $d = trim($_POST['desc'] ?? '');
    $l = trim($_POST['link'] ?? '');
    $c = $_POST['classificacao'] ?? '';
    $nota = $_POST['nota'] ?? '';

    $nome_original = $_FILES['foto']['name'] ?? '';
    $nome_tmp = $_FILES['foto']['tmp_name'] ?? '';

    // Só aceita arquivo de imagem (não deixa subir um .php, por exemplo)
    $extensao = strtolower(pathinfo($nome_original, PATHINFO_EXTENSION));
    $permitidas = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

    if ($n == '' || $d == '' || $l == '' || $c == '' || $nota == '') {
        $mensagem = "Preencha todos os campos.";
    } elseif (!ctype_digit($c) || $c > 18) {
        $mensagem = "A classificação deve ser um número de 0 a 18 (para L digite 0).";
    } elseif ($c > $idade) {
        // Regra da aula: não pode cadastrar filme com classificação maior que a idade
        $mensagem = "Você tem $idade anos e não pode cadastrar um filme com classificação de $c anos.";
    } elseif (!ctype_digit($nota) || $nota > 10) {
        $mensagem = "A nota deve ser um número de 0 a 10.";
    } elseif (!preg_match('/^https?:\/\//i', $l)) {
        $mensagem = "O link deve começar com http:// ou https://";
    } elseif ($nome_tmp == '' || !in_array($extensao, $permitidas)) {
        $mensagem = "Envie uma foto (jpg, jpeg, png, gif ou webp).";
    } else {
        if (!is_dir('imagens')) {
            mkdir('imagens');
        }

        // uniqid() na frente do nome para uma foto não sobrescrever outra com o mesmo nome
        $nome_limpo = preg_replace('/[^A-Za-z0-9._-]/', '_', basename($nome_original));
        $destino = "imagens/" . uniqid() . "_" . $nome_limpo;

        if (move_uploaded_file($nome_tmp, $destino)) {
            $f = $destino;

            $comando = "INSERT INTO `filmes` (`id`, `id_usuario`, `nome`, `descricao`, `foto`, `link`, `classificacao`, `nota_usuario`) VALUES (NULL, ?, ?, ?, ?, ?, ?, ?)";

            $stm = $conexao->prepare($comando);
            $stm->execute([$id, $n, $d, $f, $l, $c, $nota]);

            if ($stm->rowCount() > 0) {
                // Filme cadastrado: mostra a página dele
                header('Location: detalhe_filme.php?id=' . $conexao->lastInsertId());
                exit;
            } else {
                $mensagem = "Erro no cadastro do filme.";
            }
        } else {
            $mensagem = "Erro ao salvar a foto.";
        }
    }
}

$titulo = "Novo filme";
require('topo.php');
?>
    <p class="aviso"><?= htmlspecialchars($mensagem) ?></p>
<?php if (isset($_SESSION['id_usuario'])) { ?>
    <a href="novo_filme.php">Voltar</a>
<?php } else { ?>
    <a href="login.php">Fazer login</a>
<?php } ?>
<?php require('rodape.php'); ?>
