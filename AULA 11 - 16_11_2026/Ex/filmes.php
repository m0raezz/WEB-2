<?php
require('conexao.php');

$titulo = "Filmes";
require('topo.php');

// Todos os filmes, do mais novo para o mais antigo, já com a quantidade de curtidas
$comando = "SELECT `filmes`.`id`, `filmes`.`nome`, `filmes`.`foto`, `filmes`.`classificacao`, `filmes`.`nota_usuario`,
                   `usuarios`.`nome` AS `nome_usuario`,
                   (SELECT COUNT(*) FROM `curtidas` WHERE `curtidas`.`id_filme` = `filmes`.`id`) AS `curtidas`
            FROM `filmes`
            LEFT JOIN `usuarios` ON `usuarios`.`id` = `filmes`.`id_usuario`
            ORDER BY `filmes`.`id` DESC";

$stm = $conexao->prepare($comando);
$stm->execute();

$quantidade = 0;

echo "<h1>Filmes sugeridos</h1>";
echo "<div class='lista'>";

while ($resultado = $stm->fetch(PDO::FETCH_ASSOC)) {
    $quantidade++;

    $foto = htmlspecialchars($resultado['foto']);
    $nome = htmlspecialchars($resultado['nome']);
    $nome_usuario = htmlspecialchars($resultado['nome_usuario'] ?? 'usuário removido');

    // Classificação 0 aparece como L
    $classificacao = $resultado['classificacao'] == 0 ? "L" : $resultado['classificacao'] . " anos";

    echo "<div class='cartao'>";
    echo "<a href=\"detalhe_filme.php?id={$resultado['id']}\"><img src='$foto' alt='Foto do filme'></a>";
    echo "<h2>$nome</h2>";
    echo "<p>Classificação: $classificacao</p>";
    echo "<p>Nota: {$resultado['nota_usuario']}/10</p>";
    echo "<p>Curtidas: {$resultado['curtidas']}</p>";
    echo "<p>Por: $nome_usuario</p>";
    echo "</div>";
}

echo "</div>";

if ($quantidade == 0) {
    echo "<p>Nenhum filme cadastrado ainda.</p>";
}

require('rodape.php');
?>
