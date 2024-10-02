<?php
require 'database_con.php';

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Headers: Content-Type');

$query = "SELECT * FROM `control_flags` WHERE id = 1";
$con = $database_con->query($query);
if ($con->num_rows > 0) {
    $status = $con->fetch_assoc();
    $election_status = $status['election_started'];
    if ($status['election_started']==1) {
        $update = "UPDATE control_flags SET election_started = 0 WHERE id = 1";
        $conn = $database_con->query($update);

        if ($conn) {
            echo json_encode("You have stopped the election");
        } else {
            echo json_encode("not updated");
        }
    } else {
        $update2 = "UPDATE control_flags SET election_started = 1 WHERE id = 1";
        $connn = $database_con->query($update2);

        if ($connn) {
            echo json_encode("You have started the election");
        } else {
            echo json_encode("not updated");
        }
    }
    // echo json_encode($election_status);
}
// $update = "UPDATE control_flags SET election_started = 1 WHERE id = 1";
// $con = $database_con->query($update);

// if ($con) {
//     echo json_encode("heyyy, updated");

// }else{
//     echo json_encode("not updated");

// }

// Update registration_started or election_started status
// if (isset($_POST['start_registration'])) {
//     
//     $database_con->query($update);
// }

// if (isset($_POST['end_registration'])) {
//     $update = "UPDATE control_flags SET registration_started = 0 WHERE id = 1";
//     $database_con->query($update);
// }
