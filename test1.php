<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $booking_id = $_POST['booking_id'];
    $contactNumber = $_POST['contactNumber'];
    $amount = $_POST['amount'];
    
    // Example output or processing
    echo "Booking ID: " . htmlspecialchars($booking_id) . "<br>";
    echo "Contact Number: " . htmlspecialchars($contactNumber) . "<br>";
    echo "Amount: " . htmlspecialchars($amount) . "<br>";
}
?>
