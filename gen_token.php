<?php
// gen_token.php code to fetch and output access token
$consumerKey = 'WALndUAcNngxBiAKVettRoDYPzakHqMpNYGKoOZu6JSrXGME'; // Fill with your app Consumer Key
$consumerSecret = 'bNXMTvxtkqQgly1EEeiGFW0KFyU3oRMaOr9Pe2wxXPS3On7G9QDvAM6usj1X9DOg'; // Fill with your app Consumer Secret

$headers = ['Content-Type:application/json; charset=utf8'];
$url = 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';

$curl = curl_init($url);
curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($curl, CURLOPT_HEADER, FALSE);
curl_setopt($curl, CURLOPT_USERPWD, $consumerKey . ':' . $consumerSecret);
$result = curl_exec($curl);
$status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

if ($status !== 200) {
    die("Error: Failed to retrieve access token.");
}

$response = json_decode($result);

if (!isset($response->access_token)) {
    die("Error: Access token not found in response.");
}

$access_token = $response->access_token;

// Output the access token
echo $access_token;

// Close cURL resource
curl_close($curl);
?>
