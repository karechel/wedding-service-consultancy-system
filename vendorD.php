<?php
include 'connection.php'; // Ensure connection to the database
include 'login.php';

// session_start(); // Start session to access session variables
if (!isset($_SESSION['username'])) {
    // If not logged in, redirect to the login page
    header("Location: index.html");
    exit();
}
$vendor_name = '';
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    try {
        // SQL query to fetch vendor name
        $stmt = $pdo->prepare("SELECT vendor_name FROM vendors WHERE user_id = :user_id");
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();

        // Fetch vendor name
        $vendor = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($vendor) {
            $vendor_name = $vendor['vendor_name'];
        }
    } catch (PDOException $e) {
        // Handle errors gracefully
        echo "Error: " . $e->getMessage();
    }
}
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



        $bookingsSql = "SELECT COUNT(*) AS total_bookings FROM bookings WHERE vendor_id = (SELECT vendor_id FROM vendors WHERE user_id = :user_id)";
        $bookingsStmt = $pdo->prepare($bookingsSql);
        $bookingsStmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $bookingsStmt->execute();
        $bookingsData = $bookingsStmt->fetch(PDO::FETCH_ASSOC);
        $total_bookings = $bookingsData['total_bookings'];
    
        // Fetch the number of pending payments
        $pendingPaymentsSql = "SELECT COUNT(*) AS pending_payments FROM bookings WHERE vendor_id = (SELECT vendor_id FROM vendors WHERE user_id = :user_id) AND payment_status = 'unpaid'";
        $pendingPaymentsStmt = $pdo->prepare($pendingPaymentsSql);
        $pendingPaymentsStmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $pendingPaymentsStmt->execute();
        $pendingPaymentsData = $pendingPaymentsStmt->fetch(PDO::FETCH_ASSOC);
        $pending_payments = $pendingPaymentsData['pending_payments'];
    
        // Fetch the total revenue
        $revenueSql = "SELECT SUM(amount) AS total_revenue FROM transactions WHERE vendor_id = (SELECT vendor_id FROM vendors WHERE user_id = :user_id)";
        $revenueStmt = $pdo->prepare($revenueSql);
        $revenueStmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $revenueStmt->execute();
        $revenueData = $revenueStmt->fetch(PDO::FETCH_ASSOC);
        $total_revenue = $revenueData['total_revenue'];
    } else {
        // Handle case where user is not logged in
        echo "You must be logged in to view this page.";
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
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
        <style>
            body{
                background: #ededed;
                        }
            .info {
    display: grid;
    grid-auto-flow: column;
    justify-content: center;
    align-items: center;
}
.info .bx-dots-vertical-rounded{
    display: flex;
    margin-right: -80px;
    justify-content: right;
}
.info-detail h2 {
    font-size: 4rem;
    font-family: Verdana, Geneva, Tahoma, sans-serif;
    justify-content: center;
    display: flex;
}
.info-detail h2 span{
    font-size: 4rem;
    font-family: Verdana, Geneva, Tahoma, sans-serif;
}
.info-detail h3 {
    font-size: 1rem;
    font-weight: 500;
    justify-content: center;
    display: flex;
    font-family: Verdana, Geneva, Tahoma, sans-serif;
}
.info-detail h4 {
    font-size: .8125rem;
    font-weight: 500;
    justify-content: center;
    display: flex;
    margin-top: 20px;
    font-family: Verdana, Geneva, Tahoma, sans-serif;
}
.info-detail h4 span{
    margin-left:1px;
    font-size: larger;
}
.container-content {
    padding-bottom: 100px;
    padding-left: 50px;
    position: relative;
    display: flex;
    margin-top: 100px;

}
.navbar {
    position: fixed;
    margin-top: 10px;
    top: 0;
    border-radius: 6px;
    left: 0;
    width: 87%;
    padding: 25px 12.5%;
    background: #fff;
    display: flex;
    align-items: center;
    z-index: 100;
    border-bottom: 1px solid #ccc;
    height: 4rem;
    margin: 15px 100px;
}
.bookings-summary{
    width: 100%;
    background: #fff;
    border-radius: 10px;
}
.summaries{
    position: relative;
    display: flex;
    flex-direction: row;

}
.overview{
    display: flex;
    flex-direction: row;
    align-items: center;
}
.button-container {
            position: absolute;
            top: 0;
            right: 0;
            display: block;
        }
       .filter-button {
            background: none;
            border: none !important;
            font-weight: 500;
            padding: 5px 10px;
            border-radius: 9999px;
            overflow: hidden;
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
.legend {
          display: flex;
          align-items: end;
          margin-left: 90px;
        }
        .legend-item {
            display: flex;
            align-items: center;
            margin-bottom: 5px;
        }
        .legend-color {
            width: 20px;
            height: 20px;
            margin-right: 10px;
        }
        .bookings-summary p{
            padding-top: 20px;
            padding-left: 10px;
            font-size: 1rem;
            font-weight: 500;
            font-family: Verdana, Geneva, Tahoma, sans-serif;
        }
        .chart{
            position: relative;
            width: 60%;
            height: 300px;
            justify-content: center;
            display: grid;
        }
        #pieChart{
            margin-left: 150px;
        }
        .total1 h2,
        .total1 h3{
            color: #3B82F6;
        }
        .total2 h2,
        .total2 h3{

            color: #ef4444;
        }
        .total3 h2,
        .total3 h3 {

            color: #22c55e;
        }
        .bx-dots-vertical-rounded {
            cursor: pointer;
            margin-bottom: 10px;
        }
        .bx-dots-vertical-rounded:hover {
            color: #e2e8f0;
        }
        .options {
            display: none;
            position: absolute;
            top: 40px;
            margin-left: 150px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            z-index: 10;
        }
        .options a {
            display: block;
            padding: 10px;
            color: black;
            text-decoration: none;
            font-size: 14px;
        }
        .options a:hover {
            background-color: #e2e8f0;
        }
       .overview .total1 h2,
       .overview .total1 h3{

            color:#3730a3;
        }
        .overview .total2 h2,
       .overview .total2 h3{

            color:#166534;
        }
        .overview .total1{
            background: #eef2ff;
            margin: 0 15px 0 0;
            height: 160px;
        }
        .overview .total2{
            background: #f0fdf4;
        }
       .bookings-details{
        position: relative;
    border: 1px solid #ccc;
    margin: 50px;
       }
       .detail table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 65px;
}
.bookings-details .button-container {
    position: absolute;
    right: 0;
    display: block;
    margin: 45px 30px 5px 0;
}
/* general summaries section */
.chart-container {
            position: relative;
            width: 80%;
            max-width: 800px;
        }
        .general-summaries{
            background: #fff;
            margin-top: 30px;
            display: flex;
            width: 100%;
            flex-direction: column;
        }

        .general-summaries.button-container {
            display: flex;
            justify-content: flex-end;
            width: 100%;
            margin-bottom: 20px;
        }
        .general-summaries.filter-button {
            background: none;
            border: none !important;
            font-weight: 500;
            padding: 5px 10px;
            border-radius: 9999px;
            overflow: hidden;
            cursor: pointer;
            transition: background-color 0.3s, color 0.3s;
        }
        .general-summaries .filter-button:hover {
            background-color: #e2e8f0;
        }
        .general-summaries.filter-button.active {
            background-color: #64748b;
            color: white;
        }
        .finance-summaries{
            width: 100%;
            border: 1px solid #e3e6ed; 
            display: flex;
            justify-content: center;
        }
        .finance-summaries h1{
            margin-top: 15px;
            font-size: 1.5rem;
            font-weight: 500;
            font-family: Verdana, Geneva, Tahoma, sans-serif;

        }
        .general-summaries .total1 h2,
        .general-summaries .total1 h3{

            color:#000;
        }
        .general-summaries .total2 h2,
        .general-summaries .total2 h3{

            color:#000;
        }
        .general-summaries .total1{
            background: #f8fafc;
         margin: 0;  
         border: 1px solid #e3e6ed; 
         border-radius: inherit;
    border-right: 1px solid #e3e6ed;    
        }
        .general-summaries .total2{
            background: #f8fafc;
            border: 1px solid #e3e6ed; 
            border-radius: inherit;
            height: 160px;
        }
        .finance-summaries .button-container{
            margin-top: 20px;
            margin-bottom: 20px;
        }
        .navbar{
            padding-left: 70px;
            
        }
        .navbar a{
            left: 79%;
            font-size: 1.3rem;
        }
        .navbar img{
            margin-left: 80px;
        }
        /* options */
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
                .dropdown-container a{
            position:static ;
            font-size: 1rem;
        }
        </style>
    </head>
    <body>
       <?php include 'resuableComponents\vendorHeader.php' ?>
            <div class="container">
            <!-- <h1 class="page-title">My Dashboard</h1> -->
            <div class="container-content">
       <?php include 'vendor_menu.php'; ?>

        <div class="main-content">
        <div class="dashboard-container">
    <!-- card for clients -->
    <div class="card total1">
        <div class="info">
            <div class="info-detail">
             
             
                <h2><span id="totalBookings"><?php echo $total_bookings ?></span></h2>
                <h3>Total Bookings</h3>
                <!-- <h4>New clients: <span id="newClients"></span></h4> -->
            </div>
        </div>
    </div>

    <!-- card for vendors -->
    <div class="card total2">
        <div class="info">
            <div class="info-detail">
         
            
                <h2><span id="totalVendors"><?php echo $pending_payments ?></span></h2>
                <h3>Pending Payments</h3>
                <!-- <h4>New vendors: <span id="newVendors"></span></h4> -->
            </div>
        </div>
    </div>

    <!-- card for bookings -->
    <div class="card total3">
        <div class="info">
            <div class="info-detail">
               
           
                <h2><span id=""></span>Kes <?php echo $total_revenue ?></h2>
                <h3>Total Revenue</h3>
                <!-- <h4>New bookings: <span id="newBookings"></span></h4> -->
            </div>
        </div>
    </div>
</div>
<!-- card bottom -->
<!-- main -->
                <div class="dashboard-block">
                <div class="card detail">
                                 <table>
                         <thead>
                         <h2>Bookings</h2> 
                        <tr>                      
                            <th>Client Name</th>
                            <th>Service</th>
                            <th>Booking Date</th>
                            <th>Event Date</th>
                            <th>Status</th>
                          
                        </tr>
                    </thead>
                    <tbody>
        <?php foreach ($rows as $row): ?>
            <tr>                         
                <td><?php echo $row['first_name'] . ' ' . $row['last_name']; ?></td>
                <td><?php echo $row['service_name']; ?></td>
                <td><?php echo $row['booking_date']; ?></td>
                <td><?php echo $row['event_date']; ?></td>
                <td><?php echo $row['status']; ?></td>
            
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
</div>
      

            </div>
        </div>

        </div>
    </div>
    <!-- message modal -->



    <script>
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
   <!--scripts-->
   <!--apexCharts-->
   <script src="chart.js"></script>
   <!-- <script src="vendorFilter.js"></script> -->
   <script src="script3.js"></script>
   <!-- <script src="charts.js"></script> -->
    <!-- <script src="received_msg.js"></script> -->
 </body>
</html>
