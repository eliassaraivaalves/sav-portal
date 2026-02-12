<?php
require_once "config.php";

function autenticarCliente($mac){

    // Obter token
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, OMADA_URL."/openapi/authorize/token");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
        "grant_type" => "client_credentials",
        "client_id" => CLIENT_ID,
        "client_secret" => CLIENT_SECRET
    ]));
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    $result = curl_exec($ch);
    $json = json_decode($result,true);

    $token = $json["access_token"];

    curl_close($ch);

    // Autorizar cliente
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, OMADA_URL."/openapi/v1/".$GLOBALS['SITE']."/portal/auth");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Authorization: Bearer ".$token,
        "Content-Type: application/json"
    ]);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
        "mac" => $mac
    ]));
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    curl_exec($ch);
    curl_close($ch);
}
