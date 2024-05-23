<?php
// Start session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect the user to the login page if not logged in
    header("Location: index.html");
    exit();
}

include 'connection.php'; // Ensure connection to the database

$user_id = $_SESSION['user_id'];
$rows = [];

try {
    // SQL query to select data from the tables
    $sql = "SELECT services.service_name, vendor_services.other_service_details,vendor_services.price, vendor_services.image,vendor_services.rating
            FROM vendor_services
            JOIN services ON vendor_services.service_id = services.service_id
            JOIN vendors ON vendor_services.vendor_id=vendors.vendor_id
            WHERE vendors.user_id = :user_id";

    // Prepare the statement
    $stmt = $pdo->prepare($sql);

    // Bind the user_id parameter
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);

    // Execute query
    $stmt->execute();

    // Fetch all rows as associative array
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    // Handle errors gracefully
    echo "Error: " . $e->getMessage();
}
?>

<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="style3.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2family=poppins&display=swap">
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
        <title>Bookings</title>
    </head>
    <body>
       <!--navbar--> 
       <nav class="navbar">
        <h4>Dashboard</h4>
        <div class="profile">
            <span class="fas fa-search"><i class='bx bx-search'></i></span>
            <img class="profile-image" src="Images/pp1.jpeg" alt="">
            <p class="profile-name>" >Lorem Ipsum</p>
        </div>
       </nav>
            <!--sidebar--> 
            <input type="checkbox" id="toggle" >
            <label class="side-toggle" for="toggle"><span ><i class='bx bxs-dashboard' ></i></span></label>
            <div class="sidebar">
                <div class="user-image">
                    <img class="profile-image" src="Images/pp1.jpeg" alt="">
                    <p class="role"> Venodr    </p>
                    </div>
                <div class="sidebar-menu ">
                    <span   class="bx bx-sidebar dash"></span><p class="dash"><a href="vendorDash.php"> Dashboard</a></p>
                </div>
                <div class="sidebar-menu">
                 <span class='bx bxs-bookmark-heart'></span><p><a style="text-decoration: none; color:black;" href="BookingList.php">Bookings List</a></p>
              </div>
                <div class="sidebar-menu">
                <span class='bx bxs-bookmark-heart'></span><p><a style="text-decoration: none; color:black;"href="BookingDetails.php">Bookings details</a></p>
                  </div>
                <div class="sidebar-menu">
                    <span class="bx bx-user"></span><p> <a href="servicesV.php"> services</a></p>
                </div>
                <div class="sidebar-menu">
                    <span class="bx bx-wallet-alt"></span><p><a href=".php">schedule</a></p>
                </div>
                <div class="sidebar-menu">
                    <span  class='bx bx-objects-horizontal-left' ></span><p>Reports</p>
                </div>
               
            </div>
            <!--Maindashboard--> 
            <main>
            <div class="dashboard-container">
               
                <div class="card detail">
                    <h2>My Services</h2>
                     <div class="detail-header">
                                           
                        <div class="filterEntries">
                            <div class="entries">
                                Show <select name="" id="table_size">
                                    <option value="10">10</option>
                                    <option value="20">20</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                </select> entries
                            </div>
                            <div class="filter">
                                <label for="search">Search:</label>
                                <input type="search" name="" id="search" placeholder="Enter booking #/ client/date/service/vendor">
                            </div>
                        </div>
                        <div class="addBookingBtn">
                            <button>New Booking</button>
                        </div> 
                        <select id="filterDropdown">
                            <option value="all">All</option>
                            <option value="category2">Booked</option>
                            <option value="category1">Pending</option>
                            <option value="category2">Cancelled</option>
                            <option value="category1">Paid</option>
                            <option value="category2">Due</option>
                            <!-- Add more options as needed -->
                        </select>
                   
                     </div>
                     <!-- end of header section -->
                     <table>
                        <thead>
                        <tr>
                            <th>service Name </th>
                            <th>Description</th>
                            <th>Pricing </th>
                            <th>Image </th>                            
                            <th>Rating</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($rows as $row): ?>  
                    <!-- <tr><td class="empty" colspan="11" style="text-align: center;">No data Available in table</td></tr> -->
                        <tr>
                            <td>
                            <?php echo $row['service_name']; ?>    
                        
                            </td>
                            <td>
                            <?php echo $row['other_service_details']; ?>   
                               
                            </td>
                            <td>
                            <?php echo $row['price']; ?>   
                            </td>
                            <td>
                                
                                <?php
                    if ($row && !empty($row['image'])) {
                        // Encode the image data as a base64 string
                        $imageData = base64_encode(stream_get_contents($row['image']));
                        echo '<img src="data:image/jpeg;base64,' . $imageData . '" alt="Uploaded Image" class="uploaded-image"> ';
                        
                    } else {
                        echo "Image not found or empty.";
                    }
                     ?>  
                                </td>
                                <td>
                            <?php echo $row['rating']; ?>   
                                </td>
                           
                            <td>
                                <i class='bx bx-low-vision'></i>
                                <i class='bx bx-pencil'></i>
                                <i class='bx bx-trash' ></i>
                            </td>
                        </tr>
                        <?php endforeach; ?>   
                      
                    </tbody>
                     </table>
                     <footer>
                        <span>showing 1 of 10 of 50 entries</span>
                        <div class="pagination">
                            <button>prev</button>
                            <button class="active" >1</button>
                            <button>2</button>
                            <button>3</button>
                            <button>4</button>
                            <button>5</button>
                            <button>Next</button>
                        </div>
                     </footer>
                </div>
               
            </div>
        </main>
    </body>
</html>