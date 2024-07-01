<?php
session_start();
include 'connection.php'; // Ensure connection to the database

$rows = [];
try {
    // SQL query to select data from the tables
    $sql = "SELECT services.service_name, vendor_services.price, vendor_services.rating, vendors.location, vendors.vendor_name, vendor_services.image, vendors.vendor_id, vendor_services.vendor_service_id, services.description
            FROM services
            JOIN vendor_services ON services.service_id = vendor_services.service_id
            JOIN vendors ON vendor_services.vendor_id = vendors.vendor_id";
    
    // Execute query
    $stmt = $pdo->query($sql);
    
    // Fetch all rows as associative array
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
        <link rel="stylesheet" href="style2.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Parisienne&display=swap" rel="stylesheet">
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    </head>
    <body>
    <?php include 'homeheader.php'; ?>
        <div class="background">
          <div class="container">
            <div class="content">
                <div class="welcome-banner">
                    <div class="welcome-text">
                    <h1>Welcome to WeddingHub</h1>
                    <span >Kenya's No.1 one stop shop for wedding consultancy services</span>
                </div>
                    <form action="">
                    <div class="search-bar">
                        <div class="search-input">
                            <span >What are you looking for?</span>
                        </div>
                        <div class="search-input">
                            <label for="Category">Category</label>
                            <select name="" id=""></select>
                        </div>
                        <div class="search-input">
                            <label for="Location">Location</label>
                            <select name="" id=""></select>
                        </div>
                        <div class="search-btn">
                            <button class="btn"><i class='bx bx-search'></i>   Search</button>
                        </div>
                    </div>
                </form>
                </div>
                <div class="vendor-content">
                    <h1>Vendors</h1>
                    <div class="row">
                    <?php $count = 4; ?>
                    <?php foreach ($rows as $row): ?> 
                     <div class="vendor-blocks">
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
                                    <!-- <a href=""><img src="Images/venue.jpg" alt=""></a> -->
                                       <div class="vendor">
                                        <div class="author-image">
                                            <a href=""><img src="Images/pp.jpeg" alt=""></a>
                                            <p class="name"><?php echo $row['vendor_name']; ?></p>
                                        </div>
                                    </div>
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
                                                                             </div>
                                    </div>
                            </div>                  
        
                            </div>
                            <?php $count--; ?>
                     <?php if ($count == 0) break; ?>
                    <?php endforeach; ?>
                        </div>
                        
                       
                    </div>
                
                </div>
                </div>
                <div class="categories-content">
                    <h1>Categories</h1>
                    <div class="row">
                    <?php $count = 4; ?>
                    <?php foreach ($rows as $row): ?> 
                       <div class="category-blocks">
                        <div class="image">
                            <a href=""><img src="Images/venue.jpg" alt=""></a>
                </div>
                <div class="details">
                    <h3><?php echo $row['service_name']; ?></h3>
                    <p><?php echo $row['description']; ?></p>
                </div>                  

                    </div>
                    <?php $count--; ?>
            <?php if ($count == 0) break; ?>
        <?php endforeach; ?>
          
                </div>
                <div class="row">
                    <div class="category-names">
                    <div class="category-name">
                        <span>Wedding Videographers</span>
                    </div>
                    <div class="category-name">
                        <span>Wedding Hair and Makeup</span>
                    </div>
                    <div class="category-name">
                        <span>Wedding Rentals</span>
                    </div>
                    <div class="category-name">
                        <span>Wedding cakes</span>
                    </div>
                    <div class="category-name">
                        <span>Wedding DJs</span>
                    </div>
                    <div class="category-name">
                        <span>Wedding Transport</span>
                    </div>
                </div>
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
          
        
        <script src="script.js"></script>
    </div>
    </body>
</html>