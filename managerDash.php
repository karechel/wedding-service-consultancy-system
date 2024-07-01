<?php
include 'connection.php';
include 'login.php';
$pdo = new PDO($dsn, $user, $password);

$statement1 = $pdo->query('SELECT COUNT(*) FROM clients');
$clientsCount = $statement1->fetchColumn();

$statement2 = $pdo->query('SELECT COUNT(*) FROM vendors');
$vendorsCount = $statement2->fetchColumn();

$statement3 = $pdo->query('SELECT COUNT(*) FROM bookings');
$bookingsCount = $statement3->fetchColumn();
$rows = [];
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

if (!isset($_SESSION['username'])) {
    // If not logged in, redirect to the login page
    header("Location: index.html");
    exit();
}

$rows = [];
try {
    // Check if the user is logged in and get their user_id
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
    // SQL query to select data from the tables
    $sql = "SELECT bookings.booking_id, clients.first_name, clients.last_name, vendors.vendor_name, services.service_name, bookings.booking_date, bookings.status, bookings.payment_status, bookings.event_date,users.username
            FROM bookings
            JOIN clients ON bookings.client_id = clients.client_id
            JOIN services ON bookings.service_id = services.service_id
            JOIN vendors ON bookings.vendor_id = vendors.vendor_id
            JOIN users ON vendors.user_id=users.user_id";

    // Execute query
    $stmt = $pdo->query($sql);

    // Fetch all rows as associative array
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
    margin-right: -100px;
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
            left: 87%;
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
        .navbar .dropdown-container{
            left: 87%;
        }
        .dropdown-container a{
            position:static ;
            font-size: 1rem;
        }
        </style>
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
            <div class="container">
            <!-- <h1 class="page-title">My Dashboard</h1> -->
            <div class="container-content">
         <div class="dashboard-sidebar">

            <div class="user-image">
            <img src="Images/pp.jpeg" alt="">
            <h3>
            <?php foreach ($rows as $row): ?>
            
            <?php endforeach; ?>
                <span>Manager</span>
            </h3>
            </div>
            <div class="dashboard-menu">
                <ul>
               <li><div class="dash-icon"><i class='bx bxs-dashboard'></i></div><a class="active" href="managerDash.php">Dashboard</a></li>
                <li> <div class="dash-icon"><i class='bx bxs-bookmark-heart'></i></div><a href="bookingsM.php">Bookings</a></li>
                <li><div class="dash-icon"><i class='bx bx-user'></i></div><a href="vendorsM.php">Vendors</a></li>
                <li><div class="dash-icon"><i class='bx bx-user'></i></div><a href="clientM.php">Clients</a></li>
                <li><div class="dash-icon"><i class='bx bx-wallet-alt' ></i></div><a href="finance.php">Finance</a></li>
                <li><div class="dash-icon"><i class='bx bxs-report' ></i></div><a href="#">Reports</a></li>
            </ul>
           <!-- <button><a href="#">Logout</a></button> -->
            </div>

        </div>

        <div class="main-content">
        <div class="dashboard-container">
    <!-- card for clients -->
    <div class="card total1">
        <div class="info">
            <div class="info-detail">
                <i class='bx bx-dots-vertical-rounded' onclick="toggleOptions(event)"></i>
                <div class="options">
                    <a href="#" onclick="filterContent('0', 'clients')">Today</a>
                    <a href="#" onclick="filterContent('1', 'clients')">Yesterday</a>
                    <a href="#" onclick="filterContent('2', 'clients')">2 days ago</a>
                    <a href="#" onclick="filterContent('3', 'clients')">3 days ago</a>
                </div>
                <h2><span id="totalClients"></span></h2>
                <h3>Clients</h3>
                <h4>New clients: <span id="newClients"></span></h4>
            </div>
        </div>
    </div>

    <!-- card for vendors -->
    <div class="card total2">
        <div class="info">
            <div class="info-detail">
                <i class='bx bx-dots-vertical-rounded' onclick="toggleOptions(event)"></i>
                <div class="options">
                    <a href="#" onclick="filterContent('0', 'vendors')">Today</a>
                    <a href="#" onclick="filterContent('1', 'vendors')">Yesterday</a>
                    <a href="#" onclick="filterContent('2', 'vendors')">2 days ago</a>
                    <a href="#" onclick="filterContent('3', 'vendors')">3 days ago</a>
                </div>
                <h2><span id="totalVendors"></span></h2>
                <h3>Vendors</h3>
                <h4>New vendors: <span id="newVendors"></span></h4>
            </div>
        </div>
    </div>

    <!-- card for bookings -->
    <div class="card total3">
        <div class="info">
            <div class="info-detail">
                <i class='bx bx-dots-vertical-rounded' onclick="toggleOptions(event)"></i>
                <div class="options">
                    <a href="#" onclick="filterContent('0', 'bookings')">Today</a>
                    <a href="#" onclick="filterContent('1', 'bookings')">Yesterday</a>
                    <a href="#" onclick="filterContent('2', 'bookings')">2 days ago</a>
                    <a href="#" onclick="filterContent('3', 'bookings')">3 days ago</a>
                </div>
                <h2><span id="totalBookings"></span></h2>
                <h3>Bookings</h3>
                <h4>New bookings: <span id="newBookings"></span></h4>
            </div>
        </div>
    </div>
</div>
<!-- card bottom -->
<!-- main -->
                <div class="dashboard-block">

                 <div class="bookings-summary">
                    <p>Bookings Summary</p>
                    <!-- start of summary section -->
                    <div class="summaries">
                    <div class="button-container">
      <button id="thisWeekButton" class="filter-button" onclick="filterData('thisWeek')">This Week</button>
      <button id="lastWeekButton" class="filter-button" onclick="filterData('lastWeek')">Last Week</button>
  </div>
                        <div class="chart">
                        <p>Booking Status </p>
                        <canvas id="pieChart" width="200" height="200"></canvas>
                     <div id="legend" class="legend"></div>


                        </div>
                        <!-- start of overview -->
                        <div class="overview">
                        <div class="card total1">
                    <div class="info">
                      <div class="info-detail">

                      <h2 id="totalNewBookings"> </h2>
                        <h3>New Bookings</h3>
                      </div>

                    </div>
                </div>
                <div class="card total2">
                    <div class="info">
                        <div class="info-detail">

                        <h2 id="totalCompletedBookings"> </h2>
                          <h3>Completed Bookings</h3>
                        </div>

                      </div>
                </div>
                        </div>
                    </div>
                    <!-- end of booking details summaries -->

                 </div>


        <div class="general-summaries">
            <div class="finance-summaries">
            <div id="lineGraphContainerRevenue">
        <h1>Total Revenue </h1>
        <div class="chart-container">
            <div class="button-container">
                <button id="monthlyButtonRevenue" class="filter-button" onclick="filterLineGraphDataRevenue('monthly')">Monthly</button>
                <button id="quarterlyButtonRevenue" class="filter-button" onclick="filterLineGraphDataRevenue('quarterly')">Quarterly</button>
                <button id="yearlyButtonRevenue" class="filter-button" onclick="filterLineGraphDataRevenue('yearly')">Yearly</button>
            </div>
            <canvas id="lineChartRevenue" width="400" height="400"></canvas>
        </div>
    </div>

    <div id="lineGraphContainerExpenses">
        <h1>Total Expenses </h1>
        <div class="chart-container">
            <div class="button-container">
                <button id="monthlyButtonExpenses" class="filter-button" onclick="filterLineGraphDataExpenses('monthly')">Monthly</button>
                <button id="quarterlyButtonExpenses" class="filter-button" onclick="filterLineGraphDataExpenses('quarterly')">Quarterly</button>
                <button id="yearlyButtonExpenses" class="filter-button" onclick="filterLineGraphDataExpenses('yearly')">Yearly</button>
            </div>
            <canvas id="lineChartExpenses" width="400" height="400"></canvas>
        </div>
    </div>
      
        </div>

<div class="overview">
        <div class="card total1">
                    <div class="info">
                      <div class="info-detail">
                  
                      <h2><?php echo $clientsCount; ?> </h2>
                        <h3>Income </h3>                  
                      </div>
                     
                    </div>
                </div>
                <div class="card total2">
                    <div class="info">
                      <div class="info-detail">
                  
                      <h2><?php echo $clientsCount; ?> </h2>
                        <h3>Expense </h3>                  
                      </div>
                     
                    </div>
                </div>
        </div>
    </div>

            </div>
        </div>

        </div>
    </div>
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
   <script src="script2.js"></script>
   <script src="script3.js"></script>
   <!-- <script src="charts.js"></script> -->
 </body>
</html>
