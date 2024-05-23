<?php
include 'connection.php';
$pdo = new PDO($dsn, $user, $password);

$statement1 = $pdo->query('SELECT COUNT(*) FROM clients');
$clientsCount = $statement1->fetchColumn();

$statement2 = $pdo->query('SELECT COUNT(*) FROM vendors');
$vendorsCount = $statement2->fetchColumn();

$statement3 = $pdo->query('SELECT COUNT(*) FROM bookings');
$bookingsCount = $statement3->fetchColumn();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Website with Login and Registration Form</title>
        <link rel="stylesheet" href="style3.css">
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    </head>
    <body>
        <!-- <header class="header">
            <nav class="navbar">
                <a href="#">Home</a>
                <a href="#">Services</a>
                <a href="#">Contact</a>
                
            </nav>
        </header> -->
            <div class="container">
            <h1 class="page-title">My Dashboard</h1>
            <div class="container-content">
         <div class="dashboard-sidebar">
         
            <div class="user-image">
            <img src="Images/pp.jpeg" alt="">
            <h3>
                Jane Doe<br>
                <span>DJ Doe</span>
            </h3>
            </div>
            <div class="dashboard-menu">
                <ul>
               <li><div class="dash-icon"><i class='bx bxs-dashboard'></i></div><a class="active" href="#">Dashboard</a></li>
                <li> <div class="dash-icon"><i class='bx bxs-bookmark-heart'></i></div><a href="#">Bookings</a>
                <li> <a href="BookingList.php">booking List</a></li>
                <li> <a href="BookingDetails.php">Booking details</a></li>
            </li>
                <li><div class="dash-icon"><i class='bx bx-user'></i></div><a href="servicesV.php">services</a></li>
                <li><div class="dash-icon"><i class='bx bx-wallet-alt' ></i></div><a href="#">schedule</a></li>
                <li><div class="dash-icon"><i class='bx bxs-report' ></i></div><a href="#">Reports</a></li>
            </ul>
           <button><a href="#">Logout</a></button>
            </div>
        
        </div>
        
        <div class="main-content">
            <div class="details-lists">
            <div class="single-list-one">
    <div class="list-icon">
        <i class='bx bx-check-circle bx-tada bx-flip-vertical' style='color:darkblue; font-size: 36px;'></i>
    </div>
    <h3><?php echo $clientsCount; ?></h3>
    <span>  Confirmed Bookings</span>
</div>

<div class="single-list-two">
    <div class="list-icon">
    <i class='bx bx-book-heart bx-rotate-90 bx-tada' style='color:darkblue; font-size: 36px;'></i>
       
    </div>
    <h3><?php echo $vendorsCount; ?></h3>
    <span>Pending Bookings</span>
</div>

<div class="single-list-three">
    <div class="list-icon">
    <i class='bx bx-bolt-circle bx-rotate-90 bx-tada' style='color:darkblue; font-size: 36px;'></i>
    </div>
    <h3><?php echo $bookingsCount; ?></h3>
    <span>Upcoming Events</span>
</div>
</div>
         <div class="dashboard-content">
         <div class="events-container">
                <h2>My Bookings</h2>
              
                    
                    <div class="myservices">
                        
                        <div class="headings">
                            <span>Client Name</span>
                            <span>Booking Date</span>
                            <span>Status</span>
                            <span>Payment status</span>
                        </div>
                        <div class="service">
                            <span>Jane Doe</span>
                            <span>2024-03-08</span>
                            <span>Confirmed</span>
                            <span>Paid</span>
                        </div>
                        <div class="service">
                        <span>John Doe</span>
                            <span>2024-03-08</span>
                            <span>Pending</span>
                            <span>Due</span>
                        </div>
                        <!-- Add more services as needed -->
                    </div>
                    
         </div>     
        </div>
    </div>
    </div>
    </div>
   <!--scripts-->
   <!--apexCharts-->
   
 </body>
</html>
