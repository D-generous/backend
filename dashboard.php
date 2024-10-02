<?php
require 'database_con.php';
require 'vendor/autoload.php';
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
header('Access-Control-Allow-Origin: http://localhost:4200');
header('Access-Control-Allow-Credentials: true');
header('Content-Type: application/json');
header('Access-Control-Allow-Headers: Content-Type');
// header("Content-Type: application/json");



ini_set('display_errors', 1);
error_reporting(E_ALL);

$secretKey = "your_secret_key";

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
   
    $query = "SELECT * FROM `candidates`";
    $con = $database_con->query($query);
    
    if ($con->num_rows>0) {
        $users = $con->fetch_all(MYSQLI_ASSOC);
        // echo json_encode($users);
        $result = [];
    
        foreach ($users as $user) {
            # code...
            $id = $user['id'];
            $fullname = $user['fullname'];
            $profile_picture = $user['profile_picture'];
            $statecode = $user['statecode'];
    
            $result [] = [
                'id'=> $id,
                'candidate'=> $fullname,
            ];
        }
        echo json_encode($result);
    }
    
    # code...
}

else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'));

$president = $input->president;
$vice_president = $input->vice_president;
$gensecretary = $input->gensecretary;
$assgensecretary = $input->assgensecretary;
$fin_secretary = $input->fin_secretary;
$electoralofficer1 = $input->electoralofficer1;
$electoralofficer2 = $input->electoralofficer2;
$profficer = $input->profficer;
$projectmanager = $input->projectmanager;
$welfareofficer = $input->welfareofficer;
$votercode = $input->votercode;

$electionstatus = "SELECT * FROM `control_flags` WHERE id = 1";
$statcon = $database_con->query($electionstatus);

if ($statcon->num_rows>0) {
    $stat = $statcon->fetch_assoc();

    if ($stat['election_started']==0) {
        $result = [
            'message'=>"You won't be able to vote at the moment"
        ];
        echo json_encode($result);
    }
    else{
        // echo json_encode("start");
        $checkvoterexistence = "SELECT * FROM `ballots` WHERE votercode = '$votercode'";
        $votercon = $database_con->query($checkvoterexistence);
        if ($votercon->num_rows>0) {
            // $voter = $votercon->fetch_all(MYSQLI_ASSOC);
            // echo json_encode($voter);
            $result = [
                'message'=>"You won't be able to vote twice!"
            ];
        
            echo json_encode($result);
        }else{
            $query2 = "INSERT INTO `ballots` (`votercode`, `president`, `vice_president`, `gensecretary`, `assgensecretary`, `fin_secretary`, `electoralofficer1`, `electoralofficer2`, `profficer`, `projectmanager`, `welfareofficer`) VALUES ('$votercode', '$president','$vice_president', '$gensecretary', '$assgensecretary', '$fin_secretary', '$electoralofficer1', '$electoralofficer2', '$profficer', '$projectmanager', '$welfareofficer')";
            
            $con2 = $database_con->query($query2);
            
            if ($con2) {
            
                $result = [
                    'status'=>true,
                    'message'=>'Inserted'
                ];
                echo json_encode($result);
                
            }else{
                
                $result = [
                    'status'=>false,
                    'message'=>'Not Inserted'
                ];
                echo json_encode($result);
            }
        }



    }
    
}



}




