<?php
session_start();
include 'connection.php'; // Ensure connection to the database

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $client_id = $_SESSION['user_id']; // Fetch client_id from session
    $vendor_id = $_POST['vendor_id'];
    $service_id = $_POST['service_id'];
    $action = $_POST['action'];

    try {
        if ($action == 'add') {
            // Add to favourites
            $stmt = $pdo->prepare("INSERT INTO favourites (client_id, vendor_id, vendor_service_id) VALUES (:client_id, :vendor_id, :vendor_service_id)");
            $stmt->bindParam(':client_id', $client_id, PDO::PARAM_INT);
            $stmt->bindParam(':vendor_id', $vendor_id, PDO::PARAM_INT);
            $stmt->bindParam(':vendor_service_id', $service_id, PDO::PARAM_INT);
            $stmt->execute();
            echo "Added to favourites.";
        } elseif ($action == 'remove') {
            // Remove from favourites
            $stmt = $pdo->prepare("DELETE FROM favourites WHERE client_id = :client_id AND vendor_id = :vendor_id AND vendor_service_id = :vendor_service_id");
            $stmt->bindParam(':client_id', $client_id, PDO::PARAM_INT);
            $stmt->bindParam(':vendor_id', $vendor_id, PDO::PARAM_INT);
            $stmt->bindParam(':vendor_service_id', $service_id, PDO::PARAM_INT);
            $stmt->execute();
            echo "Removed from favourites.";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Invalid request method.";
}
?>
