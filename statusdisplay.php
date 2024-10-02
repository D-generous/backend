<?php
require 'database_con.php';

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Headers: Content-Type');

$query = "SELECT * FROM `control_flags` WHERE id = 1";
$con = $database_con->query($query);
if ($con->num_rows > 0) {
    $status = $con->fetch_assoc();

    if ($status['election_started']==0) {
        echo json_encode("OFF");
    }
    else{
        echo json_encode("ON");

    }


    

}

?>