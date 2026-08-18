<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<?php

    $noti = isset($_GET['noticias']);
    $promo = isset($_GET['promo']);


    if(!$promo && !$noti){
        echo "ASSINATURA RECUSADA";
    
    }else{

        echo "ASSINATURA ACEITA";
        echo "<br>";
        if($promo){
            echo "<br>";
            echo "PROMOÇÕES: SIM";
        }else{
            echo "<br>";
            echo "PROMOÇÕES: NÃO";
        }
        
        if($noti){
            echo "<br>";
            echo "NOTICIAS: SIM";
        }else{
            echo "<br>";
            echo "NOTICIAS: NÃO";
        }


    }


?>
    
</body>
</html>