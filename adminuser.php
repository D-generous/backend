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

if (!isset($_COOKIE['adminjwt'])) {
    http_response_code(401);
    echo json_encode(['message'=>'Authorized, no token provided']);
}

$jwt = $_COOKIE['adminjwt'];


try{

    $decoded = JWT::decode($jwt, new Key($secretKey, 'HS256'));

    $voterid = $decoded->user_id;

    $query = "SELECT * FROM `adminusers` WHERE id='$voterid'";
    $con = $database_con->query($query);

    if ($con->num_rows>0) {
        $user = $con->fetch_assoc();
        $adminname = $user['fullname'];
        // $result = [
        //     'message'=
        // ]
        echo json_encode($adminname);
    }
}catch(Exception $e){
    http_response_code(401);
    echo json_encode(['message'=>'Unauthorized, invalid token']);
}

?>