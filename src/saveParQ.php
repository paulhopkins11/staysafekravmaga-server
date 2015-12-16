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
// echo 'Output the json variable\n';
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
$parq = $upload->{'parq'};
$htmlbody = file_get_contents("parq");
$htmlbody = str_replace("parq.firstname", $parq->{'firstname'}, $htmlbody );
$htmlbody = str_replace("parq.surname", $parq->{'surname'}, $htmlbody );
$htmlbody = str_replace("parq.address", $parq->{'address'}, $htmlbody );
$htmlbody = str_replace("parq.postcode", $parq->{'postcode'}, $htmlbody );
$htmlbody = str_replace("parq.homephone", $parq->{'homephone'}, $htmlbody );
$htmlbody = str_replace("parq.mobile", $parq->{'mobile'}, $htmlbody );
$htmlbody = str_replace("parq.dob", $parq->{'dob'}, $htmlbody );
$htmlbody = str_replace("parq.email", $parq->{'email'}, $htmlbody );
$htmlbody = str_replace("parq.emergencycontact", $parq->{'emergencycontact'}, $htmlbody );
$htmlbody = str_replace("parq.emergencynumber", $parq->{'emergencynumber'}, $htmlbody );
$htmlbody = str_replace("parq.howhear", $parq->{'howhear'}, $htmlbody );
$htmlbody = str_replace("parq.q1_heart", $parq->{'q1_heart'}, $htmlbody );
$htmlbody = str_replace("parq.q2_chest", $parq->{'q2_chest'}, $htmlbody );
$htmlbody = str_replace("parq.q3_chestmonth", $parq->{'q3_chestmonth'}, $htmlbody );
$htmlbody = str_replace("parq.q4_dizzy", $parq->{'q4_dizzy'}, $htmlbody );
$htmlbody = str_replace("parq.q5_bone", $parq->{'q5_bone'}, $htmlbody );
$htmlbody = str_replace("parq.q6_blood", $parq->{'q6_blood'}, $htmlbody );
$htmlbody = str_replace("parq.q7_supervision", $parq->{'q7_supervision'}, $htmlbody );
$htmlbody = str_replace("parq.q8_pregnant", $parq->{'q8_pregnant'}, $htmlbody );
$htmlbody = str_replace("parq.q9_additional", $parq->{'q9_additional'}, $htmlbody );
$htmlbody = str_replace("parq.secret", $parq->{'secret'}, $htmlbody );
addStudent($parq);
// $upload->{'parq'}->{'firstname'}
$from = $upload->{'settings'}->{'email'};
$to = $upload->{'parq'}->{'email'};

send_mail($from, $to, "Stay Safe Krav Maga", $htmlbody)

?>
