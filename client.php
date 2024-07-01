<?php
include 'connection.php'; // Ensure connection to the database

session_start(); // Start session to access session variables

if (!isset($_SESSION['username'])) {
    // If not logged in, redirect to the login page
    header("Location: login.html");
    exit();
}

$client_name = '';
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    try {
        // SQL query to fetch client name
        $stmt = $pdo->prepare("SELECT first_name, last_name FROM clients WHERE user_id = :user_id");
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();

        // Fetch client name
        $client = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($client) {
            $client_name = $client['first_name'] . ' ' . $client['last_name'];
        }
    } catch (PDOException $e) {
        // Handle errors gracefully
        echo "Error: " . $e->getMessage();
    }
}

$rows = [];
$rows1 = [];
$rows2 = [];
$daysToGo = null;

try {
    // Check if the user is logged in and get their user_id
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];

        // SQL query to select data from the tables filtered by the logged-in user
        $sql = "SELECT services.service_name, bookings.status, bookings.booking_date, clients.first_name, clients.last_name, clients.user_id, clients.wedding_date, vendor_services.image, vendors.vendor_name
                FROM bookings
                JOIN services ON bookings.service_id = services.service_id
                JOIN clients ON bookings.client_id = clients.client_id
                JOIN vendor_services ON services.service_id = vendor_services.service_id
                JOIN vendors ON vendor_services.vendor_id = vendors.vendor_id
                WHERE clients.user_id = :user_id";

        // Prepare and execute query
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $query1 = "SELECT vendor_services.image, clients.user_id, vendors.vendor_name
                   FROM favourites
                   JOIN vendor_services ON favourites.vendor_service_id = vendor_services.vendor_service_id
                   JOIN clients ON favourites.client_id = clients.client_id
                   JOIN vendors ON favourites.vendor_id = vendors.vendor_id
                   WHERE clients.user_id = :user_id";

        // Prepare and execute query
        $stmt1 = $pdo->prepare($query1);
        $stmt1->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt1->execute();
        $rows1 = $stmt1->fetchAll(PDO::FETCH_ASSOC);

        $query2 = "SELECT vendor_services.image, vendor_services.rating, vendors.location, services.service_name
                   FROM vendor_services
                   JOIN vendors ON vendor_services.vendor_id = vendors.vendor_id
                     JOIN services ON vendor_services.service_id = services.service_id";

        // Prepare and execute query
        $stmt2 = $pdo->prepare($query2);
        $stmt2->execute();
        $rows2 = $stmt2->fetchAll(PDO::FETCH_ASSOC);

        //filter vendors
        $category_filter = isset($_POST['category']) ? $_POST['category'] : 'all';
        $query3 = "SELECT vendor_services.image, vendor_services.rating, vendors.location, services.service_name
        FROM vendor_services
        JOIN vendors ON vendor_services.vendor_id = vendors.vendor_id
        JOIN services ON vendor_services.service_id = services.service_id";
      
      if ($category_filter !== 'all') {
          $query3 .= " WHERE services.service_name = :category_filter";
      }

      // Prepare and execute query
      $stmt3 = $pdo->prepare($query3);
      
      if ($category_filter !== 'all') {
          $stmt3->bindParam(':category_filter', $category_filter, PDO::PARAM_STR);
      }
      
      $stmt3->execute();
      $rows3 = $stmt3->fetchAll(PDO::FETCH_ASSOC);


        if (!empty($rows)) {
            $weddingDate = new DateTime($rows[0]['wedding_date']);
            $currentDate = new DateTime();
            $interval = $currentDate->diff($weddingDate);
            $daysToGo = $interval->days;
        }
    } else {
        // Handle case where user is not logged in
        echo "You must be logged in to view this page.";
        exit();
    }
} catch (PDOException $e) {
    // Handle errors gracefully
    echo "Error: " . $e->getMessage();
    exit();
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
      
      
          <?php include 'clientHeader.php'; ?>
          <div class="container">
            <div class="content">
                <div class="welcome-container">
                    <div class="welcome-text">
                    <h2>Welcome </h2>
                    <span >
                    <?php echo htmlspecialchars($client_name); ?>  </span>
                    <?php if ($daysToGo !== null): ?>
                    <h1><?php echo $daysToGo; ?> Days to Go!!</h1>
                    <?php endif; ?>

                </div>
                <!-- <div class="row">
                <div class="progress-blocks">
                    <span>Hired Services</span>       
                    <p>12</p>             

                </div>
                <div class="progress-blocks">
                           <span>Completed Tasks</span>   
                           <p>42</p>          

                </div>
            </div> -->
                </div>
                <!-- <div class="events-container">
                <div class="row">
                   <div class="myservices">
                    <h3>My services</h3> <br>
                    <div class="headings">
                        <span>services</span>
                        <span>status</span>
                        <span>Booking Date</span>
                    </div>
                   </div>
                   <div class="row">
                    <div class="pending-tasks">

                    </div>
                    <div class="favourites">

                    </div>
                   </div>
                </div>
            </div> -->
            <div class="events-container">
                <h1>My Bookings</h1>
                <div class="row">
                    
                    <div class="myservices">
                        
                        <div class="headings">
                            <span>Service</span>
                            <span>Status</span>
                            <span>Booking Date</span>
                        </div>
                        <?php foreach ($rows as $row): ?>
                <div class="service">
                    <span><?php echo htmlspecialchars($row['service_name'], ENT_QUOTES, 'UTF-8'); ?></span>
                    <span><?php echo htmlspecialchars($row['status'], ENT_QUOTES, 'UTF-8'); ?></span>
                    <span><?php echo htmlspecialchars($row['booking_date'], ENT_QUOTES, 'UTF-8'); ?></span>
                </div>
            <?php endforeach; ?>
                        <!-- Add more services as needed -->
                    </div>
                    <div class="column">
                        <!-- <h2>Pending Tasks</h2> -->
                <!-- <div class="pending-tasks">
                    <h3>Pending Tasks</h3>
                    <ul>
                        <li>
                            <span class="task-name">Task 1</span>
                            <span class="due-date">Due Date: 2024-03-10</span>
                        </li>
                        <li>
                            <span class="task-name">Task 2</span>
                            <span class="due-date">Due Date: 2024-03-15</span>
                        </li>
                        
                    </ul>
                </div> -->
                <!-- end of pending-tasks -->
                <h2>My Favorites</h2>
                <?php foreach ($rows1 as $row): ?>
    <div class="favorites">                   
        <div class="favorite-item">
            <img src="" alt="Vendor Image">
            <p>Vendor: <?php echo $row['vendor_name']; ?></p>
          
        </div>                   
    </div>
<?php endforeach; ?>    
                <!-- end of facourites -->
            </div>
                
            </div>
        </div>
        <div class="recommendations-content">
        <h1>Recommendations for Your</h1>
        <div class="recommendations-section">
         
        <div class="service-recommendations-container">
    <h3>Wedding Service Recommendations</h3>
    <span>View some recommended venues</span>
    <div class="service-recommendations">
        <?php $count = 3; ?>
        <?php foreach ($rows2 as $row2): ?>
            <div class="service-recommendation">
                <div class="image">
                <?php
                    if ($row && !empty($row['image'])) {
                        // Encode the image data as a base64 string
                        $imageData = base64_encode(stream_get_contents($row2['image']));
                        echo '<img src="data:image/jpeg;base64,' . $imageData . '" alt="Uploaded Image" class="uploaded-image"> ';
                        
                    } else {
                        echo "Image not found or empty.";
                    }
                     ?>  
                </div>
                <div class="details">
                    <h4 class="service-name"><?php echo htmlspecialchars($row2['service_name']); ?></h4>
                    <ul class="rating">
                        <?php for ($i = 0; $i < $row2['rating']; $i++): ?>
                            <li>
                                <i class='bx bxs-star' style='color:#ddc04c'></i>
                            </li>
                        <?php endfor; ?>
                    </ul>
                    <p class="location"><?php echo htmlspecialchars($row2['location']); ?></p>
                </div>
            </div>
            <?php $count--; ?>
            <?php if ($count == 0) break; ?>
        <?php endforeach; ?>
    </div>
    <div class="viewmoreservices-button">
                    <button class="btn">View More</button>
                    
                </div>
</div>
              
      
        
<div class="wedding-vendors">
    <h3>Wedding Vendor Recommendations</h3>
    <div class="filter">
        <form method="POST" action="">
            <select name="category" onchange="this.form.submit()">
                <option value="all">All Categories</option>
                <option value="Floral Arrangements" <?php echo $category_filter == 'Floral Arrangements' ? 'selected' : ''; ?>>Floral Arrangements</option>
                <option value="Photography and Videography" <?php echo $category_filter == 'Photography and Videography' ? 'selected' : ''; ?>>Photographer</option>
                <option value="Catering Services" <?php echo $category_filter == 'Catering Services' ? 'selected' : ''; ?>>Caterer</option>
                <!-- Add more categories -->
            </select>
        </form>
    </div>
    <div class="vendor-recommendations">
        <?php $count = 3; ?>
        <?php foreach ($rows3 as $row): ?>
            <div class="vendor-recommendation">
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
                </div>
                <div class="details">
                    <h4 class="service-name"><?php echo htmlspecialchars($row2['service_name']); ?></h4>
                    <ul class="rating">
                        <?php for ($i = 0; $i < $row2['rating']; $i++): ?>
                            <li>
                                <i class='bx bxs-star' style='color:#ddc04c'></i>
                            </li>
                        <?php endfor; ?>
                    </ul>
                    <p class="location"><?php echo htmlspecialchars($row2['location']); ?></p>
                </div>
            </div>
            <?php $count--; ?>
            <?php if ($count == 0) break; ?>
        <?php endforeach; ?>
    </div>
    <div class="viewmorevendors-button">
        <button class="btn">View More</button>
    </div>
</div>
            </div>
        </div>
    </div>
    </div>
    <footer class="footer">
      
        <div class="footer-columns">
            <div class="footer-column">
                <h4>Locations</h4>
                <ul>
                    <li><a href="#">Nakuru</a></li>
                    <li><a href="#">Mombasa</a></li>
                    
                </ul>
            </div>
            <div class="footer-column">
                <h4>Quick Links</h4>
                <ul>
                    <li><a href="#">Link 1</a></li>
                    <li><a href="#">Link 2</a></li>
                 
                </ul>
            </div>
            <div class="footer-column">
                <h4>Contacts</h4>
                <ul>
                    <li>Email: WeddingHub@gmail.com</li>
                    <li>Phone: +1234567890</li>
                 
                </ul>
            </div>
        </div>
    </footer>
    
        </div>
       
         
          

        <script src="script.js"></script>
    </div>
    </body>
</html>