<?php
include 'connection.php'; // Ensure connection to the database
include 'login.php';

// session_start(); // Start session to access session variables

$rows = [];
try {
    // Check if the user is logged in and get their user_id
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];

        // SQL query to select data from the tables filtered by the logged-in user
        $sql = "SELECT bookings.booking_id, clients.first_name, clients.last_name, vendors.vendor_name, services.service_name, bookings.booking_date, bookings.status, bookings.payment_status, bookings.event_date
                FROM bookings
                JOIN clients ON bookings.client_id = clients.client_id
                JOIN services ON bookings.service_id = services.service_id
                JOIN vendors ON bookings.vendor_id = vendors.vendor_id
                WHERE vendors.user_id = :user_id";

        // Prepare and execute query
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();

        // Fetch all rows as associative array
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        // Handle case where user is not logged in
       
    }

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
        <link rel="stylesheet" href="BookingsList.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2family=poppins&display=swap">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2family=poppins&display=swap">
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
        <title>Bookings</title>
   
    </head>
    <body>
      
       <header class="header">
            <nav class="navbar">
                <img src="Images/logo.jpg" width="80" height="60">
                <a href="#"><i class='bx bx-bell'></i></a>
                <a href=""><i class='bx bx-message'></i></a>
                <div class="dropdown-container">
            <button class="dropdown-btn"><i class='bx bx-user-circle'></i></button>
             <div class="dropdown-menu">
             <a href="#"><i class='bx bx-user-circle'></i> Profile</a>
            <a href="#"><i class='bx bx-cog bx-flip-horizontal' ></i> Settings</a>
             <div class="divider"></div>
             <a href="logout.php"><i class='bx bx-exit bx-flip-horizontal'></i> Sign Out</a>
         </div>
        </div>
            </nav>
        </header>
            <!--sidebar--> 
            <input type="checkbox" id="toggle" >
            <label class="side-toggle" for="toggle"><span ><i class='bx bxs-dashboard' ></i></span></label>
            <div class="sidebar">
                <div class="user-image">
                    <img class="profile-image" src="Images/pp1.jpeg" alt="">
                    <p class="role"> Vendor   </p>
                    </div>
                <div class="sidebar-menu ">
                    <span   class="bx bx-sidebar dash"></span><p class="dash"><a href="vendorD.php"> Dashboard</a></p>
                </div>
                <div class="sidebar-menu">
                    <span class="bx bx-bookmark-heart"></span><p><a href="bookingsM.php">Bookings</a></p>
                </div>
                <div class="sidebar-menu">
                    <span class="bx bx-user"></span><p> <a href="servicesV.php"> Services</a></p>
                </div>
                <div class="sidebar-menu">
                    <span class="bx bx-user"></span><p> <a href="ClientV.php"> Clients</a></p>
                </div>
                <div class="sidebar-menu">
                    <span class="bx bx-wallet-alt"></span><p><a href="finance.php">Finance</a></p>
                </div>
                <div class="sidebar-menu">
                    <span  class='bx bx-objects-horizontal-left' ></span><p>Reports</p>
                </div>
               
            </div>
            <!--Maindashboard--> 
            <main>
            <div class="dashboard-container">
               
                <div class="card detail">
                    <h2>My Bookings</h2>
                     <div class="detail-header">
                                           
                        <div class="filterEntries">
                            <!-- <div class="entries">
                                Show <select name="" id="table_size">
                                    <option value="10">10</option>
                                    <option value="20">20</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                </select> entries
                            </div> -->
                            <div class="button-container">
                        <button id="" class="filter-button" >Confirmed</button>
                        <button id="" class="filter-button" >Pending</button>
                        <button id="" class="filter-button" >Cancelled</button>
                    </div>
                            <div class="filter">
                                
                                <input type="search" name="" id="search" placeholder="Search bookings">
                            </div>
                        </div>
                        <div class="addBookingBtn">
                            <button><span class="material-symbols-outlined">add</span>Add</button>
                        </div> 
                        <!-- <select id="filterDropdown">
                            <option value="all">All</option>
                            <option value="category2">Booked</option>
                            <option value="category1">Pending</option>
                            <option value="category2">Cancelled</option>
                            <option value="category1">Paid</option>
                            <option value="category2">Due</option>
                            
                        </select> -->
                   
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
            <th>Vendor</th>
            <th>Booking status</th>
            <th>Payment status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($rows as $row): ?>
            <tr data-booking-id="<?php echo $row['booking_id']; ?>">
                <td><?php echo $row['booking_id']; ?></td>
                <td><?php echo $row['first_name'] . ' ' . $row['last_name']; ?></td>
                <td><?php echo $row['booking_date']; ?></td>
                <td><?php echo $row['event_date']; ?></td>
                <td><?php echo $row['service_name']; ?></td>
                <td><?php echo $row['vendor_name']; ?></td>
                <td><?php echo $row['status']; ?></td>
                <td><span class="status fullfilled"><?php echo $row['payment_status']; ?></span></td>
                <td>
                    <i class="material-symbols-outlined view">visibility</i>
                    <span class="material-symbols-outlined edit">edit</span>
                    <span class="material-symbols-outlined delete">delete</span>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<!-- Edit Popup Modal -->
<div id="editModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Edit Booking</h2>
        <form id="editForm">
            <input type="hidden" id="editBookingId" name="booking_id">
            <label for="editStatus">Booking Status:</label>
            <input type="text" id="editStatus" name="status" >
            <button type="submit">Save Changes</button>
        </form>
    </div>
</div>
                     <!-- <footer>
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
                     </footer> -->
                </div>
               
            </div>
        </main>
        <script>


        //dropdown menu
       
    document.querySelector('.dropdown-btn').addEventListener('click', function() {
        const dropdownMenu = document.querySelector('.dropdown-menu');
        dropdownMenu.style.display = dropdownMenu.style.display === 'block' ? 'none' : 'block';
    });

    // Close the dropdown if the user clicks outside of it
    window.onclick = function(event) {
        if (!event.target.matches('.dropdown-btn')) {
            const dropdowns = document.getElementsByClassName("dropdown-menu");
            for (let i = 0; i < dropdowns.length; i++) {
                const openDropdown = dropdowns[i];
                if (openDropdown.style.display === 'block') {
                    openDropdown.style.display = 'none';
                }
            }
        }
    }

        </script>
        <script src="resuableComponents\EditDelete.js"></script>
    </body>
</html>


