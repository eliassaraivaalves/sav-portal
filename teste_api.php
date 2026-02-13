<?php
require 'config.php';

function getToken() {

    $url = OMADA_URL . "/openapi/authorize/token";

    $data = [
        "client_id" => CLIENT_ID,
        "client_secret" => CLIENT_SECRET,
        "grant_type" => "client_credentials"
    ];

    $ch = curl_init($url);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    $response = curl_exec($ch);
    curl_close($ch);

    return $response;
}

echo "<pre>";
echo getToken();
echo "</pre>";
