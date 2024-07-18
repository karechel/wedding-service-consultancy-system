<?php
include 'connection.php';
include 'login.php';

$rows = [];
try {
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];

        $sql = "SELECT bookings.booking_id, clients.first_name, clients.last_name, vendors.vendor_name, services.service_name, bookings.booking_date, bookings.status, bookings.payment_status, bookings.event_date
                FROM bookings
                JOIN clients ON bookings.client_id = clients.client_id
                JOIN services ON bookings.service_id = services.service_id
                JOIN vendors ON bookings.vendor_id = vendors.vendor_id
                WHERE vendors.user_id = :user_id";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        echo "You must be logged in to view this page.";
    }

} catch (PDOException $e) {
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
        <style>
    /* Add this CSS rule to hide the modal initially */
    .hidden {
        display: none;
    }
</style>
    </head>
    <body>
      
    <?php include 'resuableComponents\vendorHeader.php' ?>
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
                    <span class="bx bx-bookmark-heart"></span><p><a href="bookingList.php">Bookings</a></p>
                </div>
                <div class="sidebar-menu">
                    <span class="bx bx-user"></span><p> <a href="servicesV.php"> Services</a></p>
                </div>
                <div class="sidebar-menu">
                    <span class="bx bx-user"></span><p> <a href="ClientV.php"> Clients</a></p>
                </div>
                <div class="sidebar-menu">
                    <span class="bx bx-wallet-alt"></span><p><a href="financev.php">Finance</a></p>
                </div>
                
               
            </div>
            <!--Maindashboard--> 
            <main>
            <div class="dashboard-container">
               
                <div class="card detail">
                    <h2>My Bookings</h2>
                     <div class="detail-header">

                     <div class="filterEntries">
    <div class="button-container">
        <button id="AllStatus" class="filter-button">All</button>
        <button id="confirmedStatus" class="filter-button">Confirmed</button>
        <button id="pendingStatus" class="filter-button">Pending</button>
        <button id="completedStatus" class="filter-button">Completed</button>
        <button id="cancelledStatus" class="filter-button">Cancelled</button>
    </div>
    <div class="filter">
        <input type="search" id="search" placeholder="Search bookings">
    </div>
</div>

                        <div class="addBookingBtn">
                            <button  id="exportCSV"><span class="material-symbols-outlined">upgrade</span>Export</button>
                        </div> 
                       

                       
                     </div>
                     <!-- end of header section -->
                    <table id="bookingsTable">
        <thead>
            <tr>
                <th>Booking ID</th>
                <th>Client Name</th>
                <th>Booking Date</th>
                <th>Event Date</th>
                <th>Service</th>
                <th>Status</th>
                <th>Payment Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
    <?php foreach ($rows as $row): ?>
        <tr data-booking-id="<?php echo $row['booking_id']; ?>" data-status="<?php echo $row['status']; ?>">
            <td><?php echo $row['booking_id']; ?></td>
            <td><?php echo $row['first_name'] . ' ' . $row['last_name']; ?></td>
            <td><?php echo $row['booking_date']; ?></td>
            <td><?php echo $row['event_date']; ?></td>
            <td><?php echo $row['service_name']; ?></td>
            <td><?php echo $row['status']; ?></td>
            <td><span class="status fullfilled"><?php echo $row['payment_status']; ?></span></td>
            <td>
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
        <span class="close" id="closeModal">&times;</span>
        <h2>Edit Booking</h2>
        <form id="editForm">
            <input type="hidden" id="editBookingId" name="booking_id">
            <label for="editStatus">Booking Status:</label>
            <input type="text" id="editStatus" name="status">
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

    //export csv
    const closeButton = document.getElementById('closeModal');

// Get a reference to the modal
const modal = document.getElementById('editModal');

// Add a click event listener to the close button
closeButton.addEventListener('click', () => {
    // Hide the modal by adding a CSS class (e.g., "hidden")
    modal.classList.add('hidden');
});
  
        </script>
        <script src="resuableComponents\exportCSV.js"></script>
        <script src="resuableComponents\EditDelete.js"></script>
        <script src="resuableComponents\filterbookings.js"></script>
    </body>
</html>


