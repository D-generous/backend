<?php
require 'database_con.php';
// require 'vendor/autoload.php';
// use Firebase\JWT\JWT;
// use Firebase\JWT\Key;

header('Access-Control-Allow-Origin: http://localhost:4200');
header('Access-Control-Allow-Credentials: true');
header('Content-Type: application/json');
header('Access-Control-Allow-Headers: Content-Type');

// $secretKey = "your_secret_key";

// if (!isset($_COOKIE['jwt'])) {
//     http_response_code(401);
//     echo json_encode(['message'=>'Unauthorized, no token provided']);
// }

// $jwt = $_COOKIE['jwt'];

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
$query = "SELECT 'Total Voters' AS table_name, COUNT(*) AS row_count 
FROM voters
UNION ALL
SELECT 'Total Candidates' AS table_name, COUNT(*) AS row_count 
FROM candidates
UNION ALL
SELECT 'Ongoing Elections' AS table_name, COUNT(*) AS row_count 
FROM ballots
UNION ALL
SELECT 'Recent Activity' AS table_name, COUNT(created_at) AS row_count
FROM ballots
WHERE created_at >= NOW() - INTERVAL 24 HOUR;
";
// Ballots 
$con = $database_con->query($query);
$collation = [];
if ($con) {
    $results = $con->fetch_all(MYSQLI_ASSOC);

    echo json_encode($results);

}
 
}
?>