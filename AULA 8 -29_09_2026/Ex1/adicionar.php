<?php

$nome = $_POST['nome'];
$tarefa = $_POST['tarefa'];

$arquivo = $nome . ".md";

$conteudo = "□ " . $tarefa . PHP_EOL;

file_put_contents($arquivo, $conteudo, FILE_APPEND);

echo "Tarefa adicionada com sucesso!";

echo "<br><br>";
echo "<a href='index.php'>Voltar</a>";
?>
