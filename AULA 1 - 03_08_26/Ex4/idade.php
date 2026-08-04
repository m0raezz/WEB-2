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
 
    
    if($idade >= 18){
        echo "Você é maior de idade! :D";
    }else{
        echo "Você não é maior de idade! :C";
    }
    
    
    ?>
</body>

</html>