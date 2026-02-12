<?php

$conn = new mysqli("localhost", "root", "", "sav");

if ($conn->connect_error) {
    die("Erro: " . $conn->connect_error);
}

echo "Banco conectado com sucesso!";

?>
