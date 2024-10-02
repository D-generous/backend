<?php
require 'database_con.php';
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type');
header("Content-Type: application/json");

$input = json_decode(file_get_contents('php://input'));
ini_set('display_errors', 1);
error_reporting(E_ALL);


$statecode = $input->statecode;

// echo json_encode($statecode);

$query = "SELECT * FROM `acceptedvoter` WHERE statecode = '$statecode'";
$con = $database_con->query($query);
if ($con->num_rows>0) {
    $result = [
        'status' => false,
        'message'=>"The state code". ' '. $statecode.' '."Already exist in the database"
    ];
    echo json_encode($result);
}
else{

    // echo json_encode("code not available");

    $query2 = "INSERT INTO `acceptedvoter` (`statecode`) VALUES ('$statecode')";
    $conn = $database_con->query($query2);
    if ($conn) {
        $result = [
            'status' => true,
            'message'=> "Inserted Successfully"
        ];
        echo json_encode($result);
    }
    else{
        echo json_encode("Not Inserted Successfully");

    }

}


?>