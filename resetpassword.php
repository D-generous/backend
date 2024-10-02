<?php
require 'database_con.php';
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    $query = "SELECT * FROM `voters` WHERE reset_token='$token' AND token_expiry > NOW()";
    $con = $database_con->query($query);

    if ($con->num_rows > 0) {
        // Token is valid, show the password reset form
        $user = $con->fetch_assoc();
        echo json_encode($user);
        // ... (Display password reset form)

    } else {
        // Token is invalid or expired
        echo json_encode("Invalid or expired token.") ;
    }
} else {
    echo json_encode("No token provided.");
}



// After successfully resetting the password
// $updateQuery = "UPDATE `voters` SET reset_token=NULL, token_expiry=NULL WHERE email='$to'";
// $database_con->query($updateQuery);

?>