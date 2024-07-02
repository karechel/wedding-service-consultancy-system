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
        .navbar .dropdown-container{
            left: 87%;
        }
        .dropdown-container a{
            position:static ;
            font-size: 1rem;
        }
        button {
    /* padding: 10px 20px; */
    background-color: #e3bdb5;
    color: #000;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    width: 0px;
}
.right-section{
    right:120px;
    position: absolute;
}
button:hover {
    background-color: transparent;
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
                    <li><a href="#"><i class='bx bx-bell' ></i> </a></li>
                    <li><a href="#"><i class='bx bx-envelope' ></i> </a></li>
                    <button class="dropdown-btn"><i class='bx bx-user-circle'></i></button>
    <div class="dropdown-menu">
        <a href="#"><i class='bx bx-user-circle'></i> Profile</a>
        <a href="#"><i class='bx bx-cog bx-flip-horizontal' ></i> Settings</a>
        <div class="divider"></div>
        <a href="logout.php"><i class='bx bx-exit bx-flip-horizontal'></i> Sign Out</a>
    </div>
</div>
                   
                </ul>
            </div>
            </nav>
         
          </header>
            </body>
</html>
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