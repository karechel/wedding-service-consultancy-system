<?php
// Include connection file
include 'connection.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Prepare and bind parameters
    $stmt = $pdo->prepare("UPDATE clients SET first_name=?, last_name=?, contact_number=?, location=?, wedding_date=? WHERE client_id=?");
    $stmt->bindParam(1, $_POST['first_name']);
    $stmt->bindParam(2, $_POST['last_name']);
    $stmt->bindParam(3, $_POST['contact_number']);
    $stmt->bindParam(4, $_POST['location']);
    $stmt->bindParam(5, $_POST['wedding_date']);
    $stmt->bindParam(6, $_POST['client_id']);

    // Execute the statement
    if ($stmt->execute()) {
        // Redirect to the client page
        header("Location: ClientM.php");
        exit();
    } else {
        echo "Error updating client";
    }
}
?>
