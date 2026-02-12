<!DOCTYPE html>
<html>
<head>
    <title>Wi-Fi HRVJ</title>
</head>
<body>

<h2>Conecte-se ao Wi-Fi</h2>

<form action="salvar.php" method="POST">
    Nome:<br>
    <input type="text" name="nome" required><br><br>

    Email:<br>
    <input type="email" name="email" required><br><br>

    Telefone:<br>
    <input type="text" name="telefone" required><br><br>

    <input type="hidden" name="mac" value="<?php echo $_GET['clientMac'] ?? ''; ?>">
    <input type="hidden" name="ip" value="<?php echo $_GET['clientIp'] ?? ''; ?>">

    <button type="submit">Conectar</button>
</form>

</body>
</html>
