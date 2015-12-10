<?php

$firstname = $_POST["firstname"];
$surname = $_POST["surname"];
$parq_raw = file_get_contents('php://input');
// $parq_raw = stream_get_contents(STDIN);

echo 'Raw is ' . htmlspecialchars($parq_raw);
// Convert to JSON
$parq = json_decode($parq_raw);
echo 'Output the json variable';
var_dump($parq);

print $parq->{'Some'}; // 12345

?>
