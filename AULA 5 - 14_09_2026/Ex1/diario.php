<?php

$arquivo = "diario.md";

// Verifica se o arquivo existe
if (file_exists($arquivo)) {

    // Lê todo o conteúdo do arquivo
    $conteudo = file_get_contents($arquivo);

} else {

    $conteudo = "";

}

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meu Diário</title>
    <link rel="stylesheet" href="estilo.css">
</head>

<body>

    <div class="container">

        <h1>📖 Meu Diário</h1>

        <nav>
            <a href="adicionar.php">Adicionar entrada</a>
            <a href="diario.php">Ver diário</a>
        </nav>

        <section class="diario">

            <?php if (!empty($conteudo)): ?>

                <pre><?php echo htmlspecialchars($conteudo); ?></pre>

            <?php else: ?>

                <p>Seu diário ainda está vazio.</p>

            <?php endif; ?>

        </section>

    </div>

</body>
</html>
