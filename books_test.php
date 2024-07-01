<?php
// Start session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect the user to the login page if not logged in
    header("Location: login.php");
    exit();
}

// Include database connection file
include 'connection.php';

// Retrieve user information from the database based on the user_id stored in the session
$user_id = $_SESSION['user_id'];
if (isset($_GET['vendor_id'])) {
    $vendor_id = $_GET['vendor_id'];
} else {
    // Handle error
    echo "Vendor ID is missing.";
    exit();
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wedding Service Booking Form</title>
    <link rel="stylesheet" href="style2.css">
 
</head>
<body>
    <div class="booking_container">
        <h1>Wedding Service Booking Form</h1>
        <form action="submit_booking.php" method="POST">
            <input type="hidden" name="vendor_id" value="<?php echo $vendor_id; ?>">
            <input type="hidden" name="client_id" value="<?php echo $user_id; ?>">

            <!-- Booking Details -->
            <h2>Booking Details</h2>
            <label for="event_date">Preferred Date:</label>
            <input type="date" id="event_date" name="event_date" required>
            <label for="time">Preferred Time:</label>
            <input type="time" id="time" name="event_time" required>
            <label for="duration">Duration (hours):</label>
            <input type="number" id="duration" name="duration" min="1">
            <label for="attendees">Number of Attendees:</label>
            <input type="number" id="attendees" name="num_guests" min="1">

            <!-- Additional Preferences or Requirements -->
            <h2>Additional Preferences or Requirements</h2>
            <label for="requests">Special Requests:</label>
            <textarea id="requests" name="requests"></textarea>
            <label for="customizations">Customizations:</label>
            <textarea id="customizations" name="customizations"></textarea>
            <label for="event_theme">Event Theme:</label>
            <textarea id="event_theme" name="event_theme"></textarea>

            <!-- Booking Terms and Conditions -->
            <h2>Booking Terms and Conditions</h2>
            <label>
                <input type="checkbox" id="agree" name="agree" required>
                I agree to the terms and conditions.
            </label>

            <!-- Confirmation and Agreement -->
            <h2>Confirmation and Agreement</h2>
            <p>Please review your booking details before submitting.</p>
            <button type="submit">Submit Booking</button>
        </form>
    </div>
</body>
</html>
