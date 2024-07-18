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
        $sql = "SELECT vendors.vendor_name, vendors.category, vendors.location, vendor_services.rating, vendor_services.price, vendors.description, vendor_services.image, vendor_services.image1,vendor_services.image2, vendor_services.image3, vendor_services.image4, vendor_services.other_service_details, vendors.vendor_id
                FROM vendor_services
                JOIN vendors ON vendor_services.vendor_id = vendors.vendor_id
                WHERE vendor_services.vendor_id = $vendor_id";

        // Execute query
        $stmt = $pdo->query($sql);

        // Fetch the first row as an associative array
        $vendorDetails = $stmt->fetch(PDO::FETCH_ASSOC);

        $feedbackQuery = "SELECT feedback.rating, feedback.comment, DATE(feedback.timestamp) AS comment_date,clients.first_name, clients.last_name
                      FROM feedback
                      JOIN clients ON feedback.client_id = clients.client_id
                      WHERE feedback.vendor_id = :vendor_id";

    // Prepare and execute query to fetch ratings and comments
    $stmt = $pdo->prepare($feedbackQuery);
    $stmt->bindParam(':vendor_id', $vendor_id, PDO::PARAM_INT);
    $stmt->execute();
    $feedback = $stmt->fetchAll(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
        // Handle errors gracefully
        echo "Error: " . $e->getMessage();
    }
    ?>
    <div class="vendor-content">
    <button class="back-btn" type="button" onclick="goBack()"><i class='bx bx-arrow-back'></i> Back</button>
        <div class="gallery">
      
                <?php
        $imageData = base64_encode(stream_get_contents($vendorDetails['image']));
        echo '<img class="main-image" src="data:image/jpeg;base64,' . $imageData . '" alt="Uploaded Image">';
        ?>

  
<div class="sec-images">
                <?php if (!empty($vendorDetails['image1'])): ?>
                    <?php $imageData1 = base64_encode(stream_get_contents($vendorDetails['image1'])); ?>
                    <img class="sec-image" src="data:image/jpeg;base64,<?= $imageData1 ?>" alt="Uploaded Image">
                <?php endif; ?>
                <?php if (!empty($vendorDetails['image2'])): ?>
                    <?php $imageData2 = base64_encode(stream_get_contents($vendorDetails['image2'])); ?>
                    <img class="sec-image" src="data:image/jpeg;base64,<?= $imageData2 ?>" alt="Uploaded Image">
                <?php endif; ?>
                <?php if (!empty($vendorDetails['image3'])): ?>
                    <?php $imageData3 = base64_encode(stream_get_contents($vendorDetails['image3'])); ?>
                    <img class="sec-image" src="data:image/jpeg;base64,<?= $imageData3 ?>" alt="Uploaded Image">
                <?php endif; ?>
                <?php if (!empty($vendorDetails['image4'])): ?>
                    <?php $imageData4 = base64_encode(stream_get_contents($vendorDetails['image4'])); ?>
                    <img class="sec-image" src="data:image/jpeg;base64,<?= $imageData4 ?>" alt="Uploaded Image">
                <?php endif; ?>
            </div>

        </div>
        <div class="all-details">
        <div class="category details"><?php echo $vendorDetails['category']; ?></div>
        <ul class="rating">
                        <?php for ($i = 0; $i < $vendorDetails['rating']; $i++): ?>
                            <li>
                                <i class='bx bxs-star' style='color:#ddc04c'></i>
                            </li>
                        <?php endfor; ?>
                    </ul>
        <div class="price details">Price: KSH <?php echo $vendorDetails['price']; ?></div>
        <form action="books_test.php" method="GET">
            <input type="hidden" name="vendor_id" value="<?php echo $vendorDetails['vendor_id']; ?>">
            <button type="submit"> Book Now</button>
            </form>
            <form id="vendorForm"  method="GET">
  <input type="hidden" id="vendor_id" name="vendor_id" value="<?php echo $vendorDetails['vendor_id']; ?>">
  <button type="button" id="btnOpenMessageModal">Message Modal</button>
</form>

<!-- Modal -->
<div id="messageModal" class="messageModal">
  <!-- Modal content -->
  <div class="modal-content">
    <span class="close">&times;</span>
    <h2>Chat with Vendor</h2>
    <div id="messageHistory" class="message-history">
      <!-- Display message history here -->
    </div>
    <form id="messageForm" action="insert_conversation.php" method="POST">
      <!-- Hidden input to store vendor_id -->
      <input type="hidden" id="modal_vendor_id" name="vendor_id" value="">
      <!-- Hidden input to store client_id (will be set dynamically by PHP) -->
      <input type="hidden" id="client_id" name="client_id" value="<?= $client_id ?? '' ?>">
      <!-- Textarea for message input -->
      <textarea id="messageInput" name="message" placeholder="Type your message..." ></textarea>
      <!-- Submit button -->
      <button type="submit">Send</button>
    </form>
  </div>
</div>
           <div class="bottom-details">
        <div class="details vendor_name">Vendor: <?php echo $vendorDetails['vendor_name']; ?></div>
        <div class="details">Location: <?php echo $vendorDetails['location']; ?></div>
           
        </div>           
        </div>
    </div>
    <div class="more-details">
        <div class="buttons">
            <button class="tab-button" onclick="showTab('description')">DESCRIPTION</button>
            <button class="tab-button" onclick="showTab('vendor-info')">VENDOR INFO</button>
            <button class="tab-button" onclick="showTab('reviews')">REVIEWS</button>
        </div>
        <div class="tab-content" id="description">
            <p> <div class="details des"><?php echo $vendorDetails['other_service_details']; ?></div></p>
        </div>
        <div class="tab-content" id="vendor-info" style="display:none;">
            <p>  <div class="details des"><?php echo $vendorDetails['description']; ?></div></p>
        </div>
        <div class="tab-content" id="reviews" style="display:none;">
            
        
        <?php foreach ($feedback as $comment): ?>
           
            <p>  <div class="details des">
         
               <div class="top-content"> <?php echo $comment['first_name']; ?>
               <small class="timestamp"> <?php echo date('d M Y', strtotime($comment['comment_date'])); ?></small></div>

            <ul class="rating">
                        <?php for ($i = 0; $i < $comment['rating']; $i++): ?>
                            <li>
                                <i class='bx bxs-star' style='color:#ddc04c'></i>
                            </li>
                        <?php endfor; ?>
                    </ul>
                   
                    
                    <strong></strong> <?php echo $comment['comment']; ?><br>
                    </div></p>
           
              
                
              
           
        <?php endforeach; ?>
 
        </div>
    </div>
    <?php include 'resuableComponents\footer.php' ?>
    <!-- <script>
        function bookNow() {
            // Redirect to the service booking page
            window.location.href = "book.php";
        }
    </script> -->
    <script src="moreDetails.js"></script>
    <script src="message.js"></script>
    <script src="back.js"></script>
</body>
</html>
