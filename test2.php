<?php

header('Access-Control-Allow-Origin: http://localhost:61164');
header('Access-Control-Allow-Credentials: true');
header('Content-Type: application/json');

$secretKey = "your_secret_key";

// Check if JWT is set in the cookie
if (!isset($_COOKIE['jwt'])) {
    http_response_code(401);
    echo json_encode(['message' => 'Unauthorized, no token provided']);
    exit();
}


?>
