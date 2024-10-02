<?php

$hostname = 'localhost';
$username = 'root';
$password = '';
$database = 'Election';


$database_con = new mysqli($hostname, $username, $password, $database);
if ($database_con->error) {
    echo 'Not connected'.$database_con->error;
}
else{
    // echo 'Connected Yeah!!!';
}

?>