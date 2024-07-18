<?php
include 'connection.php'; // Ensure connection to the database
include 'login.php';

$rows = [];
try {
    // Check if the user is logged in and get their user_id
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];

        // SQL query to select data from the tables filtered by the logged-in user
        $sql = "SELECT b.booking_id, c.first_name, c.last_name, v.vendor_name, s.service_name, 
        b.booking_date, b.status, b.payment_status, b.event_date,
        SUM(vs.price) as total_price
 FROM bookings b
 JOIN clients c ON b.client_id = c.client_id
 JOIN services s ON b.service_id = s.service_id
 JOIN vendors v ON b.vendor_id = v.vendor_id
 JOIN vendor_services vs ON b.vendor_id = vs.vendor_id
 WHERE c.user_id = :user_id
 GROUP BY b.booking_id, c.first_name, c.last_name, v.vendor_name, s.service_name,
          b.booking_date, b.status, b.payment_status, b.event_date";


        // Prepare and execute query
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();

        // Fetch all rows as associative array
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

      
// Assuming $total_price contains the fetched price

if (!empty($rows) && isset($rows[0]['total_price'])) {
    $total_price = $rows[0]['total_price'];
    $formatted_price = number_format($total_price, 0, '.', '');
} else {
    $formatted_price = 0; // Default value if no price is found
}

    } else {
        // Handle case where user is not logged in
        // Redirect or handle as per your application's logic
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
        <!-- <link rel="stylesheet" href="BookingsList.css"> -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2family=poppins&display=swap">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2family=poppins&display=swap">
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
        <title>Bookings</title>
    <style>
        body{
                background: #ededed;
                        }
        .button-container {
            position: absolute;
            display: block;
        }
       .filter-button {
            background: none;
            border: none !important;
            font-weight: 500;
            padding: 5px 10px;
            border-radius: 9999px;
            overflow: hidden;
            width: 100px;
            cursor: pointer;
            font-family: Verdana, Geneva, Tahoma, sans-serif;
        }
        .filter-button:hover {
            background-color: #e2e8f0;
        }
        .filter-button.active {
            background-color: #64748b;
            color: white;
        }
        .events-container h1, h2 {
    margin-bottom: 10px;
    font-family: Verdana, Geneva, Tahoma, sans-serif;
}
.filter input {
    padding: 7px 10px;
    border: 1px solid #ced7e3;
    color: #000;
    background: #fff;
    border-radius: 24px;
    outline: none;
    transition: 0.3s ease;
    position: absolute;
    left: 73%;
}
.addBookingBtn button {
    color: #fff;
    background: transparent;
    font-size: 16px;
    cursor: pointer;
    pointer-events: auto;
    outline: none;
    border: 1px solid #4f46e5;
    background: #4f46e5;
    border-radius: 25px;
    height: 30px;
    width: 100px;
    justify-content: center;
    display: flex;
    align-items: center
}

.detail table th, .detail table td {
    padding: 0.8rem 0.2rem;
    text-align: left;
    min-width: 112px;
    font-size: 14px;
    font-family: math;
}
.material-symbols-outlined {
        font-size: 18px;
        cursor: pointer;
}
   
              .dropdown-container {
            position: relative;
            display: inline-block;
        }
        .dropdown-btn {
            background: none;
            border: none;
            cursor: pointer;
            font-size: 24px;
        }
        .dropdown-menu {
            display: none;
            position: absolute;
            right: 0;
            border-radius: 5px;
            background-color: white;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            z-index: 1;
            min-width: 160px;
        }
        .dropdown-menu a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }
        .dropdown-menu a:hover {
            background-color: #e2e8f0;
            width: 100%;
            border-radius: 25px;
        }
        .divider {
            height: 1px;
            background-color: #ccc;
            margin: 8px 0;
        }
        .navbar .dropdown-container{
            left: 87%;
        }
        .dropdown-container a{
            position:static ;
            font-size: 1rem;
        }
        main{
            padding: 10rem 15rem 10rem 10rem;
        }
        .detail-header select{
    height: 30px;
    width: 120px;
    border: 1px solid #e3bdb5;
    background-color: #e3bdb5;
    color: #f2f2f2;
    border-radius: 5px;
    cursor: pointer;
    transition: all 0.2s ease-in;
}
.detail-header select:hover{
    background-color: transparent;
    color: #e3bdb5;

}
.detail table{
    width: 100%;
    border-collapse: collapse;

}
.detail table tr:nth-child(odd){
    background-color: #caa69e1a;

}
.detail table th{
    background-color: #caa69e1a;
}
main{
    padding: 90px 45px 0 45px;
}
.dashboard-container{
    display: flex;
    flex-direction: column;
    width: 100%;
}
.detail{
    width: 100%;
}
.detail table tr:hover{
    background-color: #f2f2f2;
    border-bottom: 2px solid #e3bdb5;
}
button:hover {
    background-color: #e3bdb5;
}
    </style>
    </head>
   
        <body>
  
    <?php include 'resuableComponents\clientHeader.php'; ?>
        
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
                    <input type="search" name="" id="search" placeholder="Search bookings">
                </div>
            </div>
        </div>
        <table id="bookingsTable">
            <thead>
                <tr>
                    <th>Booking #</th>
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
            <tr data-booking-id="<?php echo $row['booking_id']; ?>" data-status="<?php echo $row['status']; ?>">
                <td>BK00<?php echo $row['booking_id']; ?></td>
                <td><?php echo $row['booking_date']; ?></td>
                <td><?php echo $row['event_date']; ?></td>
                <td><?php echo $row['service_name']; ?></td>
                <td><?php echo $row['vendor_name']; ?></td>
                <td>
                <?php if ($row['status'] == 'Confirmed'): ?>
                    <span class="status fullfilled"><?php echo $row['status']; ?></span>
                <?php elseif ($row['status'] == 'Pending'): ?>
                    <span class="status onprogress"><?php echo $row['status']; ?></span>
                <?php else: ?>
                    <span class="status confirmed"><?php echo $row['status']; ?></span>
                    <?php endif; ?>
            </td> 
                <td>
                        <?php if ($row['payment_status'] == 'Unpaid'): ?>
                            <button class="status pay-button" data-booking-id="<?php echo $row['booking_id']; ?>">Pay Now</button>
                        <?php elseif ($row['payment_status'] == 'Paid'): ?>
                            <span class="status fullfilled"><?php echo $row['payment_status']; ?></span>
                        <?php endif; ?>
                    </td>
                <td>
                <?php if ($row['status'] == 'Confirmed'): ?>
                    <span class="material-symbols-outlined edit">edit</span>
                <?php elseif ($row['status'] == 'Pending'): ?>
                    <span class="material-symbols-outlined delete">delete</span>
                <?php else: ?>
                    <span class="material-symbols-outlined done_all">done_all</span>  
                <?php endif; ?>
                   
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
        </table>
        <!-- payment Modal -->
     
        <div id="payModal" class="modal-payment">
    <div class="modal-content-payment">
        <span class="close-payment">&times;</span>
        <h2>Pay for Booking</h2>
        <form id="payForm" action="stk_push.php" method="POST">
            <!-- Displaying booking details -->
            <input type="hidden" id="booking_id" name="booking_id">
            <label for="contactNumber">Contact Number:</label>
            <input type="text" id="contactNumber" placeholder="E.g 254700000000" name="contactNumber" required>
            <label for="amount">Amount: <?php echo $formatted_price; ?></label>
            <input type="hidden" id="amount" name="amount" value="<?php echo $formatted_price; ?>">
              
            <button type="submit">Pay</button>
        </form>
    </div>
</div>





<!-- Edit Popup Modal -->
<div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Edit Booking</h2>
            <form id="editForm">
                <input type="hidden" id="editBookingId" name="booking_id">
                <label for="editStatus">Booking Status:</label>
                <input type="text" id="editStatus" name="status">
                <button type="submit">Save Changes</button>
            </form>
        </div>
    </div>
                   
                </div>
               
            </div>
        </main>
     <script src="stk_push.js"></script>
     <script src="editDelete.js"></script>
    <script src="resuableComponents\filterbookings.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var payButtons = document.querySelectorAll('.pay-button');
        var modalBookingIdField = document.getElementById('booking_id');
        
        payButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                var bookingId = this.getAttribute('data-booking-id');
                modalBookingIdField.value = bookingId;
                // Optionally, you can also populate other fields in the modal if needed
            });
        });
    });
</script>

    </div>
    
</html>


