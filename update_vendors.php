<?php
include 'connection.php'; // Ensure connection to the database

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $vendorId = $_POST['vendor_id'] ?? null;
    $status = $_POST['status'] ?? null;
    $paymentStatus = $_POST['payment_status'] ?? null;

    if ($vendorId === null || $status === null || $paymentStatus === null) {
        echo json_encode(['status' => 'error', 'message' => 'Missing required fields']);
        exit;
    }

    try {
        $stmt = $pdo->prepare('UPDATE vendors SET status = :status, payment_status = :payment_status WHERE vendor_id = :vendor_id');
        $stmt->execute([
            'status' => $status,
            'payment_status' => $paymentStatus,
            'vendor_id' => $vendorId
        ]);

        echo json_encode(['status' => 'success']);
    } catch (PDOException $e) {
        echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}
?>
