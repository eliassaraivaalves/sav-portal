<?php
$clientMac = $_GET['clientMac'] ?? '';
?>
<!DOCTYPE html>
<html>
<head>
    <title>WiFi HRVJ</title>
</head>
<body>

<h2>Acesso WiFi HRVJ</h2>

<form method="POST" action="processa.php">
    
    <input type="hidden" name="clientMac" value="<?php echo $clientMac; ?>">

    Nome:<br>
    <input type="text" name="nome" required><br><br>

    CPF:<br>
    <input type="text" name="cpf" required><br><br>

    <input type="checkbox" name="lgpd" required>
    Aceito os termos conforme LGPD<br><br>

    <button type="submit">Conectar</button>

</form>

</body>
</html>
