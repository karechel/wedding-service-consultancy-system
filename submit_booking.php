<?php
include 'connection.php'; // Ensure connection to the database

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $vendor_id = $_POST['vendor_id'];
    $client_id = $_POST['client_id'];
    $event_date = $_POST['event_date'];
    $event_time = $_POST['event_time'];
    $duration = $_POST['duration'];
    $num_guests = $_POST['num_guests'];
    $requests = $_POST['requests'];
    $customizations = $_POST['customizations'];
    $event_theme = $_POST['event_theme'];
    $booking_date = date('Y-m-d');
    $status = 'Pending';
    $payment_status = 'Unpaid';

    try {
        // Fetch service_id based on vendor_id
        $stmt = $pdo->prepare("SELECT service_id FROM vendor_services WHERE vendor_id = :vendor_id");
        $stmt->bindParam(':vendor_id', $vendor_id);
        $stmt->execute();
        $service = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$service) {
            throw new Exception("Service ID not found for vendor ID: $vendor_id");
        }

        $service_id = $service['service_id'];

        // SQL query to insert booking
        $stmt = $pdo->prepare("INSERT INTO bookings (client_id, vendor_id, service_id, booking_date, status, payment_status, event_date,  created_at) VALUES (:client_id, :vendor_id, :service_id, :booking_date, :status, :payment_status, :event_date, NOW())");
        $stmt->bindParam(':client_id', $client_id);
        $stmt->bindParam(':vendor_id', $vendor_id);
        $stmt->bindParam(':service_id', $service_id);
        $stmt->bindParam(':booking_date', $booking_date);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':payment_status', $payment_status);
        $stmt->bindParam(':event_date', $event_date);
        $stmt->execute();

        // Get the last inserted booking_id
        $booking_id = $pdo->lastInsertId();

        // SQL query to insert event details
        $stmt = $pdo->prepare("INSERT INTO event_details (booking_id, event_time, num_guests, special_requirements, customization, event_theme, event_status, duration, created_at) VALUES (:booking_id, :event_time, :num_guests, :special_requirements, :customization, :event_theme, :event_status, :duration, NOW())");
        $stmt->bindParam(':booking_id', $booking_id);
        $stmt->bindParam(':event_time', $event_time);
        $stmt->bindParam(':num_guests', $num_guests);
        $stmt->bindParam(':special_requirements', $requests);
        $stmt->bindParam(':customization', $customizations);
        $stmt->bindParam(':event_theme', $event_theme);
        $stmt->bindParam(':event_status', $status);
        $stmt->bindParam(':duration', $duration);
        $stmt->execute();

        // Redirect to a confirmation page or display a success message
        echo "Booking successfully created!";
    } catch (PDOException $e) {
        // Handle errors gracefully
        echo "Error: " . $e->getMessage();
    } catch (Exception $e) {
        // Handle general errors gracefully
        echo "Error: " . $e->getMessage();
    }
} else {
    // Handle error
    echo "Invalid request method.";
}
?>
