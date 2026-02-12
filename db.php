<?php

$host = "localhost";
$user = "root";
$pass = "";
$db = "sva";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Erro conexão banco");
}

?>
