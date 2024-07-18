<?php
include 'connection.php';

try {
    // Create a new PDO instance
    $pdo = new PDO($dsn, $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Count all clients
    $statement1 = $pdo->query('SELECT COUNT(*) FROM clients');
    $clientsCount = $statement1->fetchColumn();

    // Count all vendors
    $statement2 = $pdo->query('SELECT COUNT(*) FROM vendors');
    $vendorsCount = $statement2->fetchColumn();

    // Count all bookings
    $statement3 = $pdo->query('SELECT COUNT(*) FROM bookings');
    $bookingsCount = $statement3->fetchColumn();

    // Count active vendors
    $vendor_sql = "SELECT COUNT(*) AS vendor_count FROM users WHERE role = 'Vendor' AND (status = '' OR status IS NULL)";
    $vendor_stmt = $pdo->query($vendor_sql);
    $vendor_result = $vendor_stmt->fetch(PDO::FETCH_ASSOC);
    $vendor_count = $vendor_result['vendor_count'];

    // Count active clients where status is empty or NULL
    $client_sql = "SELECT COUNT(*) AS client_count FROM users WHERE role = 'Client' AND (status = '' OR status IS NULL)";
    $client_stmt = $pdo->query($client_sql);
    $client_result = $client_stmt->fetch(PDO::FETCH_ASSOC);
    $client_count = $client_result['client_count'];

    $active_subscriptions_count = $client_count + $vendor_count;
    // SQL query to select data from the tables
    $sql = "SELECT vendors.vendor_name, transactions.booking_id, clients.first_name,clients.last_name, transactions.transaction_date, transactions.amount,transactions.status
            FROM transactions
            JOIN vendors ON transactions.vendor_id= vendors.vendor_id
            JOIN clients ON transactions.client_id=clients.client_id";

    // Execute query
    $stmt = $pdo->query($sql);

    // Fetch all rows as associative array
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    

    $stmt = $pdo->prepare("SELECT SUM(amount) AS total_amount FROM transactions");

    // Execute the statement
    $stmt->execute();

    // Fetch the result
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

  
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
    margin-right: -10px;
    justify-content: right;
}
.info-detail h2 {
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
    margin-bottom: 30px;
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
        .total5 h2,
        .total5 h3{
            color: #f59e0b;
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
        .total4 {
         grid-column: 4 / span 1;
        grid-row: 1 / span 1;
        }
        .total5 {
        grid-column: 5 / span 1;
        grid-row: 1 / span 1;
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
            height: 189px;
        }
        .overview .total2{
            background: #f0fdf4;
            height: 189px;
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
            width: 60%;
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
        .material-symbols-outlined {
        font-size: 18px;    
}
.detail {
    width: 1000px;
    grid-row: 1 / span 1;
    margin-bottom: 50px;
}
.dashboard-container {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    grid-template-rows: auto auto 1fr;
    gap: 1rem;
    width: 1000px;
}
        </style>
    </head>
    <body>
    <?php include 'resuableComponents\managerHeader.php' ?>
            <div class="container">
            <!-- <h1 class="page-title">My Dashboard</h1> -->
            <div class="container-content">
         <div class="dashboard-sidebar">

            <div class="user-image">
            <img src="Images/pp.jpeg" alt="">
            <h3>
                Jane Doe<br>
                <span>Manager</span>
            </h3>
            </div>
            <div class="dashboard-menu">
                <ul>
               <li><div class="dash-icon"><i class='bx bxs-dashboard'></i></div><a class="active" href="ManagerDash.php">Dashboard</a></li>
                <li> <div class="dash-icon"><i class='bx bxs-bookmark-heart'></i></div><a href="bookingsM.php">Bookings</a></li>
                <li><div class="dash-icon"><i class='bx bx-user'></i></div><a href="vendorsM.php">Vendors</a></li>
                <li><div class="dash-icon"><i class='bx bx-user'></i></div><a href="clientM.php">Clients</a></li>
                <li><div class="dash-icon"><i class='bx bx-wallet-alt' ></i></div><a href="finance.php">Finance</a></li>
               
            </ul>
           <!-- <button><a href="#">Logout</a></button> -->
            </div>

        </div>

        <div class="main-content">

            <div class="dashboard-container">
                <!-- cards -->
                <div class="card total1">
                    <div class="info">
                      <div class="info-detail">
                      <!-- <i class='bx bx-dots-vertical-rounded' onclick="toggleOptions(event)"></i> -->
                <div class="options">
                    <a href="#">Yesterday</a>
                    <a href="#">2 days ago</a>
                    <a href="#">3 days ago</a>
                </div>
                      <h2>Ksh <?php echo $result['total_amount']; ?> </h2>
                        <h3>Gross Revenue</h3>
                      </div>

                    </div>
                </div>
                <div class="card total2">
                    <div class="info">
                        <div class="info-detail">
                        <!-- <i class='bx bx-dots-vertical-rounded' onclick="toggleOptions(event)"></i> -->
                <div class="options">
                    <a href="#">Yesterday</a>
                    <a href="#">2 days ago</a>
                    <a href="#">3 days ago</a>
                </div>
                        <h2><?php echo $client_count; ?> </h2>
                          <h3>Active clients</h3>
                        </div>

                      </div>
                </div>
                <div class="card total3">
                    <div class="info">
                        <div class="info-detail">
                        <!-- <i class='bx bx-dots-vertical-rounded' onclick="toggleOptions(event)"></i> -->
                <div class="options">
                    <a href="#">Yesterday</a>
                    <a href="#">2 days ago</a>
                    <a href="#">3 days ago</a>
                </div>
                        <h2><?php echo htmlspecialchars($vendor_count); ?></h2>
                          <h3>Active Vendors</h3>
                        </div>

                      </div>
                </div>
             
         
                <!-- card bottom -->

            </div>
        <!-- </main> -->

                <div class="dashboard-block">
                <div class="bookings-summary">
                    <!-- start of summary section -->
                    <div class="summaries">
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
    </div>
    </div>
                        <!-- start of overview -->
                        <div class="overview">
                        <div class="card total1">
                    <div class="info">
                      <div class="info-detail">

                      <h2><?php echo htmlspecialchars($active_subscriptions_count); ?></h2>
                        <h3>Active Subscriptions</h3>
                         
                    </div>

                    </div>
                </div>
                <!-- <div class="card total2">
                    <div class="info">
                        <div class="info-detail">

                        <h2><?php echo $vendorsCount; ?> </h2>
                          <h3>New Subscriptions</h3>
                          <h4> Total Revenue:  </h4> 
                        </div>

                      </div>
                </div>                      -->
                        </div>
                    </div>
                    <!-- end of booking details summaries -->

                 </div>

                <div class="card detail">
                                 <table>
                         <thead>
                         <h2>Transaction History</h2> 
                        <tr>                      
                            <th>Booking ID</th>
                            <th>Client  Name</th>
                            <th>Vendor  Name</th>
                            <th>Amount</th>
                            <th>Transaction  Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
        <?php foreach ($rows as $row): ?>
            <tr> 
            <td>BK00<?php echo $row['booking_id']; ?></td>                        
                <td><?php echo $row['first_name'] .' '. $row['last_name']; ?></td>
                <td><?php echo $row['vendor_name']; ?></td>
                <td><?php echo $row['amount']; ?></td>
                <td><?php echo $row['transaction_date']; ?></td>
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
   <script src="script2.js"></script>
   <script src="script3.js"></script>
   <script src="charts.js"></script>
 </body>
</html>
