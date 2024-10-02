<?php
require 'vendor/autoload.php';
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

header('Access-Control-Allow-Origin: http://localhost:61164'); // Allow the specific origin of your frontend
header('Access-Control-Allow-Credentials: true'); // Allow cookies/auth tokens to be sent
header('Access-Control-Allow-Methods: GET, POST, OPTIONS'); // Allowed request methods
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With'); // Allowed headers
header('Content-Type: application/json');

// Handle preflight request
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Secret key for signing JWT
$secretKey = "your_secret_key";

// Simulate user data
$users = [
    ['id' => 1, 'username' => 'john', 'password' => 'password123'],
    ['id' => 2, 'username' => 'jane', 'password' => 'password456']
];

// Get JSON input from frontend
$data = json_decode(file_get_contents("php://input"), true);
$username = $data['username'];
$password = $data['password'];

// Find user
foreach ($users as $user) {
    if ($user['username'] === $username && $user['password'] === $password) {
        // User authenticated, create JWT
        $payload = [
            'user_id' => $user['id'],
            'username' => $user['username'],
            'iat' => time(),
            'exp' => time() + 3600 // 1-hour expiration
        ];

        $jwt = JWT::encode($payload, $secretKey, 'HS256');

        // Set JWT in HttpOnly cookie
        setcookie('jwt', $jwt, time() + 3600, '/', '', true, true);

        echo json_encode(['message' => 'Login successful', 'token' => $jwt]);
        exit();
    }
}

// If user not found
http_response_code(401);
echo json_encode(['message' => 'Invalid credentials']);
?>
