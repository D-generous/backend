<?php

require 'database_con.php';

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type');
header("Content-Type: application/json");

ini_set('display_errors', 1);
error_reporting(E_ALL);

$input = json_decode(file_get_contents('php://input'));

$name = $input->name;
$statecode = $input->statecode;
$email = $input->email;
$password = $input->password;

$hashedpass = password_hash($password, PASSWORD_DEFAULT);
// echo json_encode([$name, $statecode, $email, $password]);

$query = "SELECT `code` FROM `acceptedadmin` WHERE code='$statecode'";
$con = $database_con->query($query);

if ($con->num_rows > 0) {

    $query2 = "SELECT * FROM `adminusers` WHERE statecode='$statecode'";
    $connn = $database_con->query($query2);
    if ($connn->num_rows > 0) {
        echo json_encode("You won't be able to register twice! One of your details already exist in our database");
    } else {
        $query3 = "SELECT * FROM `adminusers` WHERE email='$email'";
        $connnn = $database_con->query($query3);
        if ($connnn->num_rows>0) {
            echo json_encode("You won't be able to register twice! One of your details already exist in our database");
        }else{
            // echo json_encode("Welcome mr man");

            $insertquery = "INSERT INTO `adminusers` (`fullname`, `statecode`, `email`, `password`) VALUES ('$name', '$statecode', '$email', '$hashedpass')";
            $conn = $database_con->query($insertquery);
            if ($conn) {
                $result = [
                    'status'=>true,
                    'message'=>'Successfully inserted'
                ];
                echo json_encode($result);
            }
            else{
                $result = [
                    'status'=>false,
                    'message'=>'An error occurred while adding the entry.'
                ];
                echo json_encode($result);
    
            }
        }

    }
} else {
    echo json_encode("Mr man I don't recognize you. You do not qualify to be an admin!!!");
}
