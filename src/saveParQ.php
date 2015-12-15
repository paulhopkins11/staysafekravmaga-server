<?php

include 'sugarcrm.php';
include 'email.php';

// phpinfo();

// $firstname = $_POST["firstname"];
// $surname = $_POST["surname"];
$upload_raw = file_get_contents('php://input');
// $parq_raw = stream_get_contents(STDIN);


// echo 'Raw is ' . htmlspecialchars($parq_raw);
// Convert to JSON
$upload = json_decode($upload_raw);
echo 'Output the json variable\n';
var_dump($upload);

// print $parq->{'Some'}; // 12345
/*
{
  ["settings"]=>
  object(stdClass)#2 (4) {
    ["name"]=>
    string(12) "Paul Hopkins"
    ["email"]=>
    string(25) "paul@staysafekravmaga.com"
    ["phone"]=>
    string(12) "07982 677717"
    ["classlocation"]=>
    string(10) "Winchester"
  }
  ["parq"]=>
  object(stdClass)#3 (4) {
    ["firstname"]=>
    string(4) "Paul"
    ["surname"]=>
    string(7) "Hopkins"
    ["email"]=>
    string(24) "paul_hopkins@yahoo.co.uk"
    ["dob"]=>
    string(8) "01/02/99"
  }
} * */
addStudent($parq);
// $upload->{'parq'}->{'firstname'}
$from = $upload->{'settings'}->{'email'};
$to = $upload->{'parq'}->{'email'};

send_mail($from, $to, "Stay Safe Krav Maga", "<html><body>". $upload->{'parq'}->{'date'} . " HTML Body goes here</body></html>")

?>
