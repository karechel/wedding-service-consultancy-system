<?php
// include 'connection.php';
// // Connect to your database (assuming you have a database connection established)

// // Retrieve the option from the GET parameters
// $option = isset($_GET['option']) ? $_GET['option'] : '';

// // Query the database based on the selected option
// // Example:
// $query = "SELECT * FROM users WHERE role = '$option'";
// $stmt = $pdo->prepare($query);
// // Execute the query and fetch the filtered content
// $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

// // For demonstration, let's assume we have some sample data
// $filteredContent = "Filtered content for $option"; // Replace this with your actual fetched data

// // Return the filtered content
// echo $filteredContent;

require 'connection.php'; // Ensure this file is in the same directory or adjust the path accordingly

// Retrieve the option from the GET parameters
$option = isset($_GET['option']) ? intval($_GET['option']) : 0;

// Define the date range based on the selected option
$dateRange = [
    0 => '0 days',
    1 => '1 day',
    2 => '2 days',
    3 => '3 days',   
];

// Calculate the date based on the selected option
$date = date('Y-m-d', strtotime("-{$dateRange[$option]}"));

// try {
//     // Query to count users registered on the specific date
//     $query = "SELECT COUNT(*) as user_count FROM users WHERE DATE(registration_date) = :date";
//     $stmt = $pdo->prepare($query);
//     $stmt->execute(['date' => $date]);
//     $result = $stmt->fetch(PDO::FETCH_ASSOC);
//     $userCount = $result['user_count'];

//     // Query to count total users up to the specific date
//     $totalCountQuery = "SELECT COUNT(*) as users_count FROM users WHERE DATE(registration_date) <= :date";
//     $stmt = $pdo->prepare($totalCountQuery);
//     $stmt->execute(['date' => $date]);
//     $totalResult = $stmt->fetch(PDO::FETCH_ASSOC);
//     $usersCount = $totalResult['users_count'];

//     // Return the counts as a JSON response
//     // echo json_encode(['user_count' => $userCount, 'users_count' => $usersCount]);
//     echo $userCount . ' ' . $usersCount;
// } catch (PDOException $e) {
//     // Return error message if query fails
//     echo json_encode(['error' => $e->getMessage()]);
// }
try {
    // Query the database based on the selected option
    $query = "SELECT COUNT(*) as user_count FROM users WHERE registration_date = :date";
    $totalCountQuery = "SELECT COUNT(*) as users_count FROM users WHERE registration_date <= :date";
    
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
