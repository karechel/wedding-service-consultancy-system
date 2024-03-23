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
                <span>Manager</span>
            </h3>
            </div>
            <div class="dashboard-menu">
                <ul>
               <li><div class="dash-icon"><i class='bx bxs-dashboard'></i></div><a class="active" href="#">Dashboard</a></li>
                <li> <div class="dash-icon"><i class='bx bxs-bookmark-heart'></i></div><a href="bookingsM.html">Bookings</a></li>
                <li><div class="dash-icon"><i class='bx bx-user'></i></div><a href="#">Vendors</a></li>
                <li><div class="dash-icon"><i class='bx bx-wallet-alt' ></i></div><a href="#">Finance</a></li>
                <li><div class="dash-icon"><i class='bx bxs-report' ></i></div><a href="#">Reports</a></li>
            </ul>
           <button><a href="#">Logout</a></button>
            </div>

        </div>

        <div class="main-content">
            <!-- <div class="details-lists">
            <div class="single-list-one">
    <div class="list-icon">
        <i class='bx bx-check-circle bx-tada bx-flip-vertical' style='color:darkblue; font-size: 36px;'></i>
    </div>
    <h3></h3>
    <span>Total Number of Clients</span>
</div>

<div class="single-list-two">
    <div class="list-icon">
        <i class='bx bx-bolt-circle bx-rotate-90 bx-tada' style='color:darkblue; font-size: 36px;'></i>
    </div>
    <h3></h3>
    <span>Total Number of Vendors</span>
</div>

<div class="single-list-three">
    <div class="list-icon">
        <i class='bx bx-book-heart bx-rotate-90 bx-tada' style='color:darkblue; font-size: 36px;'></i>
    </div>
    <h3></h3>
    <span>Total Number of Bookings</span>
</div>
</div> -->
<!-- <main> -->
            <div class="dashboard-container">
                <!-- cards -->
                <div class="card total1">
                    <div class="info">
                      <div class="info-detail">
                        <h3>Clients</h3>
                        <h2><?php echo $clientsCount; ?> </h2>
                      </div>
                      <div class="info-image">
                        <i class='bx bx-male-female'></i>
                      </div>
                    </div>
                </div>
                <div class="card total2">
                    <div class="info">
                        <div class="info-detail">
                          <h3>vendors</h3>
                          <h2><?php echo $vendorsCount; ?> </h2>
                        </div>
                        <div class="info-image">
                            <i class='bx bx-medal'></i>
                        </div>
                      </div>
                </div>
                <div class="card total3">
                    <div class="info">
                        <div class="info-detail">
                          <h3>Bookings</h3>
                          <h2><?php echo $bookingsCount; ?> </h2>
                        </div>
                        <div class="info-image">
                            <i class='bx bx-book-heart'></i>
                        </div>
                      </div>
                </div>
                <!-- card bottom -->

            </div>
        <!-- </main> -->

                <div class="dashboard-block">

                    <div class="wrapper">
                    <div class="card">
                    <div class="title-wrapper">
                    <h3 class="title">Revenue overview</h3>
                    <div class="filter">
                    <a class="active" href="#">Day</a>
                    <a href="#">Week</a>
                    <a href="#">Month</a>
                    </div>
                </div>
                <div class="chart-container">
                    <div id="chLine"></div>
                </div>
                </div>
                </div>


  <div class="section-rated-vendors">
  <div class="card detail">
                     <div class="detail-header">
                        <h2>Highest rated Vendors</h2>
                      
                     </div>
                     <table>
                        <tr>
                            <th>vendor Name</th>
                            <th>Rating</th>
                            <th>Category</th>
                           
                        </tr>
                        <tr>
                           
                            <td>John Macharia</td>
                            <td>4.5</td>
                            <td>Photographer</td>
                        </tr>
                        <tr>
                            
                            <td>Nathan Kamula</td>
                            <td>5</td>
                            <td>Caterer</td>
                        </tr>
                     </table>
                </div>
  </div>

        </div>
    </div>
   <!--scripts-->
   <!--apexCharts-->
   <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
   <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
   <script src="charts.js"></script>
 </body>
</html>
