<?php
    $quantidade = $_GET['quant'];
    $preco = $_GET['preco'];

    echo "Preço por uni. : $preco";
    echo "<br>";
    echo "Quantidade : $quantidade";
    echo "<br>";
    echo 'Preço Total: ' . $preco * $quantidade;
?>