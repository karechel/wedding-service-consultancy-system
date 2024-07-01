<?php
require 'connection.php'; // Ensure this file is in the same directory or adjust the path accordingly

// Retrieve the week from the GET parameters
$week = isset($_GET['week']) ? $_GET['week'] : 'thisWeek';

// Determine the date range based on the selected week
if ($week === 'thisWeek') {
    $startDate = date('Y-m-d', strtotime('monday this week'));
    $endDate = date('Y-m-d', strtotime('sunday this week'));
} elseif ($week === 'lastWeek') {
    $startDate = date('Y-m-d', strtotime('monday last week'));
    $endDate = date('Y-m-d', strtotime('sunday last week'));
}

try {
    // Initialize query variables
    $chartDataQuery = "SELECT status, COUNT(*) as count FROM bookings WHERE created_at::date BETWEEN :startDate AND :endDate GROUP BY status";
     $newBookingsQuery = "SELECT COUNT(*) as count FROM bookings WHERE created_at::date BETWEEN :startDate AND :endDate";
    $completedBookingsQuery = "SELECT COUNT(*) as eventcount FROM event_details WHERE created_at::date BETWEEN :startDate AND :endDate AND event_status = 'Completed'";

    // Fetch chart data
    $stmt = $pdo->prepare($chartDataQuery);
    $stmt->execute(['startDate' => $startDate, 'endDate' => $endDate]);
    $chartData = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Prepare chart data in a suitable format
    $formattedChartData = [];
    foreach ($chartData as $data) {
        $formattedChartData[$data['status']] = $data['count'];
    }

    // Fetch new bookings count
    $stmt = $pdo->prepare($newBookingsQuery);
    $stmt->execute(['startDate' => $startDate, 'endDate' => $endDate]);
    $newBookings = $stmt->fetch(PDO::FETCH_ASSOC)['count'];

    // Fetch completed bookings count
    $stmt = $pdo->prepare($completedBookingsQuery);
    $stmt->execute(['startDate' => $startDate, 'endDate' => $endDate]);
    $completedBookings = $stmt->fetch(PDO::FETCH_ASSOC)['eventcount'];

    // Prepare the response
    $response = [ $formattedChartData, $newBookings, $completedBookings];

    // Send the response as JSON
    echo json_encode($response);
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>
