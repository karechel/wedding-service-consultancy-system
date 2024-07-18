<?php
include 'connection.php'; // Ensure connection to the database

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $vendorId = $_POST['vendor_id'];
    $vendorName = $_POST['vendor_name'];
    $category = $_POST['category'];
    $location = $_POST['location'];
    $price = $_POST['price'];
    $rating = $_POST['rating'];

    try {
        // Update vendors table
        $sqlVendor = "UPDATE vendors SET vendor_name = :vendor_name, category = :category, location = :location WHERE vendor_id = :vendor_id";
        $stmtVendor = $pdo->prepare($sqlVendor);
        $stmtVendor->bindParam(':vendor_name', $vendorName, PDO::PARAM_STR);
        $stmtVendor->bindParam(':category', $category, PDO::PARAM_STR);
        $stmtVendor->bindParam(':location', $location, PDO::PARAM_STR);
        $stmtVendor->bindParam(':vendor_id', $vendorId, PDO::PARAM_INT);
        $stmtVendor->execute();

        // Update vendor_services table
        $sqlServices = "UPDATE vendor_services SET price = :price, rating = :rating WHERE vendor_id = :vendor_id";
        $stmtServices = $pdo->prepare($sqlServices);
        $stmtServices->bindParam(':price', $price, PDO::PARAM_STR);
        $stmtServices->bindParam(':rating', $rating, PDO::PARAM_STR);
        $stmtServices->bindParam(':vendor_id', $vendorId, PDO::PARAM_INT);
        $stmtServices->execute();

        // Redirect back to the vendor management page after successful update
        header('Location: vendorsM.php');
        exit();

    } catch (PDOException $e) {
        // Handle database errors
        echo "Error: " . $e->getMessage();
    }
} else {
    // Handle invalid HTTP method
    echo "Invalid request method!";
}
?>
