<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php

    $velocidade = $_GET['velocidade'];
    $limite = $_GET['limite'];

    if($velocidade > $limite){
        echo"Gerar multa";
    }

    if($velocidade < $limite){
        echo"Direção segura";
    }

    
    ?>
</body>

</html>