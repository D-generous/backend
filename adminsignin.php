<?php 
require 'database_con.php';
require 'vendor/autoload.php';
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

header('Access-Control-Allow-Origin: http://localhost:4200');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Headers: Content-Type');
header("Content-Type: application/json");

$secretKey = "your_secret_key";

$input= json_decode(file_get_contents('php://input'));
$email = $input->email;
$password = $input->pass;

// echo json_encode([$email, $password]);

$query = "SELECT * FROM `adminusers` WHERE email='$email'";
$con = $database_con->query($query);

if ($con->num_rows>0) {
    $user = $con->fetch_assoc();
    $datapass = $user['password'];
    $statecode = $user['statecode'];

    $verify = password_verify($password, $datapass);
    if ($verify) {
        $payload = [
            'user_id' => $user['id'],
            'username'=> $user['email'],
            'iat'=> time(),
            'exp'=>time() + 600

        ];
        $jwt = JWT::encode($payload, $secretKey, 'HS256');

        setcookie('adminjwt', $jwt, time() + 600, '/', '', true, true);

        echo json_encode(['status'=> true, 'message'=>'Login successful', 'token'=>$jwt]);

        exit();
    }
    else{
        echo json_encode(['status'=> false, 'message' => 'Invalid login details']);

    }

}else{
    echo json_encode("Email not avail");

}

?>