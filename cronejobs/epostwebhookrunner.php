<?php

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://flow.zoho.eu/20063376379/flow/webhook/incoming?zapikey=1001.7c2a11c7679ebd3e4dc8ee088d31ef5b.9574cc7976e68b0f63731bf780c6b521&isdebug=false',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
  CURLOPT_HTTPHEADER => array(
    'Cookie: _zcsr_tmp=18b29df8-e4f5-4d08-b269-2f9c00633dd7; bd4ed54a70=3d24d258cb0cc7be402151e1a3fd5f5e; zipccn=18b29df8-e4f5-4d08-b269-2f9c00633dd7'
  ),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;

?>