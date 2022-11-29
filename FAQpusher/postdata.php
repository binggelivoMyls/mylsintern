<?php

    echo $_POST["answer"];
    $curl = curl_init();

	if ($_GET["api"] == "5cdf77536bb02c147e14c6ddba687e0d"){
		$postfields = '{ "name": "' . $_POST["question"] . '",
			"answer": "' . $_POST["answer"] . '",
			"c_buttonTitel": "' . $_POST["c_buttonTitel"] . '",
			"c_buttonHref": "' . $_POST["c_buttonHref"] . '"}';
	} else {
		$postfields = '{"name": "' . $_POST["question"] . '",
			"answer": "' . $_POST["answer"] . '"}';
	}
		

    curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://api.yext.com/v2/accounts/me/entities?api_key=' . $_GET["api"] . '&v=20200513&entityType=faq&format=markdown',
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS =>$postfields,
    CURLOPT_HTTPHEADER => array('Content-Type: application/json')
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    echo $response;
?>