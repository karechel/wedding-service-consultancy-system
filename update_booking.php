<?php
require 'connection.php'; // Ensure this file is in the same directory or adjust the path accordingly

if (isset($_POST['booking_id']) && isset($_POST['status']) && isset($_POST['payment_status'])) {
    $bookingId = $_POST['booking_id'];
    $status = $_POST['status'];
    $paymentStatus = $_POST['payment_status'];

    try {
        $stmt = $pdo->prepare("UPDATE bookings SET status = :status, payment_status = :payment_status WHERE booking_id = :booking_id");
        $stmt->execute([
            'status' => $status,
            'payment_status' => $paymentStatus,
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
