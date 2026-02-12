<?php

include 'config.php';
include 'db.php';
include 'omada.php';

$nome = $_POST['nome'];
$cpf = $_POST['cpf'];
$mac = $_POST['mac'];
$ip = $_POST['ip'];

/* 1️⃣ Login na API */
$login = omadaLogin($omada_url, $omada_user, $omada_pass);

/* 2️⃣ Gerar voucher via API */
/* aqui vamos implementar chamada específica */

/* Exemplo temporário */
$voucher = rand(100000,999999);

/* 3️⃣ Salvar no banco */

$stmt = $conn->prepare("INSERT INTO acessos (nome, cpf, voucher, ip_cliente, mac_cliente)
VALUES (?, ?, ?, ?, ?)");

$stmt->bind_param("sssss", $nome, $cpf, $voucher, $ip, $mac);
$stmt->execute();

/* 4️⃣ Redirecionar para autenticação */

header("Location: $omada_url/portal/auth?username=$voucher");

?>
