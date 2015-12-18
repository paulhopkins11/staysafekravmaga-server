<?php
function testCurl() {
	$url = 'http://kravfitnesssystems.com/crm/service/v4_1/rest.php';
	// 	echo "Uploading to " . $url . "\n";
	// Open a curl session for making the call
	$curl = curl_init ( $url );
	// Tell curl to use HTTP POST
// 	curl_setopt ( $curl, CURLOPT_POST, true );
	// Tell curl not to return headers, but do return the response
	curl_setopt ( $curl, CURLOPT_HEADER, false );
	curl_setopt ( $curl, CURLOPT_RETURNTRANSFER, true );
	// DEBUG
	curl_setopt($curl, CURLOPT_VERBOSE, true);
	curl_setopt($curl, CURLOPT_STDERR,  fopen('php://output', 'w'));
	// Set the POST arguments to pass to the Sugar server
// 	$parameters = array(
// 			'user_auth' => array(
// 					'user_name' => 'rest',
// 					'password' => md5('r35t123'),
// 			),
// 	);
	// 	$parameters = array (
	// 			'user_name' => 'rest',
	// 			'password' => '2D93F490E2B6F2644F3B73566BCB4DEF'//'r35t123'
	// 	);
// 	$json = json_encode ( $parameters );
// 	$postArgs = 'method=login&input_type=json&response_type=json&rest_data=' . $json;
// 	echo "postArgs " . $url . "?" . $postArgs . "\n";
// 	curl_setopt ( $curl, CURLOPT_POSTFIELDS, $postArgs );
	session_write_close();
	// Make the REST call, returning the result
	$response = curl_exec ( $curl );
	if (!$response) {
		$error = curl_error($curl);
		echo "Error was $error\n";
	}
	echo "Login Response was " . $response . "\n";
	// Close the connection
	curl_close ( $curl );
	session_start();
}
function addStudent($upload) {
	$url = 'http://kravfitnesssystems.com/crm/service/v4_1/rest.php';
	// Get the session id
	$sessionId = login($url);
	echo "Session id was " . $sessionId . "\n";
	
	$curl = curl_init ( $url );
	// Tell curl to use HTTP POST
	curl_setopt ( $curl, CURLOPT_POST, true );
	// Tell curl not to return headers, but do return the response
	curl_setopt ( $curl, CURLOPT_HEADER, false );
	curl_setopt ( $curl, CURLOPT_RETURNTRANSFER, true );
	// DEBUG
	curl_setopt($curl, CURLOPT_VERBOSE, true);
	curl_setopt($curl, CURLOPT_STDERR,  fopen('php://output', 'w'));
	$parq = $upload->{'parq'};
	$settings = $upload->{'settings'};
	$dob = DateTime::createFromFormat('d/m/Y', $parq->{'dob'});
	$dobString = $dob->format('Y-m-d');
	echo "DOB String is $dobString\n";
	// Now, let's add a new Accounts record
	$parameters = array (
			'session' => $sessionId,
			'module' => 'Contacts',
			'name_value_list' => array (
					array (
							'name' => 'first_name',
							'value' => $parq->{'firstname'}
					),
					array (
							'name' => 'last_name',
							'value' => $parq->{'surname'}
					),
					array (
							'name' => 'email1',
							'value' => $parq->{'email'}
					),
					array (
							'name' => 'phone_home',
							'value' => $parq->{'homephone'}
					),
					array (
							'name' => 'phone_mobile',
							'value' => $parq->{'mobilephone'}
					),
					array (
							'name' => 'primary_address_street',
							'value' => $parq->{'address'} 
					),
					array (
							'name' => 'primary_address_postalcode',
							'value' => $parq->{'postcode'} 
					),
					array (
							'name' => 'birthdate',
							'value' => $dobString
					),
					array (
							'name' => 'date_entered',
							'value' => $parq->{'date'} 
					),
					array (
							'name' => 'assistant',
							'value' => $parq->{'emergencycontact'} 
					),
					array (
							'name' => 'assistant_phone',
							'value' => $parq->{'emergencynumber'} 
					),
					array (
							'name' => 'how_hear_c',
							'value' => $parq->{'howhear'} 
					),
					array (
							'name' => 'q1_heart_c',
							'value' => $parq->{'q1_heart'} 
					),
					array (
							'name' => 'q2_chest_c',
							'value' => $parq->{'q2_chest'} 
					),
					array (
							'name' => 'q3_chestmonth_c',
							'value' => $parq->{'q3_chestmonth'} 
					),
					array (
							'name' => 'q4_dizzy_c',
							'value' => $parq->{'q4_dizzy'} 
					),
					array (
							'name' => 'q5_bone_c',
							'value' => $parq->{'q5_bone'} 
					),
					array (
							'name' => 'q6_blood_c',
							'value' => $parq->{'q6_blood'} 
					),
					array (
							'name' => 'q7_supervision_c',
							'value' => $parq->{'q7_supervision'} 
					),
					array (
							'name' => 'q8_pregnant_c',
							'value' => $parq->{'q8_pregnant'} 
					),
					array (
							'name' => 'q9_additional_c',
							'value' => $parq->{'q9_additional'} 
					),
					array (
							'name' => 'secret_c',
							'value' => $parq->{'secret'} 
					),
					array (
							'name' => 'instructor_c',
							'value' => $settings->{'name'} 
					),
					array (
							'name' => 'class_c',
							'value' => $settings->{'classlocation'} 
					) 
			) 
	);
	$json = json_encode ( $parameters );
	$postArgs = 'method=set_entry&input_type=json&response_type=json&rest_data=' . $json;
	echo "postArgs " . $url . "?" . $postArgs . "\n";
	curl_setopt ( $curl, CURLOPT_POSTFIELDS, $postArgs );
	// Make the REST call, returning the result
	$response = curl_exec ( $curl );
	echo "Add Response was " . $response . "\n";
	// Convert the result from JSON format to a PHP array
	$result = json_decode ( $response );
	// Get the newly created record id
// 	$recordId = $result ['id'];
	$recordId = $result->{'id'};
	echo "New User Id is " . $recordId . "\n";
	return $recordId;
}

