<?php
require_once "config.php";

// Conectar banco
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

$nome = $_POST['nome'];
$email = $_POST['email'];
$telefone = $_POST['telefone'];
$mac = $_POST['mac'];
$ip = $_POST['ip'];

// Salvar no banco
$stmt = $conn->prepare("INSERT INTO usuarios_wifi (nome,email,telefone,mac,ip) VALUES (?,?,?,?,?)");
$stmt->bind_param("sssss",$nome,$email,$telefone,$mac,$ip);
$stmt->execute();

// Autenticar no Omada
require "omada.php";

autenticarCliente($mac);

echo "Internet liberada com sucesso!";
