<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Lista de Tarefas</title>
</head>
<body>

    <h1>Adicionar tarefa</h1>

    <form action="adicionar.php" method="POST">
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" required>

        <br><br>

        <label for="tarefa">Tarefa:</label>
        <input type="text" id="tarefa" name="tarefa" required>

        <br><br>

        <button type="submit">Adicionar tarefa</button>
    </form>

</body>
</html>
