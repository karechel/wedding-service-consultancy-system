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
$sql = "SELECT clients.first_name, clients.last_name, users.email, clients.contact_number
        FROM users 
        JOIN clients ON users.user_id = clients.user_id
        WHERE users.user_id = :user_id";

$stmt = $pdo->prepare($sql);
$stmt->execute(['user_id' => $user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Check if user data is retrieved successfully
if (!$user) {
    // Handle the case where user data is not found
    // You can redirect the user to an error page or display an error message
    echo "User data not found.";
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
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
        <input type="hidden" name="book" value="1">
            <!-- Contact Information -->
            <h2>Contact Information</h2>
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="<?php echo $user['first_name']; ?>" required>
            <label for="email">Email Address:</label>
            <input type="email" id="email" name="email" value="<?php echo $user['email']; ?>" required>
            <label for="phone">Phone Number:</label>
            <input type="tel" id="phone" name="phone" value="<?php echo $user['contact_number']; ?>" required>
            <label for="location">Location:</label>
            <input type="text" id="text" name="location">

            <!-- Booking Details -->
            <h2>Booking Details</h2>
            <label for="date">Preferred Date:</label>
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
            <label for="event theme">Event Theme:</label>
            <textarea id="event" name="event theme"></textarea>


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
