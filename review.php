<?php
include 'connection.php'; // Ensure connection to the database
 
$rows = [];
try {
    // SQL query to select data from the tables
    $sql = "SELECT services.service_name, vendor_services.price, vendor_services.rating ,vendors.location,vendors.vendor_name,vendor_services.image, vendors.vendor_id
    FROM services
    JOIN vendor_services ON services.service_id = vendor_services.service_id
    JOIN vendors ON vendor_services.vendor_id=vendors.vendor_id";
    

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
    <style>
        .service-content .row {
    margin-top: 70px;
    display: flex;
    flex-direction: row;
    width: 100%;
    height: 150px;
    justify-content: center;
}
.service-blocks {
    background: white;
    width: 294px;
    height: 150px;
    margin-left: 50px;
    border-radius: 15px;
    box-shadow: 0 2px 8px #00000026;
}
.service-blocks .top-details {
    border-bottom: 1px solid #ccc;
    display: flex;
    justify-content: center;
}
.image {
    position: relative;
    margin-top: 10px;
}
.author-image {
    display: flex;
    flex-direction: row;
    margin-left: 5px;
    justify-content: center;
}
    </style>
    </head>
    <body>
        <div class="background">
        <?php include 'resuableComponents\clientHeader.php'; ?>
       
          <div class="container">
            <div class="content">
             
             
                <div class="service-content" id="service-content">
                    <div class="row">
                    <?php $count = 0; ?>
                    <?php foreach ($rows as $row): ?> 
                        <?php if ($count % 4 == 0 && $count != 0): ?>
                </div><div class="row">
            <?php endif; ?>
                    <div class="service-blocks">
                        <div class="image">
                                                 
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
                           
                                                       
                                
                            </div>
                            <div class="bottom-details">
                              
                                <div class="block-buttons">
                                <button class="btn">
                                 <a href="rating.php?vendor_id=<?php echo $row['vendor_id']; ?>" style="text-decoration: none; color: inherit;">Rate Vendor</a>
                                </button>
                            
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