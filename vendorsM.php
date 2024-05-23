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
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2family=poppins&display=swap">
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
        <!-- Option 1: Include in HTML -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
        <title>Bookings</title>
        <style>
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
    left: 72%;
    top: 18%;
}
.detail-header {
    display: grid;
    grid-auto-flow: column;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 25px;
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
}
.navbar {
    padding-left: 70px;
    height: 4rem;
    }
    .navbar a{
            left: 87%;
            font-size: 1.3rem;
        }
        .navbar img{
            margin-left: 80px;
        }
    </style>
    </head>
    <body>
       <!--navbar--> 
       <<header class="header">
            <nav class="navbar">
                <img src="Images/logo.jpg" width="80" height="60">
                <a href="#"><i class='bx bx-bell'></i></a>
                <a href=""><i class='bx bx-message'></i></a>
                <a href="#"><i class='bx bx-user-circle' ></i></a>
            </nav>
        </header>
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
               
                <div class="card detail">
                     <div class="detail-header">
                        <h2>All Vendors</h2>
                        <div class="filter">
                                
                                <input type="search" name="" id="search" placeholder="Search Vendors">
                            </div>
                            <div class="addBookingBtn">
                            <button><i class='bx bx-plus'></i>Add</button>
                        </div>  
                     </div>
                     <table>
                        <tr>
                            <th>Vendor #</th>
                            <th>Vendor</th>
                            <th>Service</th>
                            <th>Location</th>
                            <th>Pricing</th>                            
                            <th>Rating</th>
                            <th>Action</th>                           
                        </tr>
                        <?php foreach ($rows as $row): ?>
                        <tr>
                            <td><?php echo $row['vendor_id']; ?></td>
                            <td><?php echo $row['vendor_name']; ?></td>
                            <td><?php echo $row['service_name']; ?></td>
                            <td><?php echo $row['location']; ?></td>
                            <td><?php echo $row['price']; ?></td>
                            <td><?php echo $row['rating']; ?></td>
                            <td>
                <i class="material-symbols-outlined">visibility</i>
        <span class="material-symbols-outlined">edit</span>
                    <span class="material-symbols-outlined">delete</span>
                </td>
                        </tr>
                        <?php endforeach; ?>
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