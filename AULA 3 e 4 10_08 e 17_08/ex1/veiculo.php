<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php 
    
        $vei = $_GET['vi'];
        $vei = strtolower(trim($vei));

        switch($vei){

        case "carro":
            echo "<img src='imagens\carro.png' alt=''>";
            break;
        
        case "moto":
            echo "<img src='imagens\moto.png' alt=''>";
            break;

        case "bike":
            echo "<img src='imagens\bike.png' alt=''>";
            break;

        default :
            echo "<img src='imagens\pé.png' alt=''>";
            break;
        }
    
    ?>    


</body>
</html>