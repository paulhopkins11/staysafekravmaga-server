<?php
function addStudent($upload) {
	$url = 'http://localhost/crm/service/v4_1/rest.php';
	// Open a curl session for making the call
	$curl = curl_init ( $url );
	// Tell curl to use HTTP POST
	curl_setopt ( $curl, CURLOPT_POST, true );
	// Tell curl not to return headers, but do return the response
	curl_setopt ( $curl, CURLOPT_HEADER, false );
	curl_setopt ( $curl, CURLOPT_RETURNTRANSFER, true );
	// Set the POST arguments to pass to the Sugar server
	$parameters = array (
			'user_name' => 'rest',
			'password' => '7DyDhh' 
	);
	$json = json_encode ( $parameters );
	$postArgs = 'method=login&input_type=json&
       response_type=json&rest_data=' . $json;
	curl_setopt ( $curl, CURLOPT_POSTFIELDS, $postArgs );
	// Make the REST call, returning the result
	$response = curl_exec ( $session );
	// Close the connection
	curl_close ( $session );
	// Convert the result from JSON format to a PHP array
	$result = json_decode ( $response );
	// Get the session id
	$sessionId = $result ['id'];
	// Now, let's add a new Accounts record
	$parameters = array (
			'session' => $session,
			'module' => 'Accounts',
			'name_value_list' => array (
					array (
							'name' => 'name',
							'value' => $upload->{'parq'}->{'firstname'} . ' ' . $upload->{'parq'}->{'surname'}
					),
					array (
							'name' => 'description',
							'value' => 'This is an account created from a REST web services call' 
					) 
			) 
	);
	$json = json_encode ( $parameters );
	$postArgs = 'method=set_entry&input_type=json&
     response_type=json&rest_data=' . $json;
	curl_setopt ( $curl, CURLOPT_POSTFIELDS, $postArgs );
	// Make the REST call, returning the result
	$response = curl_exec ( $session );
	// Convert the result from JSON format to a PHP array
	$result = json_decode ( $response );
	// Get the newly created record id
	$recordId = $result ['id'];
}

?> 