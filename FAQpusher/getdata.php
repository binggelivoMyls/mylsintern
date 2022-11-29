<?php
    // Initializing curl
    $curl = curl_init();
        
    // Sending GET request to reqres.in
    // server to get JSON data
    curl_setopt($curl, CURLOPT_URL,
        "https://api.yext.com/v2/accounts/me/entities?api_key=" . $_GET["api"] . "&v=20200513&entityTypes=faq&limit=50&offset=" . $_GET["offset"]);
        
    // Telling curl to store JSON
    // data in a variable instead
    // of dumping on screen
    curl_setopt($curl,
        CURLOPT_RETURNTRANSFER, true);
        
    // Executing curl
    $response = curl_exec($curl);
    
    // Checking if any error occurs
    // during request or not
    if($e = curl_error($curl)) {
        echo $e;
    } else {  
        // Outputting JSON data in
        // Decoded form
        echo($response);
    }
    
    // Closing curl
    curl_close($curl);
?>