function login($url) {
// 	echo "Uploading to " . $url . "\n";
	// Open a curl session for making the call
	$curl = curl_init ( $url );
	// Tell curl to use HTTP POST
	curl_setopt ( $curl, CURLOPT_POST, true );
	// Tell curl not to return headers, but do return the response
	curl_setopt ( $curl, CURLOPT_HEADER, false );
	curl_setopt ( $curl, CURLOPT_RETURNTRANSFER, true );
	// DEBUG
	curl_setopt($curl, CURLOPT_VERBOSE, true);
	curl_setopt($curl, CURLOPT_STDERR,  fopen('php://output', 'w'));
	// Set the POST arguments to pass to the Sugar server
	$parameters = array(
			'user_auth' => array(
					'user_name' => 'admin',
					'password' => md5('paulspass99'),
// 					'user_name' => 'rest',
// 					'password' => md5('r35t123'),
			),
	);
// 	$parameters = array (
// 			'user_name' => 'rest',
// 			'password' => '2D93F490E2B6F2644F3B73566BCB4DEF'//'r35t123' 
// 	);
	$json = json_encode ( $parameters );
	$postArgs = 'method=login&input_type=json&response_type=json&rest_data=' . $json;
	echo "postArgs " . $url . "?" . $postArgs . "\n";
	curl_setopt ( $curl, CURLOPT_POSTFIELDS, $postArgs );
	// Make the REST call, returning the result
	$response = curl_exec ( $curl );
	if (!$response) {
		$error = curl_error($curl);
		echo "Error was $error\n";
	}
	echo "Login Response was " . $response . "\n";
	// Close the connection
	curl_close ( $curl );
	// Convert the result from JSON format to a PHP array
	$result = json_decode ( $response );
	// Get the session id
	$sessionId = $result->{'id'};
	echo "Session id was " . $sessionId . "\n";
	return $sessionId;
}

function doitalladdStudent($upload) {
	$url = 'http://kravfitnesssystems.com/crm/service/v4_1/rest.php';
// 	echo "Uploading to " . $url . "\n";
	// Open a curl session for making the call
	$curl = curl_init ( $url );
	// Tell curl to use HTTP POST
	curl_setopt ( $curl, CURLOPT_POST, true );
	// Tell curl not to return headers, but do return the response
	curl_setopt ( $curl, CURLOPT_HEADER, false );
	curl_setopt ( $curl, CURLOPT_RETURNTRANSFER, true );
	// DEBUG
	curl_setopt($curl, CURLOPT_VERBOSE, true);
	curl_setopt($curl, CURLOPT_STDERR,  fopen('php://output', 'w'));
	// Set the POST arguments to pass to the Sugar server
	$parameters = array(
			'user_auth' => array(
					'user_name' => 'admin',
					'password' => md5('paulspass99'),
// 					'user_name' => 'rest',
// 					'password' => md5('r35t123'),
			),
	);
// 	$parameters = array (
// 			'user_name' => 'rest',
// 			'password' => '2D93F490E2B6F2644F3B73566BCB4DEF'//'r35t123' 
// 	);
	$json = json_encode ( $parameters );
	$postArgs = 'method=login&input_type=json&response_type=json&rest_data=' . $json;
	echo "postArgs " . $url . "?" . $postArgs . "\n";
	curl_setopt ( $curl, CURLOPT_POSTFIELDS, $postArgs );
	// Make the REST call, returning the result
	$response = curl_exec ( $curl );
	if (!$response) {
		$error = curl_error($curl);
		echo "Error was $error\n";
	}
	echo "Login Response was " . $response . "\n";
	// Close the connection
	curl_close ( $curl );
	// Convert the result from JSON format to a PHP array
	$result = json_decode ( $response );
	// Get the session id
	$sessionId = $result ['id'];
	echo "Session id was " . $sessionId . "\n";
	// Now, let's add a new Accounts record
// 	$parameters = array (
// 			'session' => $sessionId,
// 			'module' => 'Accounts',
// 			'name_value_list' => array (
// 					array (
// 							'name' => 'name',
// 							'value' => $upload->{'parq'}->{'firstname'} . ' ' . $upload->{'parq'}->{'surname'}
// 					),
// 					array (
// 							'name' => 'description',
// 							'value' => 'This is an account created from a REST web services call' 
// 					) 
// 			) 
// 	);
// 	$json = json_encode ( $parameters );
// 	$postArgs = 'method=set_entry&input_type=json&response_type=json&rest_data=' . $json;
// 	curl_setopt ( $curl, CURLOPT_POSTFIELDS, $postArgs );
// 	// Make the REST call, returning the result
// 	$response = curl_exec ( $curl );
// 	echo "Add Response was " . $response . "\n";
// 	// Convert the result from JSON format to a PHP array
// 	$result = json_decode ( $response );
// 	// Get the newly created record id
// 	$recordId = $result ['id'];
// 	return $recordId;
}

?> 