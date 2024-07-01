<?php
require 'connection.php'; // Ensure this file is in the same directory or adjust the path accordingly

// Retrieve the option and type from the GET parameters
$option = isset($_GET['option']) ? intval($_GET['option']) : 0;
$type = isset($_GET['type']) ? $_GET['type'] : 'clients';

// Define the date range based on the selected option
$dateRange = [
    0 => '0 days',
    1 => '1 day',
    2 => '2 days',
    3 => '3 days',   
];

// Calculate the date based on the selected option
$date = date('Y-m-d', strtotime("-{$dateRange[$option]}"));

try {
    // Initialize query variables
    $query = "";
    $totalCountQuery = "";

    // Set the queries based on the type
    if ($type === 'clients') {
        $query = "SELECT COUNT(*) as user_count FROM clients WHERE created_at::date = :date";
        $totalCountQuery = "SELECT COUNT(*) as users_count FROM clients WHERE created_at::date <= :date";
    } elseif ($type === 'vendors') {
        $query = "SELECT COUNT(*) as user_count FROM vendors WHERE created_at::date = :date";
        $totalCountQuery = "SELECT COUNT(*) as users_count FROM vendors WHERE created_at::date <= :date";
    } elseif ($type === 'bookings') {
        $query = "SELECT COUNT(*) as user_count FROM bookings WHERE created_at::date = :date";
        $totalCountQuery = "SELECT COUNT(*) as users_count FROM bookings WHERE created_at::date <= :date";
    }
 
    // Query the database based on the selected option and type
    $stmt = $pdo->prepare($query);
    $stmt->execute(['date' => $date]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $userCount = $result['user_count'];
    
    $stmt = $pdo->prepare($totalCountQuery);
    $stmt->execute(['date' => $date]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $usersCount = $result['users_count'];
    
    echo " $userCount $usersCount";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
