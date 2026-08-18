<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        $cor = $_GET['cor'];
        $texto = $_GET['text'];
        $fundo = $_GET['fundo'];


            echo "<body style = 'background-color: $fundo;'>";
            echo "<p style = 'color: $cor;'>$texto</p>";
            echo "</body>";
    
    
    
    ?>
    
</body>
</html>