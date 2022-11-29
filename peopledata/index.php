<?php

if (isset($_GET["code"])){	
	$curl = curl_init();

	curl_setopt_array($curl, array(
	  CURLOPT_URL => 'https://accounts.zoho.eu/oauth/v2/token',
	  CURLOPT_CUSTOMREQUEST => 'POST',
	  CURLOPT_POSTFIELDS => array(
		'grant_type' => '\"authorization_code\"',
		'client_id' => '\"1000.FFFPZ4Y9ORFR7AEWR9PVF63X5WYJHG\"',
		'client_secret' => '\"4585fe425dc4e52e98bbda69a5413815b9e3245e26\"',
		'redirect_uri' => '\"https:\/\/mylsintern.mls-test.ch\/peopledata\/\"',
		'code' => '\"' . $_GET["code"] . '\"')
	));

	$response = curl_exec($curl);

	curl_close($curl);
	echo $response;


	/*curl_setopt_array($curl, array(
	  CURLOPT_URL => 'https://people.zoho.com/people/api/v2/leavetracker/reports/user?employee=20079406884',
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => '',
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 0,
	  CURLOPT_FOLLOWLOCATION => true,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => 'GET',
	  CURLOPT_HTTPHEADER => array(
		'Authorization: Zoho-oauthtoken ' . $_GET["code"],
	  ),
	));

	$response = curl_exec($curl);

	curl_close($curl);
	echo $response;
	
	echo "<br>";
	
	$curl = curl_init();

	curl_setopt_array($curl, array(
	  CURLOPT_URL => 'https://people.zoho.com/people/api/v2/leavetracker/reports/bookedAndBalance?from=01-11-2021&to=01-11-2022&unit=Hour',
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => '',
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 0,
	  CURLOPT_FOLLOWLOCATION => true,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => 'GET',
	  CURLOPT_HTTPHEADER => array(
		'Authorization: Zoho-oauthtoken ' . $_GET["code"],
	  ),
	));

	$response = curl_exec($curl);

	curl_close($curl);
	echo $response;*/
} else {
	header("Location: https://accounts.zoho.eu/oauth/v2/auth?scope=ZOHOPEOPLE.forms.ALL&client_id=1000.FFFPZ4Y9ORFR7AEWR9PVF63X5WYJHG&response_type=code&access_type=offline&redirect_uri=https://mylsintern.mls-test.ch/peopledata/");
}






?>