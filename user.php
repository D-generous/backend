<?php
require 'database_con.php';
require 'vendor/autoload.php';
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
header('Access-Control-Allow-Origin: http://localhost:4200');
header('Access-Control-Allow-Credentials: true');
header('Content-Type: application/json');
header('Access-Control-Allow-Headers: Content-Type');

$secretKey = "your_secret_key";

if ($_SERVER['REQUEST_METHOD'] === 'GET') {

// Check if JWT is set in the cookiey
if (!isset($_COOKIE['jwt'])) {
    http_response_code(401);
    echo json_encode(['message' => 'Unauthorized, no token provided']);
    exit();
}

$jwt = $_COOKIE['jwt'];

try {
    // Decode the JWT
    $decoded = JWT::decode($jwt, new Key($secretKey, 'HS256'));

    $voterid = $decoded->user_id;

    $query = "SELECT * FROM `voters` WHERE id = '$voterid'";
    $con = $database_con->query($query);
    
    if ($con->num_rows>0) {
        $user = $con->fetch_assoc();
        $fullname = $user['fullname'];
        $statecode = $user['statecode'];

        $result = [
            'fullname'=>$fullname,
            'statecode'=>$statecode,
        ];
        echo json_encode($result);
        
    }
} catch (Exception $e) {
    http_response_code(401);
    echo json_encode(['message' => 'Unauthorized, invalid token']);
}

}

?>