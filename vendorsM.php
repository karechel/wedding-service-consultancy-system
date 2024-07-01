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
?><html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style3.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <title>Vendors</title>
    <style>
        body {
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
            cursor: pointer;
        }
        .navbar {
            padding-left: 70px;
            height: 4rem;
        }
        .navbar a {
            left: 87%;
            font-size: 1.3rem;
        }
        .navbar img {
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
    <!--sidebar--> 
    <input type="checkbox" id="toggle">
    <label class="side-toggle" for="toggle"><span><i class='bx bxs-dashboard'></i></span></label>
    <div class="sidebar">
        <div class="user-image">
            <img class="profile-image" src="Images/pp1.jpeg" alt="">
            <p class="role">Manager</p>
        </div>
        <div class="sidebar-menu">
            <span class="bx bx-sidebar dash"></span><p class="dash"><a href="managerDash.php">Dashboard</a></p>
        </div>
        <div class="sidebar-menu">
            <span class="bx bx-bookmark-heart"></span><p><a href="bookingsM.php">Bookings</a></p>
        </div>
        <div class="sidebar-menu">
            <span class="bx bx-user"></span><p><a href="vendorsM.php">Vendors</a></p>
        </div>
        <div class="sidebar-menu">
            <span class="bx bx-user"></span><p><a href="ClientM.php">Clients</a></p>
        </div>
        <div class="sidebar-menu">
            <span class="bx bx-wallet-alt"></span><p><a href="finance.php">Finance</a></p>
        </div>
        <div class="sidebar-menu">
            <span class='bx bx-objects-horizontal-left'></span><p>Reports</p>
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
                    <thead>
                        <tr>
                            <th>Vendor #</th>
                            <th>Vendor</th>
                            <th>Service</th>
                            <th>Location</th>
                            <th>Pricing</th>
                            <th>Rating</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($rows as $row): ?>
                        <tr data-vendor-id="<?php echo $row['vendor_id']; ?>">
                            <td><?php echo $row['vendor_id']; ?></td>
                            <td><?php echo $row['vendor_name']; ?></td>
                            <td><?php echo $row['service_name']; ?></td>
                            <td><?php echo $row['location']; ?></td>
                            <td><?php echo $row['price']; ?></td>
                            <td><?php echo $row['rating']; ?></td>
                            <td>
                                <i class="material-symbols-outlined">visibility</i>
                                <span class="material-symbols-outlined edit">edit</span>
                                <span class="material-symbols-outlined delete">delete</span>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <!-- Edit Popup Modal -->
                <div id="editModal" class="modal">
                    <div class="modal-content">
                        <span class="close">&times;</span>
                        <h2>Edit Vendor</h2>
                        <form id="editForm">
                            <input type="hidden" id="editVendorId" name="vendor_id">
                            <label for="editVendorName">Vendor Name:</label>
                            <input type="text" id="editVendorName" name="vendor_name" required>
                            <label for="editServiceName">Service Name:</label>
                            <input type="text" id="editServiceName" name="service_name" required>
                            <label for="editLocation">Location:</label>
                            <input type="text" id="editLocation" name="location" required>
                            <label for="editPrice">Price:</label>
                            <input type="text" id="editPrice" name="price" required>
                            <label for="editRating">Rating:</label>
                            <input type="text" id="editRating" name="rating" required>
                            <button type="submit">Save Changes</button>
                        </form>
                    </div>
                </div>
                <footer>
                    <span>showing 1 of 10 of 50 entries</span>
                    <div class="pagination">
                        <button>prev</button>
                        <button class="active">1</button>
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
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const modal = document.getElementById("editModal");
            const span = document.getElementsByClassName("close")[0];

            document.querySelectorAll('.delete').forEach(button => {
                button.addEventListener('click', function () {
                    const vendorId = this.closest('tr').dataset.vendorId;

                    if (confirm('Are you sure you want to delete this vendor?')) {
                        fetch('delete_vendor.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({ vendor_id: vendorId })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.status === 'success') {
                                this.closest('tr').remove(); // Remove the deleted row from the DOM
                            } else {
                                alert('Error deleting vendor: ' + data.message);
                            }
                        })
                        .catch(error => console.error('Error:', error));
                    }
                });
            });

            document.querySelectorAll('.edit').forEach(button => {
                button.addEventListener('click', function () {
                    const vendorId = this.closest('tr').dataset.vendorId;
                    const vendorName = this.closest('tr').querySelector('td:nth-child(2)').innerText;
                    const serviceName = this.closest('tr').querySelector('td:nth-child(3)').innerText;
                    const location = this.closest('tr').querySelector('td:nth-child(4)').innerText;
                    const price = this.closest('tr').querySelector('td:nth-child(5)').innerText;
                    const rating = this.closest('tr').querySelector('td:nth-child(6)').innerText;
                  

                    document.getElementById('editVendorId').value = vendorId;
                    document.getElementById('editVendorName').value = vendorName;
                    document.getElementById('editServiceName').value = serviceName;
                    document.getElementById('editLocation').value = location;
                    document.getElementById('editPrice').value = price;
                    document.getElementById('editRating').value = rating;
                  

                    modal.style.display = "block";
                });
            });

            span.onclick = function() {
                modal.style.display = "none";
            }

            window.onclick = function(event) {
                if (event.target == modal) {
                    modal.style.display = "none";
                }
            }

            document.getElementById('editForm').addEventListener('submit', function (event) {
                event.preventDefault();

                const formData = new FormData(this);

                fetch('update_vendor.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        const vendorId = formData.get('vendor_id');
                        const vendorName = formData.get('vendor_name');
                        const serviceName = formData.get('service_name');
                        const location = formData.get('location');
                        const price = formData.get('price');
                        const rating = formData.get('rating');
                       

                        const row = document.querySelector(`tr[data-vendor-id='${vendorId}']`);
                        row.querySelector('td:nth-child(2)').innerText = vendorName;
                        row.querySelector('td:nth-child(3)').innerText = serviceName;
                        row.querySelector('td:nth-child(4)').innerText = location;
                        row.querySelector('td:nth-child(5)').innerText = price;
                        row.querySelector('td:nth-child(6)').innerText = rating;
                      

                        modal.style.display = "none";
                    } else {
                        alert('Error updating vendor: ' + data.message);
                    }
                })
                .catch(error => console.error('Error:', error));
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

    </script>
</body>
</html>