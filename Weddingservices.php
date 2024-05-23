<?php
include 'connection.php'; // Ensure connection to the database
 
$rows = [];
try {
    // SQL query to select data from the tables
    $sql = "SELECT services.service_name, vendor_services.price, vendor_services.rating ,vendors.location,vendor_services.image
    FROM services
    JOIN vendor_services ON services.service_id = vendor_services.service_id
    JOIN vendors ON vendor_services.vendor_id=vendors.vendor_id
    WHERE services.service_name = 'Photography and Videography'";
   

    // Execute query
    $stmt = $pdo->query($sql);
    
        // Fetch all rows as associative array
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
   

    // Debug: Check if $rows is populated
    // var_dump($rows);

} catch (PDOException $e) {
    // Handle errors gracefully
    echo "Error: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Website with Login and Registration Form</title>
        <link rel="stylesheet" href="style3.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Parisienne&display=swap" rel="stylesheet">
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    </head>
    <body>
        <div class="background">
        <header class="header">
            <nav class="navbar">
                <a href="home.html">Home</a>
                <a href="#">About</a>
                <a href="#">Contact</a>
               <a href="Weddingservices.php"> Wedding services</a>
               <div id="servicesDropdown">
                <select id="servicesSelect">
                    <option value="Venue Booking">Venue</option>
                    <option value="catering">catering</option>
                </select>
               </div>
               <a href="Weddingvendors.php">Vendors</a>
                <!-- <div class="sign-in-up">
                    <a href="#" class="login-link">Sign In</a>
                    <a href="#" class="register-link">Sign Up</a>
                </div> -->
            </nav>
         
          </header>
       
          <div class="container">
            <div class="content">
             
                <div class="filter-city">
                    <label for="search">Search:</label>
                    <input type="search" name="" id="search" placeholder="City/ Town">
                </div>
                <div class="service-content" id="service-content">
              
                    <div class="row">
                    <?php $count = 0; ?>
                    <?php foreach ($rows as $row): ?> 
                        <?php if ($count % 4 == 0 && $count != 0): ?>
                </div><div class="row">
            <?php endif; ?>
                    <div class="service-blocks">
                        <div class="image">
                       <?php
                    if ($row && !empty($row['image'])) {
                        // Encode the image data as a base64 string
                        $imageData = base64_encode(stream_get_contents($row['image']));
                        echo '<img src="data:image/jpeg;base64,' . $imageData . '" alt="Uploaded Image" class="uploaded-image"> ';
                        
                    } else {
                        echo "Image not found or empty.";
                    }
                     ?>  
                    
                            
                            <i class="bx bx-heart" style="cursor: pointer;" onclick="toggleHeart(this)"></i>
                 
                    </div>
                    <div class="details">
                        <div class="top-details">
                            <h3 class="category-title"><?php echo $row['service_name']; ?></h3>
                           
                            <ul class="rating">
                                <li>
                                    <i class='bx bxs-star' style='color:#ddc04c'  ></i> <?php echo $row['rating']; ?>
                                    <p float-right><?php echo $row['location']; ?>, Kenya</p>
                                </li>
                               
                                
                            </div>
                            <div class="bottom-details">
                                <span>Price: Ksh <?php echo $row['price']; ?></span>
                                <div class="block-buttons">
                                    <button class=" btn"><a href="book.html">Book Now</a></button>
                                </div>
                            </div>
                    </div>                  

                    </div>
                    <?php $count++; ?>
                                      <?php endforeach; ?>   
                </div>
                </div>
                <footer class="footer">
                    <div class="footer-heading">
                        <h3>Start Today</h3>
                    </div>
                    <div class="footer-buttons">
                        <button class="btn">Add Listing</button>
                        <button class="btn">Browse Listings</button>
                    </div>
                    <div class="footer-columns">
                        <div class="footer-column">
                            <h4>Locations</h4>
                            <ul>
                                <li><a href="#">Location 1</a></li>
                                <li><a href="#">Location 2</a></li>
                                <!-- Add more locations as needed -->
                            </ul>
                        </div>
                        <div class="footer-column">
                            <h4>Quick Links</h4>
                            <ul>
                                <li><a href="#">Link 1</a></li>
                                <li><a href="#">Link 2</a></li>
                                <!-- Add more quick links as needed -->
                            </ul>
                        </div>
                        <div class="footer-column">
                            <h4>Contacts</h4>
                            <ul>
                                <li>Email: info@example.com</li>
                                <li>Phone: +1234567890</li>
                                <!-- Add more contact information as needed -->
                            </ul>
                        </div>
                    </div>
                </footer>
        </div>
       
          </div>
          
        
        <script src="script.js">
          
        </script>
    </div>
</div>
    </body>
</html>