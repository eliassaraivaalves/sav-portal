<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$url = "https://10.5.0.20:8043/0a98965885f4db539c6d058a3edf47e5/openapi/authorize/token";

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// 🔥 DESATIVA VERIFICAÇÃO SSL
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
    "grant_type" => "client_credentials",
    "client_id" => "859ee53945344ca0a61f3feb9f6cf0e2",
    "client_secret" => "72efa96f5bde4f0babc3edf31db6a777"
]));

$response = curl_exec($ch);

if($response === false){
    echo "Erro CURL: " . curl_error($ch);
}

curl_close($ch);

echo "<pre>";
var_dump($response);
echo "</pre>";
