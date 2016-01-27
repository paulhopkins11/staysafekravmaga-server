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
 object(stdClass)#2 (4) {
    ["name"]=>
    string(12) "Paul Hopkins"
    ["email"]=>
    string(21) "phopkins@nstech.co.uk"
    ["phone"]=>
    string(12) "07982 677717"
    ["classlocation"]=>
    string(10) "Winchester"
  }
  ["parq"]=>
  object(stdClass)#3 (23) {
    ["q1_heart"]=>
    bool(true)
    ["q2_chest"]=>
    bool(false)
    ["q3_chestmonth"]=>
    bool(true)
    ["q4_dizzy"]=>
    bool(false)
    ["q5_bone"]=>
    bool(true)
    ["q6_blood"]=>
    bool(false)
    ["q7_supervision"]=>
    bool(true)
    ["q8_pregnant"]=>
    bool(false)
    ["q9_additional"]=>
    string(4) "Nope"
    ["secret"]=>
    string(6) "aawwqq"
  } */
$parq = $upload->{'parq'};
$settings = $upload->{'settings'};
$htmlbody = file_get_contents("parq");
$trueVal = "checked";
$falseVal = "";
$htmlbody = str_replace("settings.name", $settings->{'name'}, $htmlbody );
$htmlbody = str_replace("settings.email", $settings->{'email'}, $htmlbody );
$htmlbody = str_replace("settings.phone", $settings->{'phone'}, $htmlbody );



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
$htmlbody = str_replace("parq.q1_heart", $parq->{'q1_heart'}?$trueVal:$falseVal, $htmlbody );
$htmlbody = str_replace("parq.q2_chest", $parq->{'q2_chest'}?$trueVal:$falseVal, $htmlbody );
$htmlbody = str_replace("parq.q3_chestmonth", $parq->{'q3_chestmonth'}?$trueVal:$falseVal, $htmlbody );
$htmlbody = str_replace("parq.q4_dizzy", $parq->{'q4_dizzy'}?$trueVal:$falseVal, $htmlbody );
$htmlbody = str_replace("parq.q5_bone", $parq->{'q5_bone'}?$trueVal:$falseVal, $htmlbody );
$htmlbody = str_replace("parq.q6_blood", $parq->{'q6_blood'}?$trueVal:$falseVal, $htmlbody );
$htmlbody = str_replace("parq.q7_supervision", $parq->{'q7_supervision'}?$trueVal:$falseVal, $htmlbody );
$htmlbody = str_replace("parq.q8_pregnant", $parq->{'q8_pregnant'}?$trueVal:$falseVal, $htmlbody );
$htmlbody = str_replace("parq.q9_additional", $parq->{'q9_additional'}, $htmlbody );
$htmlbody = str_replace("parq.secret", $parq->{'secret'}, $htmlbody );

// Add student to SugarCRM
addStudent($upload);
$from = $settings->{'email'};
$to = $parq->{'email'};
// Send email to student
send_mail($from, $to, "Stay Safe Krav Maga", $htmlbody);
// Send email to instructor
send_mail($from, $from, "Stay Safe Krav Maga", $htmlbody);

?>
