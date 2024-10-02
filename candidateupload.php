<?php
require 'database_con.php';
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type');
header("Content-Type: application/json");

$target_dir = "uploads/";

$target_file = $target_dir . basename($_FILES["file"]["name"]);

// $file = $_FILES["file"]["name"];

// echo json_encode($file);

$uploadOk = false;

$name = $_POST['name'];
$statecode = $_POST['statecode'];

$checkacceptedvoter = "SELECT * FROM `acceptedvoter` WHERE statecode='$statecode'";
$acceptcon = $database_con->query($checkacceptedvoter);

if ($acceptcon->num_rows>0) {
    $result = [
        'status' => false,
        'message' => "The state code".' '.$statecode.' '." is not available in the database"
    ];
    echo json_encode($result);
} else{
    $checkquery = "SELECT * FROM `candidates` WHERE statecode='$statecode'";
    $checkcon = $database_con->query($checkquery);
    if ($checkcon->num_rows>0) {
        $result = [
            'status' => false,
            'message' => "The state code".' '.$statecode.' '."already exist in the database"
        ];
        echo json_encode($result);
    }else{
        
        // echo json_encode([$target_file, $name, $statecode]);
        
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        
        if ($imageFileType!= "jpg" && $imageFileType!= "jpeg" && $imageFileType!= "png") {
            echo json_encode(["message"=> "Sorry, only jpg, jpeg and png picture format are allowed"]);
        }else{
            $uploadOk = true;
            if ($uploadOk) {
                $moveuploadfile = move_uploaded_file($_FILES["file"]["tmp_name"], $target_file);
                if ($moveuploadfile) {
                    $query = "INSERT INTO `candidates` (`fullname`, `profile_picture`, `statecode`) VALUES ('$name', '$target_file', '$statecode')";
                    $con = $database_con->query($query);
        
                    if ($con) {
                        $result = [
                            'status' => true,
                            'message' => "Inserted successfully"
                        ];
                        echo json_encode($result);
                    }
                    else{
                        echo json_encode("Not inserted");
        
                    }
                }else{
                    echo json_encode("not uploaded into folder");
                }
            }
            else{
                echo json_encode("Sorry, your file couldn't ne uploaded");
            }
        
        }
    
    }

}




?>