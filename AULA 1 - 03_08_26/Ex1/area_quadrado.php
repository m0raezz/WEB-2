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
    echo "A area do quadrado com lados valendo <b>$x</b> é <b>" . ($x ** 2) . "</b>";

    ?>
</body>

</html>