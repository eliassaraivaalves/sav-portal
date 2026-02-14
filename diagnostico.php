<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h2>INICIANDO DIAGNÓSTICO</h2>";

define('OMADA_URL', 'https://10.5.0.20:8043');
define('CLIENT_ID', '289cf1b8313b42a29d6c868a94732415');
define('CLIENT_SECRET', '8fed75756f6c4ea9bb126ef972accd3e');
define('OMADA_ID', '0a98965885f4db539c6d058a3edf47e5');
define('SITE_ID', 'HRVJ');

function prepararCurl($url){
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    return $ch;
}

echo "<hr><b>1 - TESTANDO CURL</b><br>";

if(!function_exists('curl_init')){
    die("❌ CURL NÃO ESTÁ ATIVADO NO PHP");
}

echo "✅ CURL OK<br>";

echo "<hr><b>2 - TESTANDO CONEXÃO COM OMADA</b><br>";

$ch = prepararCurl(OMADA_URL);
$response = curl_exec($ch);

if($response === false){
    die("❌ ERRO AO CONECTAR NO OMADA: " . curl_error($ch));
}

echo "✅ SERVIDOR OMADA RESPONDE<br>";
curl_close($ch);

echo "<hr><b>3 - PEGANDO TOKEN</b><br>";

$url = OMADA_URL . "/openapi/authorize/token";

$data = [
    "client_id" => CLIENT_ID,
    "client_secret" => CLIENT_SECRET,
    "grant_type" => "client_credentials"
];

$ch = prepararCurl($url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

$response = curl_exec($ch);

$result = json_decode($response, true);

if(!isset($result['access_token'])){
    echo "<pre>";
    print_r($result);
    die("❌ NÃO CONSEGUIU PEGAR TOKEN");
}

$token = $result['access_token'];

echo "✅ TOKEN RECEBIDO<br>";
curl_close($ch);

echo "<hr><b>4 - CRIANDO VOUCHER TESTE</b><br>";

$url = OMADA_URL . "/openapi/v1/".OMADA_ID."/sites/".SITE_ID."/hotspot/vouchers";

$data = [
    "count" => 1,
    "validityTime" => 5,
    "maxClient" => 1
];

$headers = [
    "Authorization: Bearer $token",
    "Content-Type: application/json"
];

$ch = prepararCurl($url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$response = curl_exec($ch);

echo "<pre>";
print_r(json_decode($response, true));
echo "</pre>";

echo "<br>✅ DIAGNÓSTICO FINALIZADO";
