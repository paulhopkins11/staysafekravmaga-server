<?php

// phpinfo();

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

function send_mail ($from , $to, $subject, $message){
	$header = "From:" . $from . " \r\n";
// 	$header = "Cc:afgh@somedomain.com \r\n";
	$header .= "MIME-Version: 1.0\r\n";
	$header .= "Content-type: text/html\r\n";
	 
	$retval = mail ($to,$subject,$message,$header);
	 
	if( $retval == true )
	{
		echo "Message sent successfully...";
	}
	else
	{
		echo "Message could not be sent...";
	}
}
send_mail("paul@staysafekravmaga.com", "paul_hopkins@yahoo.co.uk", "Test Email", "<html><body>12:34 HTML Body goes here</body></html>")

?>
