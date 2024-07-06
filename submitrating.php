<?php
require 'connection.php'; // Include your database connection script

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve data from the form submission
    $booking_id = $_POST['booking_id'];
    $rating = $_POST['rating'];
    $comment = $_POST['comment'];
    $vendor_id = $_POST['vendor_id'];
    $client_id = $_POST['client_id'];

    try {
        // Prepare and execute SQL INSERT statement
        $stmt = $pdo->prepare("INSERT INTO feedback (booking_id, rating, comment, vendor_id, client_id ) VALUES (:booking_id, :rating, :comment, :vendor_id, :client_id)");
        $stmt->execute([
            'booking_id' => $booking_id,
            'rating' => $rating,
            'comment' => $comment,
            'vendor_id'=> $vendor_id,
            'client_id'=> $client_id
        ]);

        // Redirect or display success message
        echo json_encode(['status' => 'success', 'message' => 'Feedback submitted successfully']);
    } catch (PDOException $e) {
        echo json_encode(['status' => 'error', 'message' => 'Failed to submit feedback: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}
?>
