<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php

    $juros = $_GET['juros'] / 100;
    $capital = $_GET['capital'];
    $tempo = $_GET['tempo'];
    
        echo "Valor investido: " . $capital;
        echo "<br>";
        echo "A uma taxa de " . $juros*100 . "% no tempo de $tempo meses";
        echo "<br>";
        echo "Seu Juros será: " . $juros*$capital*$tempo;
        echo "<br>";
        echo "E seu valor total ao fim do periodo será: " . $capital + ($juros*$capital*$tempo);
    
    
    ?>
</body>

</html>