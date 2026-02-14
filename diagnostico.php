<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h2>INICIANDO DIAGNÓSTICO</h2>";

$baseUrl = "https://10.5.0.20:8043";
$clientId = "289cf1b8313b42a29d6c868a94732415";
$clientSecret = "8fed75756f6c4ea9bb126ef972accd3e";
$omadaId = "0a98965885f4db539c6d058a3edf47e5";

function curlBase($url){
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    return $ch;
}

echo "<hr><b>1 - TESTANDO SERVIDOR</b><br>";

$ch = curlBase($baseUrl);
$response = curl_exec($ch);

if($response === false){
    die("ERRO CONEXÃO: " . curl_error($ch));
}

echo "✅ SERVIDOR OK<br>";
curl_close($ch);

echo "<hr><b>2 - SOLICITANDO TOKEN</b><br>";

$tokenUrl = $baseUrl . "/openapi/authorize/token?grant_type=client_credentials&omadaId=".$omadaId;

$ch = curlBase($tokenUrl);

curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
    "client_id" => $clientId,
    "client_secret" => $clientSecret
]));

curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Content-Type: application/x-www-form-urlencoded"
]);

$response = curl_exec($ch);

if($response === false){
    die("ERRO TOKEN: " . curl_error($ch));
}

echo "<pre>";
print_r(json_decode($response, true));
echo "</pre>";

curl_close($ch);
