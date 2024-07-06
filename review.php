<?php
include 'connection.php'; // Ensure connection to the database
include 'login.php';

$rows = [];
try {
    // Check if the user is logged in and get their user_id
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];

        // SQL query to select data from the tables filtered by the logged-in user
        $sql = "SELECT bookings.booking_id, vendors.vendor_name, services.service_name, bookings.status,vendors.vendor_id
        FROM bookings
        JOIN clients ON bookings.client_id = clients.client_id
        JOIN services ON bookings.service_id = services.service_id
        JOIN vendors ON bookings.vendor_id = vendors.vendor_id
        WHERE clients.user_id = :user_id
        AND bookings.status = 'Completed'";


        // Prepare and execute query
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();

        // Fetch all rows as associative array
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        // Handle case where user is not logged in
        // Redirect or handle as per your application's logic
    }

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
                                    
                           <a href="rating.php?booking_id=<?php echo $row['booking_id']; ?>&vendor_id=<?php echo $row['vendor_id']; ?>" style="text-decoration: none; color: inherit;">Rate Vendor</a>
                                </button>
                            
                                </div>
                            </div>
                    </div>                  

                    </div>
                    <?php $count++; ?>
                                      <?php endforeach; ?>   
                </div>
                
                </div>
                <?php include 'resuableComponents\footer.php'; ?>
        </div>
       
          </div>
          
        
        <script src="script.js">
          
        </script>
    </div>
</div>
    </body>
</html>