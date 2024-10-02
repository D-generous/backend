

<?php
require 'database_con.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
session_start();
require 'vendor/autoload.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $postData = file_get_contents("php://input");
    $request = json_decode($postData, true);

    $to = $request['to'];
    

    $query = "SELECT * FROM `voters` WHERE email = '$to'";
    $con = $database_con->query($query);
    if ($con->num_rows>0) {
        $user = $con->fetch_assoc();
        $fullname = $user['fullname'];



        // Generate a unique token
        $token = bin2hex(random_bytes(50));
        $expiry_time = date("Y-m-d H:i:s", strtotime('+1 hour')); // Token expires in 1 hour

        // Store the token and expiry time in the database
        $insertTokenQuery = "UPDATE `voters` SET reset_token='$token', token_expiry='$expiry_time' WHERE email='$to'";
        $database_con->query($insertTokenQuery);
        
        


        // Send email with link
        $mail = new PHPMailer(true);
        try {
            $mail->SMTPDebug = 0;
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'dgenafo@gmail.com';
            $mail->Password   = 'jdzy efkh jmgi fpfg';
            $mail->SMTPSecure = 'ssl';
            $mail->Port       = 465;
    
            $mail->setFrom('dgenafo@gmail.com', 'Alok');
            $mail->addAddress($to);
    
            $mail->isHTML(true);
            $mail->Subject = 'Please Confirm Your Response';
            $resetLink = "https://www.google.com/?token=$token";
            $mail->Body    = "
                <p>Hi, $fullname</p>
                <p>Are you trying to reset your password. Please click on the link below to reset your password:</p>
                
                <a href='$resetLink' style='background-color: #4CAF50; color: white; padding: 10px 20px; text-align: center; text-decoration: none; display: inline-block; font-size: 16px; border-radius: 5px;'>Click here to reset password</a>
                <p>Thank you!</p>
            ";
    
            $mail->send();
            echo json_encode(["state"=> true, "status" => "success", "message" => "Email has been sent, click on it and reset password"]);
        } catch (Exception $e) {
            echo json_encode(["status" => "error", "message" => "Message could not be sent. Mailer Error: {$mail->ErrorInfo}"]);
        }


    }
    else{
        echo json_encode(["state"=>false, "message"=>"Email does not exist"]);
    }

} 
else {
    echo json_encode(["status" => "error", "message" => "Invalid request method"]);
}

?>

