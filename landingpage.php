<?php
require 'database_con.php';
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type');
header("Content-Type: application/json");

$query = "SELECT * FROM `candidates`";
$con = $database_con->query($query);
if ($con->num_rows>0) {

    $result=[];
    $users = $con->fetch_all(MYSQLI_ASSOC);

    foreach ($users as $user) {
        $fullname = $user['fullname'];
        $profile_picture = $user['profile_picture'];
        $statecode = $user['statecode'];

        $result [] = [
            'fullname' => $fullname,
            'profile_picture' => 'http://localhost/Election/'.$profile_picture,
            'statecode' => $statecode,
        ];
    }

    echo json_encode($result);
}


?>