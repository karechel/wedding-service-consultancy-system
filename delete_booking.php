<?php
include 'connection.php'; // Ensure connection to the database

// Retrieve the booking ID from the request
$data = json_decode(file_get_contents('php://input'), true);
$bookingId = $data['booking_id'] ?? null;

if ($bookingId === null) {
    echo json_encode(['status' => 'error', 'message' => 'No booking ID provided']);
    exit;
}

try {
    // Begin transaction
    $pdo->beginTransaction();

    // Delete from event_details first due to foreign key constraint
    $stmt = $pdo->prepare('DELETE FROM event_details WHERE booking_id = :booking_id');
    $stmt->execute(['booking_id' => $bookingId]);

    // Delete from bookings table
    $stmt = $pdo->prepare('DELETE FROM bookings WHERE booking_id = :booking_id');
    $stmt->execute(['booking_id' => $bookingId]);

    // Commit transaction
    $pdo->commit();

    echo json_encode(['status' => 'success']);
} catch (PDOException $e) {
    // Rollback transaction in case of error
    $pdo->rollBack();
    echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
}
?>
