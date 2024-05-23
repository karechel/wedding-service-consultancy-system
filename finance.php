<?php
include 'connection.php'; // Ensure connection to the database
 
$rows = [];
try {
    // SQL query to select data from the tables
    $sql = "SELECT vendor_services.vendor_id, vendors.vendor_name, services.service_name, vendors.location, vendor_services.price, vendor_services.rating
            FROM vendor_services
            JOIN services ON vendor_services.service_id = services.service_id
            JOIN vendors ON vendor_services.vendor_id = vendors.vendor_id";

    // Execute query
    $stmt = $pdo->query($sql);

    // Fetch all rows as associative array
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Debug: Check if $rows is populated
    // var_dump($rows); // Use this to verify if $rows contains data

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
                    <p class="role"> Manager    </p>
                    </div>
                    <div class="sidebar-menu ">
                    <span   class="bx bx-sidebar dash"></span><p class="dash"><a href="managerDash.php"> Dashboard</a></p>
                </div>
                <div class="sidebar-menu">
                    <span class="bx bx-bookmark-heart"></span><p><a href="bookingsM.php">Bookings</a></p>
                </div>
                <div class="sidebar-menu">
                    <span class="bx bx-user"></span><p> <a href="vendorsM.php"> Vendors</a></p>
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
                    <!-- cards -->
                    <div class="card total1">
                        <div class="info">
                          <div class="info-detail">
                            <h3>Total Earnings</h3>
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
                              <h3>Paid Bookings</h3>
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
                              <h3>Unpaid Bookings</h3>
                              <h2><?php echo $bookingsCount; ?> </h2>
                            </div>
                            <div class="info-image">
                                <i class='bx bx-book-heart'></i>
                            </div>
                          </div>
                    </div>
                 
                    <!-- card bottom -->
    
                </div>
            <div class="dashboard-container">
               <div class="main-dashboard-content">
                <div class="card detail">
                     <div class="detail-header">
                        <h2> Bookings Transactions</h2>
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
                     <table>
                        <tr>
                            <th>Booking #</th>
                            <th>Client</th>                      
                            <th>Service Booked</th>
                            <th>Payment status</th>
                            <th>Amount</th>
                        </tr>
                        <tr>
                            <td>BK-0001</td>
                            <td>Jane Wairimu</td>
                            <td>Venue</td>
                            <td><span class="status onprogress">Due</span></td>
                            <td>5000 </td>
                        </tr>
                        <tr>
                            <td>BK-0001</td>
                            <td>Natalie Kerring</td>
                            <td>Venue</td>
                            <td><span class="status onprogress">Paid</span></td>
                            <td>6000</td>
                        </tr>
                     </table>
                </div>
                <div class="card detail">
                    <div class="detail-header">
                       <h2> Payment status</h2>
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
                    <table>
                       <tr>
                           <th>Booking #</th>
                           <th>Payment status</th>
                           <th>Balance</th>
                       </tr>
                       <tr>
                           <td>BK-0001</td>
                           <td><span class="status onprogress">Due</span></td>
                           <td>5000 </td>
                       </tr>
                       <tr>
                           <td>BK-0001</td>
                           <td><span class="status onprogress">Paid</span></td>
                           <td>6000</td>
                       </tr>
                    </table>
               </div>
               <div class="financial-reports">
                <h1>Financial Reports</h1> <br>
                <div class="reports-content">
               <div class="card detail">
                
                <div class="detail-header">
                   <h2> Profit and Loss statement</h2>
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
                <table>
                   <tr>
                       <th>Date</th>
                       <th>Revenue</th>
                       <th>Expense</th>
                       <th>Profit</th>
                   </tr>
                   <tr>
                       <td>BK-0001</td>
                       <td>5000</td>
                       <td>5000 </td>
                       <td>5000 </td>
                   </tr>
                   <tr>
                       <td>BK-0001</td>
                       <td>6000</td>
                       <td>6000</td>
                       <td>5000 </td>
                   </tr>
                </table>
           </div>
           <!-- end of profit loss -->

           <!-- start of revenue breakdown -->
           <div class="card detail">
          
            <div class="detail-header">
               <h2> Profit and Loss statement</h2>
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
            <table>
               <tr>
                   <th>Category</th>
                   <th>Revenue</th>
               </tr>
               <tr>
                   <td>Catering</td>
                   <td>5000 </td>
               </tr>
               <tr>
                   <td>Catering</td>
                   <td>6000</td>
               </tr>
            </table>
       </div>
        </div>
    </div>
        <!-- End of financial reports -->

        <!-- start of invoice -->
        <div class="card detail">
                
            <div class="detail-header">
               <h2> Invoice</h2>
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
            <table>
               <tr>
                   <th>Invoice #</th>
                   <th>Client</th>
                   <th>Total</th>
                   <th>Payment Date</th>
                   <th>Balance</th>
                   <th>Action</th>
               </tr>
               <tr>
                   <td>BK-0001</td>
                   <td>Jane</td>
                   <td>5000 </td>                   
                   <td>5/2024 </td>
                   <td>5000 </td>  
                   <td>
                    <button><i class="bi bi-eye" style=' font-size: 23px;'></i></button>  
                    <button> <i class='bx bx-pencil' style=' font-size: 23px;' ></i></button>
                    <button><i class='bx bx-trash' style=' font-size: 23px;' ></i></button>
                </td>
               </tr>
               <tr>
                <td>BK-0001</td>
                <td>Jane</td>
                <td>5000 </td>                   
                <td>5/2024 </td>
                <td>5000 </td> 
                <td>
                    <button><i class="bi bi-eye" style=' font-size: 23px;'></i></button>  
                    <button> <i class='bx bx-pencil' style=' font-size: 23px;' ></i></button>
                    <button><i class='bx bx-trash' style=' font-size: 23px;' ></i></button>
                </td>
               </tr>
            </table>
       </div>
            </div>
            </div>
        </main>
    </body>
</html>