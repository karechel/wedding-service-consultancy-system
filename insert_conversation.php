<?php
// Include your database connection file (e.g., connection.php)
include 'connection.php';

// Start session if not already started
session_start();

// Check if user is logged in (you may have your own authentication logic)
if (!isset($_SESSION['user_id'])) {
    // Redirect or handle unauthorized access
    exit("Unauthorized access");
}

// Get user_id from session
$user_id = $_SESSION['user_id'];

// Prepare SQL to select client_id based on user_id
$sql = "SELECT client_id FROM clients WHERE user_id = :user_id";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$stmt->execute();
$client_id = $stmt->fetchColumn(); // Fetch client_id

if (!$client_id) {
    // Handle case where client_id is not found
    exit("Client ID not found for user ID: " . $user_id);
}

// Get vendor_id and message from form input
$vendor_id = $_POST['vendor_id'];
$message = $_POST['message'];

// Insert into conversations table
$sqlInsert = "INSERT INTO conversations (vendor_id, client_id, message, start_date) VALUES (:vendor_id, :client_id, :message, NOW())";
$stmtInsert = $pdo->prepare($sqlInsert);
$stmtInsert->bindParam(':vendor_id', $vendor_id, PDO::PARAM_INT);
$stmtInsert->bindParam(':client_id', $client_id, PDO::PARAM_INT);
$stmtInsert->bindParam(':message', $message, PDO::PARAM_STR);

// Execute the statement
if ($stmtInsert->execute()) {
    // Insert successful
    echo "Conversation started successfully";
} else {
    // Error handling (optional)
    echo "Error starting conversation";
}
?>
