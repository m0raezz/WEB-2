<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<form action="camiseta.php" method="get">
    <label for="">TIPO</label>
    <br>
    <label for="">Feminino</label><input type="radio" value="Feminino" name="tipo" id="Feminino"><br>

    <label for="">Masculino</label><input type="radio" value="Masculino" name="tipo" id="Masculino"><br>
    <p></p>
    
    <label for="">TAMANHO</label>
    <br>

        <label for="">P</label><input type="radio" value="P" name="tamanho" id="P"><br>
        <label for="">M</label><input type="radio" value="M" name="tamanho" id="M"><br>
        <label for="">G</label><input type="radio" value="G" name="tamanho" id="G"><br>
    <p></p>

    <input type="number" name="quant" id="" placeholder="Quantidade" max=9 min=1>
    <p></p>
    <input type="reset" value="Limpar"> | <input type="submit" value="Enviar">
</form>
    
</body>
</html>