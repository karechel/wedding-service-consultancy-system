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

// Get user_id from session (assuming it represents the vendor's user_id)
$vendor_user_id = $_SESSION['user_id'];

// Prepare SQL to fetch messages for the vendor
$sql = "SELECT message FROM conversations WHERE vendor_id = :vendor_user_id ORDER BY start_date DESC";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':vendor_user_id', $vendor_user_id, PDO::PARAM_INT);
$stmt->execute();
$messages = $stmt->fetchAll(PDO::FETCH_COLUMN); // Fetch only the 'message' column

// Output messages as JSON
echo json_encode($messages);
?>
