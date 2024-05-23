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

// Retrieve user_id from the session
$user_id = $_SESSION['user_id'];

$rows = [];

try {
    // Prepare SQL query to select data from the tables for the currently logged-in vendor
    $sql = "SELECT bookings.booking_id, clients.first_name, clients.last_name, services.service_name, bookings.booking_date, bookings.status, bookings.payment_status, bookings.event_date
            FROM bookings
            JOIN clients ON bookings.client_id = clients.client_id
            JOIN services ON bookings.service_id = services.service_id
            JOIN vendors ON bookings.vendor_id = vendors.vendor_id
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
                    <h2>Booking List</h2>
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
                            <th>Booking #</th>
                            <th>Client</th>
                            <th>Booking Date</th>
                            <th>Event Date</th>                            
                            <th>Service Booked</th>
                            <th>Booking status</th>
                            <th>Payment status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- <tr><td class="empty" colspan="11" style="text-align: center;">No data Available in table</td></tr> -->
                        <?php foreach ($rows as $row): ?>
                        <tr>
                        <td><?php echo $row['booking_id']; ?></td>
                <td><?php echo $row['first_name'] . ' ' . $row['last_name']; ?></td>
                <td><?php echo $row['booking_date']; ?></td>
                <td><?php echo $row['event_date']; ?></td>
                <td><?php echo $row['service_name']; ?></span></td>
                <td><span class="status confirmed"><?php echo $row['status']; ?></td>
                <td><span class="status fullfilled"><?php echo $row['payment_status']; ?></span></td>
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