<?php
$url = $_GET["url"];
// 	$url = 'http://google.com';
// 	$url = 'http://127.0.0.1/INSTALL.txt';
//$url = 'http://127.0.0.1/crm/service/v4_1/rest.php';
	$curl = curl_init ( $url );
	// Tell curl not to return headers, but do return the response
	curl_setopt ( $curl, CURLOPT_HEADER, false );
	curl_setopt ( $curl, CURLOPT_RETURNTRANSFER, true );
	// DEBUG
	curl_setopt($curl, CURLOPT_VERBOSE, true);
	curl_setopt($curl, CURLOPT_STDERR,  fopen('php://output', 'w'));
	session_write_close();
	// Make the REST call, returning the result
	$response = curl_exec ( $curl );
	if (!$response) {
		$error = curl_error($curl);
		echo "Error was $error\n";
	}
	echo "Response was " . $response . "\n";
	// Close the connection
	curl_close ( $curl );
	session_start();

?>