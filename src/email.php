<?php 

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

?>