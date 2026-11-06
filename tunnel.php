<?php

header('Content-Type: application/json; charset=utf-8');

$secretKey = '0x4AAAAAAEOCjnJccxO0x6FMINu_P0N0CKM';

$token = $_POST['cf-turnstile-response'] ?? '';

if ($token === '') {
    http_response_code(400);

    echo json_encode([
        'success' => false,
        'error' => 'Missing Turnstile token'
    ]);

    exit;
}

$ch = curl_init('https://challenges.cloudflare.com/turnstile/v0/siteverify');

curl_setopt_array($ch, [
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => http_build_query([
        'secret'   => $secretKey,
        'response' => $token,
        'remoteip' => $_SERVER['REMOTE_ADDR'] ?? ''
    ]),
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_TIMEOUT => 10
]);

$response = curl_exec($ch);

if ($response === false) {
    curl_close($ch);

    http_response_code(500);

    echo json_encode([
        'success' => false,
        'error' => 'Verification service unavailable'
    ]);

    exit;
}

curl_close($ch);

$result = json_decode($response, true);

if (!empty($result['success'])) {

    echo json_encode([
        'success' => true
    ]);

    exit;
}

http_response_code(403);

echo json_encode([
    'success' => false,
    'error' => 'Turnstile verification failed'
]);

exit;