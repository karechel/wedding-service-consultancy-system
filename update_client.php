<?php
session_start();
require_once 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $client_id = $_POST['client_id'];
    $updateFields = [];

    // Collect fields to update based on what's submitted
    if (!empty($_POST['first_name'])) {
        $updateFields[] = "first_name = :first_name";
        $first_name = $_POST['first_name'];
    }
    if (!empty($_POST['last_name'])) {
        $updateFields[] = "last_name = :last_name";
        $last_name = $_POST['last_name'];
    }
    if (!empty($_POST['contact_number'])) {
        $updateFields[] = "contact_number = :contact_number";
        $contact_number = $_POST['contact_number'];
    }
    if (!empty($_POST['location'])) {
        $updateFields[] = "location = :location";
        $location = $_POST['location'];
    }
    if (!empty($_POST['wedding_date'])) {
        $updateFields[] = "wedding_date = :wedding_date";
        $wedding_date = $_POST['wedding_date'];
    }

    // Update the client data in the database
    if (!empty($updateFields)) {
        $sql = "UPDATE clients SET " . implode(", ", $updateFields) . " WHERE client_id = :client_id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':client_id', $client_id);

        // Bind parameters for each field that needs updating
        if (isset($first_name)) {
            $stmt->bindParam(':first_name', $first_name);
        }
        if (isset($last_name)) {
            $stmt->bindParam(':last_name', $last_name);
        }
        if (isset($contact_number)) {
            $stmt->bindParam(':contact_number', $contact_number);
        }
        if (isset($location)) {
            $stmt->bindParam(':location', $location);
        }
        if (isset($wedding_date)) {
            $stmt->bindParam(':wedding_date', $wedding_date);
        }

        $stmt->execute();
    }

    // Redirect back to the page where the edit was initiated
    header("Location: ClientM.php"); // Replace with actual page URL
    exit();
}
?>
