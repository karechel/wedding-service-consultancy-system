<?php
$consumerKey = 'WALndUAcNngxBiAKVettRoDYPzakHqMpNYGKoOZu6JSrXGME'; // Your app Consumer Key
$consumerSecret = 'bNXMTvxtkqQgly1EEeiGFW0KFyU3oRMaOr9Pe2wxXPS3On7G9QDvAM6usj1X9DOg'; // Your app Consumer Secret

$headers = ['Content-Type:application/json; charset=utf8'];
$url = 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';

$curl = curl_init($url);
curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($curl, CURLOPT_HEADER, FALSE);
curl_setopt($curl, CURLOPT_USERPWD, $consumerKey . ':' . $consumerSecret);
$result = curl_exec($curl);
$status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

if ($status == 200) {
    $result = json_decode($result);
    $access_token = $result->access_token;
    echo $access_token; // Output the access token
} else {
    echo "Failed to get access token. HTTP Status Code: " . $status;
}

curl_close($curl);
?>
