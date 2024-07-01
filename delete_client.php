<?php
// Include connection file
include 'connection.php';

// Check if delete_id parameter exists in URL
if (isset($_GET['delete_id'])) {
    // Prepare and bind parameters
    $stmt = $pdo->prepare("DELETE FROM clients WHERE client_id=?");
    $stmt->bindParam(1, $_GET['delete_id']);

    // Execute the statement
    if ($stmt->execute()) {
        // Redirect to the client page
        header("Location: ClientM.php");
        exit();
    } else {
        echo "Error deleting client";
    }
}
?>
