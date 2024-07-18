<?php
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
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Website with Login and Registration Form</title>      
        <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Parisienne&display=swap" rel="stylesheet">
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
       
    </head>
    <body>
      
    <div class="dashboard-sidebar">

<div class="user-image">
<img src="Images/pp.jpeg" alt="">
<h3>
<?php echo htmlspecialchars($vendor_name); ?>  </span>
    <span>Vendor</span>
</h3>
</div>
<div class="dashboard-menu">
    <ul>
   <li><div class="dash-icon"><i class='bx bxs-dashboard'></i></div><a class="active" href="vendorD.php">Dashboard</a></li>
    <li> <div class="dash-icon"><i class='bx bxs-bookmark-heart'></i></div><a href="BookingList.php">Bookings</a></li>
    <li> <div class="dash-icon"><i class='bx bxs-bookmark-heart'></i></div><a href="servicesV.php">Services</a></li>
    <li><div class="dash-icon"><i class='bx bx-user'></i></div><a href="clientV.php">Clients</a></li>
    <li><div class="dash-icon"><i class='bx bx-wallet-alt' ></i></div><a href="financev.php">Finance</a></li>
</ul>
<!-- <button><a href="#">Logout</a></button> -->
</div>

</div>
            </body>
</html>

         