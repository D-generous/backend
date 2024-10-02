<?php
require 'database_con.php';
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type');
header("Content-Type: application/json");



$query = "SELECT 
  president AS candidate, 'President' AS position, COUNT(president) AS count
FROM ballots
GROUP BY president

UNION ALL

SELECT 
  vice_president AS candidate, 'Vice President' AS position, COUNT(vice_president) AS count
FROM ballots
GROUP BY vice_president

UNION ALL

SELECT 
  gensecretary AS candidate, 'Gen. Secretary' AS position, COUNT(gensecretary) AS count
FROM ballots
GROUP BY gensecretary

UNION ALL

SELECT 
  assgensecretary AS candidate, 'Ass. Gen. Secretary' AS position, COUNT(assgensecretary) AS count
FROM ballots
GROUP BY assgensecretary

UNION ALL

SELECT 
  fin_secretary AS candidate, 'Financial Secretary' AS position, COUNT(fin_secretary) AS count
FROM ballots
GROUP BY fin_secretary

UNION ALL

SELECT 
  electoralofficer1 AS candidate, 'Electoral Officer 1' AS position, COUNT(electoralofficer1) AS count
FROM ballots
GROUP BY electoralofficer1
UNION ALL
SELECT 
  electoralofficer2 AS candidate, 'Electoral Officer 2' AS position, COUNT(electoralofficer2) AS count
FROM ballots
GROUP BY electoralofficer2
UNION ALL

SELECT 
  profficer AS candidate, 'PR Officer' AS position, COUNT(profficer) AS count
FROM ballots
GROUP BY profficer
UNION ALL

SELECT 
  projectmanager AS candidate, 'Project Manager' AS position, COUNT(projectmanager) AS count
FROM ballots
GROUP BY projectmanager
UNION ALL

SELECT 
  welfareofficer AS candidate, 'Welfare Officer' AS position, COUNT(welfareofficer) AS count
FROM ballots
GROUP BY welfareofficer

";


$con = $database_con->query($query);

$collation = [];

if ($con->num_rows < 1) {
  $collation = [
    'status' => false,
    'message' => 'No result yet'
  ];

  echo json_encode($collation);
} else {
  $results = $con->fetch_all(MYSQLI_ASSOC);
  foreach ($results as $result) {
    $candidate = $result['candidate'];
    $position = $result['position'];
    $count = $result['count'];

    $collation[] = [
      'candidate' => $candidate,
      'position' => $position,
      'count' => $count,
    ];
  }
  // echo json_encode(['status'=> true, 'res'=> $collation]);
  echo json_encode([
    'status' => true,  // voter ID as a separate field
    'candidates' => $collation // list of candidates
]);
}
