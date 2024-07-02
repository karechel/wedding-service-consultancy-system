<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vendor Profile Page</title>
    <link rel="stylesheet" href="style2.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
    <?php include 'resuableComponents\clientHeader.php' ?>
    <?php
    include 'connection.php'; // Ensure connection to the database
    if(isset($_GET['vendor_id'])) {
        $vendor_id = $_GET['vendor_id'];
        // Use $vendor_id to fetch the details of the specific vendor from the database
    } else {
        // Handle the case where vendor_id is not provided
        echo "Vendor ID not provided.";
    }
    
    try {
        // SQL query to select data from the tables
        $sql = "SELECT vendors.vendor_name, vendors.category, vendors.location, vendor_services.rating, vendor_services.price, vendors.description, vendor_services.image, vendor_services.other_service_details, vendors.vendor_id
                FROM vendor_services
                JOIN vendors ON vendor_services.vendor_id = vendors.vendor_id
                WHERE vendor_services.vendor_id = $vendor_id";

        // Execute query
        $stmt = $pdo->query($sql);

        // Fetch the first row as an associative array
        $vendorDetails = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        // Handle errors gracefully
        echo "Error: " . $e->getMessage();
    }
    ?>
    <div class="vendor-content">
        <div class="gallery">
      
                <?php
        $imageData = base64_encode(stream_get_contents($vendorDetails['image']));
        echo '<img class="main-image" src="data:image/jpeg;base64,' . $imageData . '" alt="Uploaded Image">';
        ?>

  
            <div class="sec-images">
                <div class="sec_images_one">
                <img class="sec-image" src="Images/bg1.jpg" alt="Vendor Image 2">
                <img class="sec-image" src="Images/bg1.jpg" alt="Vendor Image 3">
                </div>
                <div class="sec_images_two">
                <img class="sec-image" src="Images/bg1.jpg" alt="Vendor Image 4">
                <img class="sec-image" src="Images/bg1.jpg" alt="Vendor Image 5">
                </div>
            </div>
        </div>
        <div class="all-details">
            <div class="details vendor_name"><?php echo $vendorDetails['vendor_name']; ?></div>
            <div class="details"><?php echo $vendorDetails['category']; ?></div>
            <div class="details"><?php echo $vendorDetails['location']; ?></div>
            <div class="details"><?php echo $vendorDetails['rating']; ?></div>
            <div class="details"><?php echo $vendorDetails['price']; ?></div>
            <form action="books_test.php" method="GET">
            <input type="hidden" name="vendor_id" value="<?php echo $vendorDetails['vendor_id']; ?>">
            <button type="submit"> Book Now</button>
            </form>
        </div>
    </div>
    <div class="description-content">
        <div class="des_heading"><p>About the Vendor<p></div>
        <div class="details des"><?php echo $vendorDetails['description']; ?></div>
    </div>
    <div class="service-content">
        <div class="service_heading"><p>About the Service<p></div>
        <div class="details des"><?php echo $vendorDetails['other_service_details']; ?></div>
    </div>
    <?php include 'resuableComponents\footer.php' ?>
    <!-- <script>
        function bookNow() {
            // Redirect to the service booking page
            window.location.href = "book.php";
        }
    </script> -->
</body>
</html>
