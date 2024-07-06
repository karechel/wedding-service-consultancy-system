<?php
require 'connection.php'; 

if (isset($_POST['booking_id']) && isset($_POST['status'])) {
    $bookingId = $_POST['booking_id'];
    $status = $_POST['status'];

    try {
        $stmt = $pdo->prepare("UPDATE bookings SET status = :status WHERE booking_id = :booking_id");
        $stmt->execute([
            'status' => $status,
            'booking_id' => $bookingId
        ]);

        echo json_encode(['status' => 'success']);
    } catch (PDOException $e) {
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Incomplete data provided']);
}
?>
