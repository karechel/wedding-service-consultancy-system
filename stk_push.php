<?php
session_start(); // Start the session

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if all required POST data is set
    if (isset($_POST['contactNumber']) && isset($_POST['amount']) && isset($_POST['booking_id'])) {
        $contactNumber = $_POST['contactNumber'];
        $amount = $_POST['amount'];
        $booking_id = $_POST['booking_id'];

        // Store booking_id in session
        $_SESSION['booking_id'] = $booking_id;


        
        // Include gen_token.php to fetch the access token
        ob_start();
        include 'gen_token.php';
        $accessToken = ob_get_clean();

        $url = 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';
        $shortCode = '174379'; // Sandbox Short Code
        $timestamp = date('YmdHis');
        $passKey = 'bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919'; // Sandbox Pass Key
        $password = base64_encode($shortCode . $passKey . $timestamp);

        $curl_post_data = [
            'BusinessShortCode' => $shortCode,
            'Password' => $password,
            'Timestamp' => $timestamp,
            'TransactionType' => 'CustomerPayBillOnline',
            'Amount' => 1,
            'PartyA' => $contactNumber, // Customer phone number (Ensure it starts with country code 254)
            'PartyB' => $shortCode,
            'PhoneNumber' => $contactNumber, // Customer phone number (Ensure it starts with country code 254)
            'CallBackURL' => 'https://yourdomain.com/callback.php', // Your callback URL
            'AccountReference' => 'WSCS',
            'TransactionDesc' => 'Payment for Booking'
        ];

        $data_string = json_encode($curl_post_data);

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Authorization:Bearer ' . $accessToken)); // Access token passed here
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);

        $curl_response = curl_exec($curl);

        // Check if the request was successful
        if ($curl_response === false) {
            $error = curl_error($curl);
            echo "Curl Error: " . $error;
        } else {
            $response = json_decode($curl_response, true);
            if (isset($response['CheckoutRequestID'])) {
                $checkoutRequestID = $response['CheckoutRequestID'];
                // Redirect to query.php passing CheckoutRequestID and booking_id as query parameters
                header("Location: query.php?checkoutRequestID=$checkoutRequestID&booking_id=$booking_id");
                exit;
            } else {
                echo "Failed to retrieve CheckoutRequestID from response";
            }
        }

        curl_close($curl);
    } else {
        echo "Required data (contactNumber, amount, booking_id) not provided.";
    }
}
?>
