<?php
session_start(); // Start the session if not already started
include 'connection.php'; // Include your database connection file

// Establish PDO connection
$pdo = new PDO($dsn, $user, $password);

try {
    // Check if user is logged in and get user_id from session or wherever it's stored
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id']; // Assuming user_id is stored in session
    } else {
        // Handle case where user is not logged in
        throw new Exception("User not logged in.");
    }

    // Query to fetch vendor_id based on user_id
    $stmtVendor = $pdo->prepare("SELECT vendor_id FROM vendors WHERE user_id = :user_id");
    $stmtVendor->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmtVendor->execute();
    $vendor_id = $stmtVendor->fetchColumn();

    // Prepare SQL statements to fetch vendor-related data
    $stmtPaid = $pdo->prepare("SELECT COUNT(*) AS paid_bookings_count FROM bookings WHERE vendor_id = :vendor_id AND payment_status = 'Paid'");
    $stmtPaid->bindParam(':vendor_id', $vendor_id, PDO::PARAM_INT);
    $stmtPaid->execute();
    $paidBookingsCount = $stmtPaid->fetchColumn();

    $stmtUnpaid = $pdo->prepare("SELECT COUNT(*) AS unpaid_bookings_count FROM bookings WHERE vendor_id = :vendor_id AND payment_status = 'Unpaid'");
    $stmtUnpaid->bindParam(':vendor_id', $vendor_id, PDO::PARAM_INT);
    $stmtUnpaid->execute();
    $unpaidBookingsCount = $stmtUnpaid->fetchColumn();

    $stmtGrossRevenue = $pdo->prepare("SELECT SUM(amount) AS gross_revenue FROM transactions WHERE vendor_id = :vendor_id");
    $stmtGrossRevenue->bindParam(':vendor_id', $vendor_id, PDO::PARAM_INT);
    $stmtGrossRevenue->execute();
    $grossRevenue = $stmtGrossRevenue->fetchColumn();

    $stmtCompleted = $pdo->prepare("SELECT COUNT(*) AS completed_transactions_count FROM transactions WHERE vendor_id = :vendor_id AND status = 'Completed'");
    $stmtCompleted->bindParam(':vendor_id', $vendor_id, PDO::PARAM_INT);
    $stmtCompleted->execute();
    $completedTransactionsCount = $stmtCompleted->fetchColumn();

    $stmtRefunded = $pdo->prepare("SELECT COUNT(*) AS refunded_transactions_count FROM transactions WHERE vendor_id = :vendor_id AND status = 'Refunded'");
    $stmtRefunded->bindParam(':vendor_id', $vendor_id, PDO::PARAM_INT);
    $stmtRefunded->execute();
    $refundedTransactionsCount = $stmtRefunded->fetchColumn();

    $stmtTransactions = $pdo->prepare("SELECT t.transaction_date, t.booking_id, c.first_name, c.last_name, s.service_name, t.amount, t.status
                                       FROM transactions t
                                       JOIN clients c ON t.client_id = c.client_id
                                       JOIN services s ON t.service_id = s.service_id
                                       WHERE t.vendor_id = :vendor_id");
    $stmtTransactions->bindParam(':vendor_id', $vendor_id, PDO::PARAM_INT);
    $stmtTransactions->execute();
    $transactions = $stmtTransactions->fetchAll(PDO::FETCH_ASSOC);


    // Query to fetch vendor_id based on user_id
    $stmtVendor = $pdo->prepare("SELECT vendor_id FROM vendors WHERE user_id = :user_id");
    $stmtVendor->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmtVendor->execute();
    $vendor_id = $stmtVendor->fetchColumn();

    // Prepare SQL statements to fetch vendor-related data
    $stmtPaid = $pdo->prepare("SELECT COUNT(*) AS paid_bookings_count FROM bookings WHERE vendor_id = :vendor_id AND payment_status = 'Paid'");
    $stmtPaid->bindParam(':vendor_id', $vendor_id, PDO::PARAM_INT);
    $stmtPaid->execute();
    $paidBookingsCount = $stmtPaid->fetchColumn();

    $stmtUnpaid = $pdo->prepare("SELECT COUNT(*) AS unpaid_bookings_count FROM bookings WHERE vendor_id = :vendor_id AND payment_status = 'Unpaid'");
    $stmtUnpaid->bindParam(':vendor_id', $vendor_id, PDO::PARAM_INT);
    $stmtUnpaid->execute();
    $unpaidBookingsCount = $stmtUnpaid->fetchColumn();

    $stmtGrossRevenue = $pdo->prepare("SELECT SUM(amount) AS gross_revenue FROM transactions WHERE vendor_id = :vendor_id");
    $stmtGrossRevenue->bindParam(':vendor_id', $vendor_id, PDO::PARAM_INT);
    $stmtGrossRevenue->execute();
    $grossRevenue = $stmtGrossRevenue->fetchColumn();

    $stmtCompleted = $pdo->prepare("SELECT COUNT(*) AS completed_transactions_count FROM transactions WHERE vendor_id = :vendor_id AND status = 'Completed'");
    $stmtCompleted->bindParam(':vendor_id', $vendor_id, PDO::PARAM_INT);
    $stmtCompleted->execute();
    $completedTransactionsCount = $stmtCompleted->fetchColumn();

    $stmtRefunded = $pdo->prepare("SELECT COUNT(*) AS refunded_transactions_count FROM transactions WHERE vendor_id = :vendor_id AND status = 'Refunded'");
    $stmtRefunded->bindParam(':vendor_id', $vendor_id, PDO::PARAM_INT);
    $stmtRefunded->execute();
    $refundedTransactionsCount = $stmtRefunded->fetchColumn();

    $stmtTransactions = $pdo->prepare("SELECT t.transaction_date, t.booking_id, c.first_name, c.last_name, s.service_name, t.amount, t.status
                                       FROM transactions t
                                       JOIN clients c ON t.client_id = c.client_id
                                       JOIN services s ON t.service_id = s.service_id
                                       WHERE t.vendor_id = :vendor_id");
    $stmtTransactions->bindParam(':vendor_id', $vendor_id, PDO::PARAM_INT);
    $stmtTransactions->execute();
    $transactions = $stmtTransactions->fetchAll(PDO::FETCH_ASSOC);

    $labels = [];
    $data = [];
    
    $filter = isset($_GET['filter']) ? $_GET['filter'] : 'monthly'; // Default to 'monthly' if not provided
    
    switch ($filter) {
        case 'monthly':
            // Monthly data query
            $stmtChart = $pdo->prepare("SELECT TO_CHAR(transaction_date, 'Mon') AS month, SUM(amount) AS total_amount
                FROM transactions
                WHERE vendor_id = :vendor_id AND status = 'Completed'
                AND EXTRACT(YEAR FROM transaction_date) = EXTRACT(YEAR FROM CURRENT_DATE)
                AND EXTRACT(MONTH FROM transaction_date) <= EXTRACT(MONTH FROM CURRENT_DATE)
                GROUP BY TO_CHAR(transaction_date, 'Mon')
                ORDER BY MIN(transaction_date)");
        
            $stmtChart->bindParam(':vendor_id', $vendor_id, PDO::PARAM_INT);
            $stmtChart->execute();
        
            $labels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
            break;
        
        
        case 'quarterly':
            $stmtChart = $pdo->prepare("SELECT
                CASE
                    WHEN EXTRACT(MONTH FROM transaction_date) IN (1, 2, 3) THEN 'Q1'
                    WHEN EXTRACT(MONTH FROM transaction_date) IN (4, 5, 6) THEN 'Q2'
                    WHEN EXTRACT(MONTH FROM transaction_date) IN (7, 8, 9) THEN 'Q3'
                    WHEN EXTRACT(MONTH FROM transaction_date) IN (10, 11, 12) THEN 'Q4'
                END AS quarter,
                SUM(amount) AS total_amount
                FROM transactions
                WHERE vendor_id = :vendor_id AND status = 'Completed'
                AND EXTRACT(YEAR FROM transaction_date) = EXTRACT(YEAR FROM CURRENT_DATE)
                GROUP BY CASE
                    WHEN EXTRACT(MONTH FROM transaction_date) IN (1, 2, 3) THEN 'Q1'
                    WHEN EXTRACT(MONTH FROM transaction_date) IN (4, 5, 6) THEN 'Q2'
                    WHEN EXTRACT(MONTH FROM transaction_date) IN (7, 8, 9) THEN 'Q3'
                    WHEN EXTRACT(MONTH FROM transaction_date) IN (10, 11, 12) THEN 'Q4'
                END
                ORDER BY quarter");
    
            $stmtChart->bindParam(':vendor_id', $vendor_id, PDO::PARAM_INT);
            $stmtChart->execute();
    
            $labels = ['Q1', 'Q2', 'Q3', 'Q4'];
            break;
    
        case 'yearly':
            $stmtChart = $pdo->prepare("SELECT EXTRACT(YEAR FROM transaction_date) AS year, SUM(amount) AS total_amount
                FROM transactions
                WHERE vendor_id = :vendor_id AND status = 'Completed'
                AND EXTRACT(YEAR FROM transaction_date) BETWEEN 2020 AND 2024
                GROUP BY EXTRACT(YEAR FROM transaction_date)
                ORDER BY EXTRACT(YEAR FROM transaction_date)");
    
            $stmtChart->bindParam(':vendor_id', $vendor_id, PDO::PARAM_INT);
            $stmtChart->execute();
    
            $labels = ['2020', '2021', '2022', '2023', '2024'];
            break;
    
        default:
            throw new Exception("Invalid filter.");
    }
    
    
    
    while ($row = $stmtChart->fetch(PDO::FETCH_ASSOC)) {
        if ($filter === 'monthly') {
            $index = array_search($row['month'], $labels); // Find index of month label
        } elseif ($filter === 'quarterly') {
            $index = array_search($row['quarter'], $labels); // Find index of quarterly label
        } elseif ($filter === 'yearly') {
            $index = array_search($row['year'], $labels); // Find index of yearly label
        }
    
        if ($index !== false) {
            $data[$index] = (float) $row['total_amount'];
        }
    }
    
    // Response for chart data
    $response = [
        'data' => $data
    ];
    
     json_encode($response);

    } catch (PDOException $e) {
    // Handle database errors gracefully
    echo json_encode(['error' => 'Database Error: ' . $e->getMessage()]);
} catch (Exception $e) {
    // Handle other errors such as user not logged in or invalid filter
    echo json_encode(['error' => $e->getMessage()]);
}
?>



<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Website with Login and Registration Form</title>
        <link rel="stylesheet" href="style3.css">
        <link rel="stylesheet" href="finance.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
      
        
    </head>
    <body>
    <?php include 'resuableComponents\vendorHeader.php' ?>
            <div class="container">
            <!-- <h1 class="page-title">My Dashboard</h1> -->
            <div class="container-content">
    
            <?php
           include 'vendor_menu.php';
           ?>


        

        <div class="main-content">

            <div class="dashboard-container">
                <!-- cards -->
                <div class="card total1">
                    <div class="info">
                      <div class="info-detail">
                      <i class='bx bx-dots-vertical-rounded' onclick="toggleOptions(event)"></i>
                <div class="options">
                    <a href="#">Yesterday</a>
                    <a href="#">2 days ago</a>
                    <a href="#">3 days ago</a>
                </div>
                      <h2>Ksh. <?php echo $grossRevenue; ?> </h2>
                        <h3>Gross Revenue</h3>
                      </div>

                    </div>
                </div>
                <div class="card total2">
                    <div class="info">
                        <div class="info-detail">
                        <i class='bx bx-dots-vertical-rounded' onclick="toggleOptions(event)"></i>
                <div class="options">
                    <a href="#">Yesterday</a>
                    <a href="#">2 days ago</a>
                    <a href="#">3 days ago</a>
                </div>
                        <h2><?php echo $refundedTransactionsCount; ?> </h2>
                          <h3>Refunded Payments</h3>
                        </div>

                      </div>
                </div>
                <div class="card total3">
                    <div class="info">
                        <div class="info-detail">
                        <i class='bx bx-dots-vertical-rounded' onclick="toggleOptions(event)"></i>
                <div class="options">
                    <a href="#">Yesterday</a>
                    <a href="#">2 days ago</a>
                    <a href="#">3 days ago</a>
                </div>
                        <h2><?php echo $completedTransactionsCount; ?> </h2>
                          <h3>Completed Payments</h3>
                        </div>

                      </div>
                </div>
                
 
                <!-- card bottom -->

            </div>
        <!-- </main> -->

                <div class="dashboard-block">
                <div class="bookings-summary">
                    <!-- start of summary section -->
                    <div class="summaries">
                    <div class="general-summaries">
            <div class="finance-summaries">
            <div id="lineGraphContainerRevenue">
        <h1>Total Revenue </h1>
        <div class="chart-container">
        <div class="button-container">
            <button id="monthlyButtonRevenue" class="filter-button" onclick="filterLineGraphDataRevenue('monthly')">Monthly</button>
            <button id="quarterlyButtonRevenue" class="filter-button" onclick="filterLineGraphDataRevenue('quarterly')">Quarterly</button>
            <button id="yearlyButtonRevenue" class="filter-button" onclick="filterLineGraphDataRevenue('yearly')">Yearly</button>
        </div>
        <canvas id="lineChartRevenue" width="500" height="500"></canvas>
    </div>

    </div>
    </div>
    </div>
                        <!-- start of overview -->
                        <div class="overview">
                        <div class="card total1">
    <div class="info">
        <div class="info-detail">
            <h2><?php echo $paidBookingsCount; ?></h2>
            <h3>Paid Bookings</h3>
        </div>
    </div>
</div>

<div class="card total2">
    <div class="info">
    <div class="info-detail">
            <h2><?php echo $unpaidBookingsCount; ?></h2>
            <h3>Unpaid Bookings</h3>
        </div>
    </div>
</div>
                    
                        </div>
                    </div>
                    <!-- end of booking details summaries -->

                 </div>

                <div class="card detail">
                <h2>Transaction History</h2>
        <div class="transaction-header">
            <div class="filterEntries">
                <div class="finance-button-container">
                    <button id="AllStatus" class="filter-button">All</button>
                    <button id="completedStatus" class="filter-button">Completed</button>
                    <button id="refundedStatus" class="filter-button">Refunded</button>
                </div>
                      </div>
        <table id="transactionsTable">
                         <thead>
                        <tr>                      
                            <th>Date</th>
                            <th>Booking ID</th>
                            <th>Client Name</th>
                            <th>Service</th>
                            <th>Amount</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($transactions as $transaction): ?>
                        <tr data-status="<?php echo $transaction['status']; ?>">
                            <td><?php echo $transaction['transaction_date']; ?></td>
                            <td><?php echo $transaction['booking_id']; ?></td>
                            <td><?php echo $transaction['first_name'] . ' ' . $transaction['last_name']; ?></td>
                            <td><?php echo $transaction['service_name']; ?></td>
                            <td><?php echo $transaction['amount']; ?></td>
                            <td><?php echo $transaction['status']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
</table>
</div>            

            </div>
        </div>

        </div>
    </div>
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
   <!--scripts-->
   <!--apexCharts-->
   <script src="filterTransactions.js"></script>
   <script src="script2.js"></script>
   <script src="script3.js"></script>
   <!-- <script src="chartV.js"></script> -->
 </body>
</html>
