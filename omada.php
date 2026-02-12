<?php

function omadaLogin($url, $user, $pass) {

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "$url/api/v2/login");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS,
        json_encode([
            "username" => $user,
            "password" => $pass
        ])
    );
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json'
    ]);

    $response = curl_exec($ch);
    curl_close($ch);

    return $response;
}
?>
