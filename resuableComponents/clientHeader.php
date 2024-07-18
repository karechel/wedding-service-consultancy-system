<?php
include 'connection.php'; // Ensure connection to the database

$client_name = '';
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    try {
        // SQL query to fetch client name
        $stmt = $pdo->prepare("SELECT first_name, last_name FROM clients WHERE user_id = :user_id");
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();

        // Fetch client name
        $client = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($client) {
            $client_name = $client['first_name'] . ' ' . $client['last_name'];
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
    <style>
        .dropdown-btn {
            background: none;
            border: none;
            cursor: pointer;
            font-size: 24px;
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
        .navbar .dropdown-container {
            left: 87%;
        }
        .dropdown-container a {
            position: static;
            font-size: 1rem;
        }
        button {
            background-color: #e3bdb5;
            color: #000;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 0px;
        }
        .right-section {
            right: 120px;
            position: absolute;
        }
        button:hover {
            background-color: transparent;
        }
        .dropdown-menu button {
            text-align: left;
            background: transparent;
            color: #000;
            font-weight: 500;
            font-size: 17px;
            width: 70%;
            margin-left: 16px;
        }
        .dropdown-menu button:hover {
            border-radius: 25px;
            background: #e2e8f0;
        }
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
        }
        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 500px;
            border-radius: 10px;
        }
        .modal-content button {
            background-color: #e3bdb5;
            color: black;
            border: none;
            padding: 10px 20px;
            margin: 10px;
            cursor: pointer;
            border-radius: 5px;
            width: 50%;
        }
        .modal-content button:hover {
            background-color: #d9a4a3;
        }
        .modal-content .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }
        .modal-content .close:hover,
        .modal-content .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
        form{
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        
        .modal-content p{
            text-align: center;
        }
    </style>
</head>
<body>
    <header class="header">
        <nav class="navbar">
            <a href="client.php">Dashboard</a>
            <a href="bookingsC.php">Bookings</a>
            <a href="vendorServices.php">Services</a>
            <a href="transHist.php">Payments</a>
            <a href="review.php">Review</a>
            <div class="right-section">
                <ul>
                    <li><a href="#"><i class='bx bx-bell'></i></a></li>
                    <li><a href="#"><i class='bx bx-envelope'></i></a></li>
                    <li>
                        <button class="dropdown-btn"><img src="Images/profile2.svg" alt=""></button>
                        <span><?php echo htmlspecialchars($client_name); ?></span>
                    </li>
                    <div class="dropdown-menu">
                        <a href="client_profile.php"><i class='bx bx-user-circle'></i> Profile</a>
                        <button id="deleteAccountBtn"><i class='bx bx-trash-alt'></i> Delete Account</button>
                        <div class="divider"></div>
                        <a href="logout.php"><i class='bx bx-exit bx-flip-horizontal'></i> Sign Out</a>
                    </div>
                </ul>
            </div>
        </nav>
    </header>

    <div id="deleteAccountModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <p>Are you sure you want to delete your account?</p>
            <form action="delete_account.php" method="POST">
                <button type="submit" name="delete_self">Yes, delete my account</button>
                <button type="button" id="cancelBtn">Cancel</button>
            </form>
        </div>
    </div>
</body>
</html>

<script>
    document.querySelector('.dropdown-btn').addEventListener('click', function() {
        const dropdownMenu = document.querySelector('.dropdown-menu');
        dropdownMenu.style.display = dropdownMenu.style.display === 'block' ? 'none' : 'block';
    });

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

    // Modal for account deletion confirmation
    var modal = document.getElementById("deleteAccountModal");
    var btn = document.getElementById("deleteAccountBtn");
    var span = document.getElementsByClassName("close")[0];
    var cancelBtn = document.getElementById("cancelBtn");

    btn.onclick = function() {
        modal.style.display = "block";
    }

    span.onclick = function() {
        modal.style.display = "none";
    }

    cancelBtn.onclick = function() {
        modal.style.display = "none";
    }

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>
<script src="resuableComponents/activeLink.js"></script>
