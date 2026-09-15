<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $titulo = $_POST["titulo"];
    $texto = $_POST["texto"];

    if (!empty($titulo) && !empty($texto)) {

        $data = date("d/m/Y H:i");

        $entrada = "\n## $titulo\n";
        $entrada .= "*$data*\n\n";
        $entrada .= "$texto\n\n";
        $entrada .= "---\n";

        $arquivo = fopen("diario.md", "a");
        fwrite($arquivo, $entrada);
        fclose($arquivo);

        echo "Entrada salva com sucesso!";

    } else {

        echo "Preencha todos os campos.";

    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Meu Diário</title>
</head>

<body>

<h1>Meu Diário</h1>

<form method="post">

    Título:
    <input type="text" name="titulo">

    <br><br>

    Texto:
    <br>
    <textarea name="texto" rows="10" cols="40"></textarea>

    <br><br>

    <input type="submit" value="Salvar">

</form>

</body>
</html>
