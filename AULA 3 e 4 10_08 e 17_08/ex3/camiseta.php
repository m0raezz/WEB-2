<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

    <?php 
    
        $tipo = $_GET['tipo'];
        $tamanho = $_GET['tamanho'];
        $valor = 0;
        
        
        if($tipo == 'Masculino'){
            $valor += 30;
        }else{
            $valor += 25;
        }


        switch($tamanho){

            case "P": echo "<h1> Preço Uni: " . $valor -=5; break;
            case "M": echo "<h1> Preço Uni: " . $valor +=1; break;
            case "G": echo "<h1> Preço Uni: " . $valor +=10; break;




        }
    
    
    
    ?>

    
</body>
</html>