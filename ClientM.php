<?php
include 'connection.php'; // Ensure connection to the database
 
$rows = [];
try {
    // SQL query to select data from the tables
    $sql = "SELECT clients.client_id, clients.first_name, clients.last_name, clients.contact_number, clients.wedding_date, clients.location, users.user_id, users.status
            FROM clients
            JOIN users ON clients.user_id = users.user_id";

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
            body{
                background: #ededed;
            }
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
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0,0,0);
            background-color: rgba(0,0,0,0.4);
            padding-top: 60px;
        }
        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            height: 100%;
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }
        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
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
       <!--navbar--> 
       <?php include 'resuableComponents\managerHeader.php' ?>
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
                    <span class="bx bx-user"></span><p> <a href="ClientM.php"> Clients</a></p>
                </div>
                <div class="sidebar-menu">
                    <span class="bx bx-wallet-alt"></span><p><a href="finance.php">Finance</a></p>
                </div>
             
               
               
            </div>
            <!--Maindashboard--> 
            <main>
            <div class="dashboard-container">
               
                <div class="card detail">
                     <div class="detail-header">
                        <h2>All Clients</h2>
                        <div class="filter">
                                
                                <input type="search" name="" id="search" placeholder="Search Vendors">
                            </div>
                            <div class="addBookingBtn">
                            <button><i class='bx bx-plus'></i>Add</button>
                        </div>  
                     </div>
                     <table>
                    <thead>
                        <tr>
                            <th>Client #</th>
                            <th>Name</th>
                            <th>Contact</th>
                            <th>Location</th>
                            <th>Event Date</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($rows as $row): ?>
                        <tr>
                            <td><?php echo $row['client_id']; ?></td>
                            <td><?php echo $row['first_name'] . ' ' . $row['last_name']; ?></td>
                            <td><?php echo $row['contact_number']; ?></td>
                            <td><?php echo $row['location']; ?></td>
                            <td><?php echo $row['wedding_date']; ?></td>
                            <td><?php echo $row['status']; ?></td>
                            <td>
                            <span class="material-symbols-outlined edit"
                                          data-client-id="<?php echo $row['client_id']; ?>"
                                          data-first-name="<?php echo $row['first_name']; ?>"
                                          data-last-name="<?php echo $row['last_name']; ?>"
                                          data-contact-number="<?php echo $row['contact_number']; ?>"
                                          data-location="<?php echo $row['location']; ?>"
                                          data-wedding-date="<?php echo $row['wedding_date']; ?>">edit</span>
                            <span class="material-symbols-outlined delete" data-user-id="<?php echo $row['user_id']; ?>">delete</span>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Edit Client</h2>
            <form id="editForm" method="POST" action="update_client.php">
                <input type="hidden" id="editClientId" name="client_id">
                <label for="editFirstName">First Name:</label>
                <input type="text" id="editFirstName" name="first_name">
                <label for="editLastName">Last Name:</label>
                <input type="text" id="editLastName" name="last_name">
                <label for="editContactNumber">Contact Number:</label>
                <input type="text" id="editContactNumber" name="contact_number">
                <label for="editLocation">Location:</label>
                <input type="text" id="editLocation" name="location">
                <label for="editWeddingDate">Wedding Date:</label>
                <input type="text" id="editWeddingDate" name="wedding_date">
                <button type="submit">Save Changes</button>
            </form>
        </div>
    </div>

                  
                </div>
               
            </div>
        </main>
        <script>
             document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('.delete').forEach(button => {
            button.addEventListener('click', function () {
                const userId = this.dataset.userId;

                if (confirm('Are you sure you want to suspend this user?')) {
                    const form = document.createElement('form');
                    form.action = 'delete_accountM.php';
                    form.method = 'POST';

                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'suspend_user_id';
                    input.value = userId;

                    form.appendChild(input);
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        });
    });

 //dropdown menu
       
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


    //edit modal
  // Delete client confirmation
  document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('.delete').forEach(button => {
                button.addEventListener('click', function () {
                    const userId = this.dataset.userId;

                    if (confirm('Are you sure you want to delete this client?')) {
                        const form = document.createElement('form');
                        form.action = 'delete_client.php';
                        form.method = 'POST';

                        const input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = 'delete_user_id';
                        input.value = userId;

                        form.appendChild(input);
                        document.body.appendChild(form);
                        form.submit();
                    }
                });
            });
        });

        // Edit client modal
        document.addEventListener('DOMContentLoaded', function () {
            const editButtons = document.querySelectorAll('.edit');

            editButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const clientId = this.getAttribute('data-client-id');
                    const firstName = this.getAttribute('data-first-name');
                    const lastName = this.getAttribute('data-last-name');
                    const contactNumber = this.getAttribute('data-contact-number');
                    const location = this.getAttribute('data-location');
                    const weddingDate = this.getAttribute('data-wedding-date');

                    document.getElementById('editClientId').value = clientId;
                    document.getElementById('editFirstName').value = firstName;
                    document.getElementById('editLastName').value = lastName;
                    document.getElementById('editContactNumber').value = contactNumber;
                    document.getElementById('editLocation').value = location;
                    document.getElementById('editWeddingDate').value = weddingDate;

                    // Display the modal
                    document.getElementById('editModal').style.display = 'block';
                });
            });

            // Close modal when the close button is clicked
            document.querySelector('.close').addEventListener('click', function () {
                document.getElementById('editModal').style.display = 'none';
            });

            // Validate form fields if needed
            const editForm = document.getElementById('editForm');
            editForm.addEventListener('submit', function (event) {
                // Add custom validation here if needed
            });
        });
        </script>
    </body>
</html>