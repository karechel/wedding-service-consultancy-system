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
    top: 100%; /* Adjust positioning as needed */
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
    border-radius: 25px;
}

.divider {
    height: 1px;
    background-color: #ccc;
    margin: 8px 0;
}

.navbar .dropdown-container {
    left: 87%; /* Adjust positioning relative to the navbar */
}

       
.dropdown-container img {
    width: 35px;
    margin-left: 0;
}
.modal-content form{
    justify-content: center;
    display: flex;
    flex-direction: column;
}
#deleteAccountBtn{
    text-align: left;
    background: transparent;
    color: #000;
    font-weight: 500;
    font-size: 17px;
    width: 70%;
    margin-left: 16px;
    border: none;
}
.bx{
    font-size: 25px;
    color: #e3bdb5;
}
           </style>
    </head>
    <body>
    <header class="header">
            <nav class="navbar">
                <img src="Images/logo.jpg" width="80" height="60">
                <a href="#"><i class='bx bx-bell'></i></a>
                <a id="openMessagesBtn" href="#"><i class='bx bx-message'></i></a>
                <div class="dropdown-container">
    <button class="dropdown-btn"><img src="Images/profile2.svg" alt=""></i></button>
    <div class="dropdown-menu">
        <a href="#"><i class='bx bx-user-circle'></i> Profile</a>
        <button id="deleteAccountBtn"><i class='bx bx-trash-alt'></i> Delete Account</button>
        <div class="divider"></div>
        <a href="logout.php"><i class='bx bx-exit bx-flip-horizontal'></i> Sign Out</a>
    </div>
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

<script src="resuableComponents\activeLink.js"></script>
<script>
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