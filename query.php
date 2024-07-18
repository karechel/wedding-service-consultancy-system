<?php
if (isset($_GET['checkoutRequestID']) && isset($_GET['booking_id'])) {
    $checkoutRequestID = $_GET['checkoutRequestID'];
    $booking_id = $_GET['booking_id'];

    // Include gen_token.php to fetch the access token
    ob_start();
    include 'gen_token.php';
    $accessToken = ob_get_clean();

    $retryCount = 5;
    $retryInterval = 30; // in seconds

    $paymentStatusUpdated = false;

    while ($retryCount > 0 && !$paymentStatusUpdated) {
        // Set up your cURL request to query STK Push status
        $ch = curl_init('https://sandbox.safaricom.co.ke/mpesa/stkpushquery/v1/query');

        // Set headers and other options
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $accessToken,
            'Content-Type: application/json'
        ]);
        curl_setopt($ch, CURLOPT_POST, 1);

        // Generate current timestamp
        $shortCode = '174379'; // Sandbox Short Code
        $timestamp = date('YmdHis');
        $passKey = 'bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919'; // Sandbox Pass Key
        $password = base64_encode($shortCode . $passKey . $timestamp);

        // Set the request body with dynamic timestamp and CheckoutRequestID
        $requestBody = json_encode([
            "BusinessShortCode" => $shortCode,
            "Password" => $password,
            "Timestamp" => $timestamp,
            "CheckoutRequestID" => $checkoutRequestID
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $requestBody);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        // Execute the request and capture the response
        $response = curl_exec($ch);

        // Check for errors
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }

        // Close curl session
        curl_close($ch);

        // Handle the response
        if ($response) {
            $json_response = json_decode($response, true);

            // Check if JSON decoding was successful
            if ($json_response === null) {
                echo "Error decoding JSON response.";
            } else {
             
              
                // Check if payment was successful
                if (isset($json_response['ResponseCode']) && $json_response['ResponseCode'] === "0") {
                    // Update the payment status in your database to "Paid" for $booking_id
                    updatePaymentStatus($booking_id, 'Paid');
                    echo "Payment successful. Response: " . $response;
                    $paymentStatusUpdated = true; // Set flag to break out of the retry loop
                } else {
                    echo "Payment not successful. Retrying...<br>";
                }
            }
        } else {
            echo "No response received from STK Push query. Retrying...<br>";
        }

        // Decrement retry count and wait before retrying
        $retryCount--;
        sleep($retryInterval);
    }

    // If payment status is not updated after all retries
    if (!$paymentStatusUpdated) {
        echo "Payment status update failed after retries.";
    }
} else {
    echo "CheckoutRequestID or booking_id not provided";
}

// Function to update payment status in database
function updatePaymentStatus($booking_id, $status) {
    try {
        // Connect to your database
        include 'connection.php'; 
        
        // Begin transaction
        $pdo->beginTransaction();

        // Update payment status in bookings table
        $updateSql = "UPDATE bookings SET payment_status = :status WHERE booking_id = :booking_id";
        $updateStmt = $pdo->prepare($updateSql);
        $updateStmt->bindParam(':status', $status, PDO::PARAM_STR);
        $updateStmt->bindParam(':booking_id', $booking_id, PDO::PARAM_INT);
        $updateStmt->execute();

        // Check if the update was successful
        $rowCount = $updateStmt->rowCount();

        if ($rowCount > 0 && $status === 'Paid') {
            // Fetch booking details including vendor_id and service_id
            $selectSql = "SELECT b.vendor_id, b.booking_id, b.client_id, vs.price, b.service_id
                          FROM bookings b
                          JOIN vendor_services vs ON b.vendor_id = vs.vendor_id
                          WHERE b.booking_id = :booking_id";
            $selectStmt = $pdo->prepare($selectSql);
            $selectStmt->bindParam(':booking_id', $booking_id, PDO::PARAM_INT);
            $selectStmt->execute();
            $booking = $selectStmt->fetch(PDO::FETCH_ASSOC);

            // Get current date
            $currentDate = date('Y-m-d');

            // Insert transaction into transactions table
            $insertSql = "INSERT INTO transactions 
                          (vendor_id, booking_id, client_id, service_id, transaction_date, amount, status, payment_method, description)
                          VALUES
                          (:vendor_id, :booking_id, :client_id, :service_id, :transaction_date, :amount, :status, :payment_method, :description)";
            $insertStmt = $pdo->prepare($insertSql);
            $insertStmt->bindValue(':vendor_id', $booking['vendor_id'], PDO::PARAM_INT);
            $insertStmt->bindValue(':booking_id', $booking['booking_id'], PDO::PARAM_INT);
            $insertStmt->bindValue(':client_id', $booking['client_id'], PDO::PARAM_INT);
            $insertStmt->bindValue(':service_id', $booking['service_id'], PDO::PARAM_INT);
            $insertStmt->bindValue(':transaction_date', $currentDate, PDO::PARAM_STR); // Use $currentDate variable
            $insertStmt->bindValue(':amount', $booking['price'], PDO::PARAM_STR); // Use price from vendor_services
            $insertStmt->bindValue(':status', 'Completed', PDO::PARAM_STR); // Example initial status for a successful payment
            $insertStmt->bindValue(':payment_method', 'M-Pesa', PDO::PARAM_STR); // Example payment method
            $insertStmt->bindValue(':description', 'Payment for booking ID ' . $booking['booking_id'], PDO::PARAM_STR);
            $insertStmt->execute();

            echo "Payment status updated successfully and transaction created.";
        } elseif ($rowCount > 0) {
            echo "Payment status updated successfully.";
        } else {
            echo "No rows updated. Possibly no matching booking_id found.";
        }

        // Commit transaction
        $pdo->commit();
        
    } catch (PDOException $e) {
        // Rollback transaction on error
        $pdo->rollback();
        echo "Error updating payment status or creating transaction: " . $e->getMessage();
    } finally {
        // Close connection
        unset($pdo);
    }
}

?>
