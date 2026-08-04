<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php

    $x = $_GET['valor'];
    $idade = 0;

    for ($i = 0; $i < 2027 - $x; $i++) {
        $idade++;
    }

    echo "Sua data de nascimento é <b>$x</b> e sua idade é $idade";

    //Forma alternativa
    //$idade = 2026 - $x;
    //$idade++;
    //echo "Idade: $idade";

    
    ?>
</body>

</html>