<?php
require 'config.php';

// PEGAR DADOS
$nome = $_POST['nome'];
$cpf = $_POST['cpf'];
$clientMac = $_POST['clientMac'];
$aceite = isset($_POST['lgpd']) ? 1 : 0;
$ipCliente = $_SERVER['REMOTE_ADDR'];

// CONEXÃO BANCO
$pdo = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASS);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// ===============================
// 1 - PEGAR TOKEN OMADA
// ===============================
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

    $result = json_decode($response, true);

    return $result['access_token'];
}

$token = getToken();

// ===============================
// 2 - CRIAR VOUCHER
// ===============================
function criarVoucher($token) {

    $url = OMADA_URL . "/openapi/v1/".OMADA_ID."/sites/".SITE_ID."/hotspot/vouchers";

    $data = [
        "count" => 1,
        "validityTime" => 1440,
        "maxClient" => 1
    ];

    $headers = [
        "Authorization: Bearer $token",
        "Content-Type: application/json"
    ];

    $ch = curl_init($url);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    $response = curl_exec($ch);
    curl_close($ch);

    return json_decode($response, true);
}

$voucherData = criarVoucher($token);
$voucherCode = $voucherData['result'][0]['code'] ?? null;

if(!$voucherCode){
    die("Erro ao criar voucher");
}

// ===============================
// 3 - AUTORIZAR CLIENTE
// ===============================
$url = OMADA_URL . "/openapi/v1/".OMADA_ID."/sites/".SITE_ID."/hotspot/auth";

$data = [
    "mac" => $clientMac,
    "voucherCode" => $voucherCode
];

$headers = [
    "Authorization: Bearer $token",
    "Content-Type: application/json"
];

$ch = curl_init($url);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

$response = curl_exec($ch);
curl_close($ch);

// ===============================
// 4 - SALVAR NO BANCO
// ===============================
$stmt = $pdo->prepare("INSERT INTO acessos_wifi 
(nome, cpf, mac, voucher, ip_cliente, aceite_lgpd) 
VALUES (?, ?, ?, ?, ?, ?)");

$stmt->execute([
    $nome,
    $cpf,
    $clientMac,
    $voucherCode,
    $ipCliente,
    $aceite
]);

// REDIRECIONAR
echo "<h2>Conectado com sucesso!</h2>";
?>
