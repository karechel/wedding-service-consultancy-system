<?php
include 'connection.php'; // Ensure connection to the database
include 'login.php';

$rows = [];
try {
    // Check if the user is logged in and get their user_id
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];

        // SQL query to select data from the tables filtered by the logged-in user
        $sql = "SELECT bookings.booking_id, clients.first_name, clients.last_name, vendors.vendor_name, services.service_name, bookings.booking_date, bookings.status, bookings.payment_status, bookings.event_date
                FROM bookings
                JOIN clients ON bookings.client_id = clients.client_id
                JOIN services ON bookings.service_id = services.service_id
                JOIN vendors ON bookings.vendor_id = vendors.vendor_id
                WHERE clients.user_id = :user_id";

        // Prepare and execute query
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();

        // Fetch all rows as associative array
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        // Handle case where user is not logged in
        // Redirect or handle as per your application's logic
    }

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
        <!-- <link rel="stylesheet" href="BookingsList.css"> -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2family=poppins&display=swap">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2family=poppins&display=swap">
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
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
            width: 100px;
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
    left: 73%;
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
        main{
            padding: 10rem 15rem 10rem 10rem;
        }
        .detail-header select{
    height: 30px;
    width: 120px;
    border: 1px solid #e3bdb5;
    background-color: #e3bdb5;
    color: #f2f2f2;
    border-radius: 5px;
    cursor: pointer;
    transition: all 0.2s ease-in;
}
.detail-header select:hover{
    background-color: transparent;
    color: #e3bdb5;

}
.detail table{
    width: 100%;
    border-collapse: collapse;

}
.detail table tr:nth-child(odd){
    background-color: #caa69e1a;

}
.detail table th{
    background-color: #caa69e1a;
}
main{
    padding: 90px 45px 0 45px;
}
.dashboard-container{
    display: flex;
    flex-direction: column;
    width: 100%;
}
.detail{
    width: 100%;
}
.detail table tr:hover{
    background-color: #f2f2f2;
    border-bottom: 2px solid #e3bdb5;
}
button:hover {
    background-color: #e3bdb5;
}
    </style>
    </head>
   
        <body>
  
    <?php include 'resuableComponents\clientHeader.php'; ?>
        
            <!--Maindashboard--> 
            <main>
            <div class="dashboard-container">
               
            <div class="card detail">
        <h2>My Bookings</h2>
        <div class="detail-header">
            <div class="filterEntries">
                <div class="button-container">
                    <button id="AllStatus" class="filter-button">All</button>
                    <button id="confirmedStatus" class="filter-button">Confirmed</button>
                    <button id="pendingStatus" class="filter-button">Pending</button>
                    <button id="completedStatus" class="filter-button">Completed</button>
                    <button id="cancelledStatus" class="filter-button">Cancelled</button>
                </div>
                <div class="filter">
                    <input type="search" name="" id="search" placeholder="Search bookings">
                </div>
            </div>
        </div>
        <table id="bookingsTable">
            <thead>
                <tr>
                    <th>Booking #</th>
                    <th>Booking Date</th>
                    <th>Event Date</th>
                    <th>Service Booked</th>
                    <th>Vendor</th>
                    <th>Booking status</th>
                    <th>Payment status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
        <?php foreach ($rows as $row): ?>
            <tr data-booking-id="<?php echo $row['booking_id']; ?>" data-status="<?php echo $row['status']; ?>">
                <td><?php echo $row['booking_id']; ?></td>
                <td><?php echo $row['booking_date']; ?></td>
                <td><?php echo $row['event_date']; ?></td>
                <td><?php echo $row['service_name']; ?></td>
                <td><?php echo $row['vendor_name']; ?></td>
                <td><?php echo $row['status']; ?></td>
                <td><span class="status fullfilled"><?php echo $row['payment_status']; ?></span></td>
                <td>
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
            <h2>Edit Booking</h2>
            <form id="editForm">
                <input type="hidden" id="editBookingId" name="booking_id">
                <label for="editStatus">Booking Status:</label>
                <input type="text" id="editStatus" name="status">
                <button type="submit">Save Changes</button>
            </form>
        </div>
    </div>
                   
                </div>
               
            </div>
        </main>
        <!-- <script>
            document.addEventListener('DOMContentLoaded', () => {
    const modal = document.getElementById("editModal");
    const span = document.getElementsByClassName("close")[0];

    document.querySelectorAll('.delete').forEach(button => {
        button.addEventListener('click', function () {
            const bookingId = this.closest('tr').dataset.bookingId;

            if (confirm('Are you sure you want to delete this booking?')) {
                fetch('delete_booking.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ booking_id: bookingId })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        this.closest('tr').remove(); // Remove the deleted row from the DOM
                    } else {
                        alert('Error deleting booking: ' + data.message);
                    }
                })
                .catch(error => console.error('Error:', error));
            }
        });
    });

    document.querySelectorAll('.edit').forEach(button => {
        button.addEventListener('click', function () {
            const bookingId = this.closest('tr').dataset.bookingId;
            const status = this.closest('tr').querySelector('td:nth-child(7)').innerText;
            const paymentStatus = this.closest('tr').querySelector('td:nth-child(8) .status').innerText;

            document.getElementById('editBookingId').value = bookingId;
            document.getElementById('editStatus').value = status;
            document.getElementById('editPaymentStatus').value = paymentStatus;

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

        fetch('update_booking.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                const bookingId = formData.get('booking_id');
                const status = formData.get('status');
                const paymentStatus = formData.get('payment_status');

                const row = document.querySelector(`tr[data-booking-id='${bookingId}']`);
                row.querySelector('td:nth-child(7)').innerText = status;
                row.querySelector('td:nth-child(8) .status').innerText = paymentStatus;

                modal.style.display = "none";
            } else {
                alert('Error updating booking: ' + data.message);
            }
        })
        .catch(error => console.error('Error:', error));
    });
});

     
    </script> -->
     <script src="editDelete.js"></script>
    <script src="resuableComponents\filterbookings.js"></script>
    </div>
    
</html>


