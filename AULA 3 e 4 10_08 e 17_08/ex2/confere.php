<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php 
    
        $password = $_GET['senha'];

        $email = $_GET['email'];
        $email = strtolower(trim($email));

        if($email == 'fulano@email.com'){
            if($password == '1234Thanos'){
                echo "<h1>Acesso permitido!</h1>";
            }else{
                echo "<h1>Acesso Negado(senha errado 👀)</h1>";
            }
        }else{
            echo "<h1>Acesso Negado(email errado 👀)</h1>";
        }
    



    
    
    
    
    ?>

    
</body>
</html>