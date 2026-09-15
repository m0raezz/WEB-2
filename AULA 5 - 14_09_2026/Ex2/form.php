<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Aluno</title>
</head>
<body>

<form method="get">

    Nome:
    <input type="text" name="nome">
    <br><br>

    Nota 1:
    <input type="number" name="nota1">
    <br><br>

    Nota 2:
    <input type="number" name="nota2">
    <br><br>

    Nota 3:
    <input type="number" name="nota3">
    <br><br>
    <input type="submit" value="Salvar">

</form>
<?php

if (isset($_GET["nome"])) {

    $nome = $_GET["nome"];
    $nota1 = $_GET["nota1"];
    $nota2 = $_GET["nota2"];
    $nota3 = $_GET["nota3"];

    $linha = "$nome;$nota1;$nota2;$nota3\n";

    file_put_contents("notas.txt", $linha, FILE_APPEND);

    echo "Dados salvos!";
}

?>

</body>
</html>
