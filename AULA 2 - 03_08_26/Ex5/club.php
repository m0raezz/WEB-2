<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php

    $idade = $_GET['idade'];
    $membro = $_GET['membro'];
    $convite = $_GET['convite'];


    if($idade >= 18){
        if($convite == "Sim" || $membro == "Sim"){
            echo "Entrada Permitida";
        }
        else{
            echo "Entrada Negada";    
        }
    }
    else{
        echo "Entrada Negada";
    }
    
    ?>
</body>

</html>