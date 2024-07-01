<?php
include 'connection.php'; // Ensure connection to the database

// Retrieve the vendor ID from the request
$data = json_decode(file_get_contents('php://input'), true);
$vendorId = $data['vendor_id'] ?? null;

if ($vendorId === null) {
    echo json_encode(['status' => 'error', 'message' => 'No vendor ID provided']);
    exit;
}

try {
    // Begin transaction
    $pdo->beginTransaction();

    // Delete from vendor_services first due to foreign key constraint
    $stmt = $pdo->prepare('DELETE FROM vendor_services WHERE vendor_id = :vendor_id');
    $stmt->execute(['vendor_id' => $vendorId]);

    // Delete from vendors table
    $stmt = $pdo->prepare('DELETE FROM vendors WHERE vendor_id = :vendor_id');
    $stmt->execute(['vendor_id' => $vendorId]);

    // Commit transaction
    $pdo->commit();

    echo json_encode(['status' => 'success']);
} catch (PDOException $e) {
    // Rollback transaction in case of error
    $pdo->rollBack();
    echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
}
?>
