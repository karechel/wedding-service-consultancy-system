<?php
session_start();
require 'connection.php'; // Include your database connection file

if(isset($_POST['add-service'])) {
    // Check if at least one image file is uploaded
    $imageErrors = array_filter($_FILES['images']['error'], function($error) {
        return $error === UPLOAD_ERR_OK;
    });

    if (!empty($imageErrors)) {
        // Read image data
        $images = [];
        for ($i = 0; $i <= 4; $i++) {
            if (isset($_FILES['images']['tmp_name'][$i]) && $_FILES['images']['error'][$i] === UPLOAD_ERR_OK) {
                $images["image$i"] = file_get_contents($_FILES['images']['tmp_name'][$i]);
            } else {
                $images["image$i"] = null;
            }
        }

        // Get other form data
        $price = $_POST['price'];
        $description = $_POST['description'];
        $service_id = $_POST['service_id']; // Get the service_id from the form

        // Get vendor_id based on the logged-in user
        $user_id = $_SESSION['user_id'];
        $vendor_stmt = $pdo->prepare("SELECT vendor_id FROM vendors WHERE user_id = :user_id");
        $vendor_stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $vendor_stmt->execute();
        $vendor_id = $vendor_stmt->fetchColumn();

        if ($vendor_id) {
            // Prepare SQL statement
            $sql = "INSERT INTO vendor_services (vendor_id, service_id, price, other_service_details, image, image1, image2, image3, image4) VALUES (:vendor_id, :service_id, :price, :description, :image, :image1, :image2, :image3, :image4)";
            $stmt = $pdo->prepare($sql);

            // Bind parameters
            $stmt->bindParam(':vendor_id', $vendor_id, PDO::PARAM_INT);
            $stmt->bindParam(':service_id', $service_id, PDO::PARAM_INT);
            $stmt->bindParam(':price', $price);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':image', $images['image0'], PDO::PARAM_LOB);
            $stmt->bindParam(':image1', $images['image1'], PDO::PARAM_LOB);
            $stmt->bindParam(':image2', $images['image2'], PDO::PARAM_LOB);
            $stmt->bindParam(':image3', $images['image3'], PDO::PARAM_LOB);
            $stmt->bindParam(':image4', $images['image4'], PDO::PARAM_LOB);

            // Execute the statement
            if ($stmt->execute()) {
                echo "File uploaded successfully.";
            } else {
                echo "Error uploading file.";
            }
        } else {
            echo "Vendor ID not found for the logged-in user.";
        }
    } else {
        echo "No file uploaded or error occurred while uploading.";
    }
}
?>
