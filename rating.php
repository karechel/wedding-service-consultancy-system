<?php
include 'connection.php'; // Ensure connection to the database
include 'login.php'; // Assuming this handles session_start() and authentication

$rows = [];
try {
    // Check if the user is logged in and get their user_id
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];

        // SQL query to select client_id from clients table based on user_id
        $sql = "SELECT client_id FROM clients WHERE user_id = :user_id";

        // Prepare and execute query
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();

        // Fetch the client_id
        $rows = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Check if client_id is found
        if (!$rows) {
            echo "Client ID not found for this user.";
            exit; // Handle this case accordingly
        }
    } else {
        // Handle case where user is not logged in
        echo "You must be logged in to view this page.";
        exit; // or redirect to login page
    }

} catch (PDOException $e) {
    // Handle database errors gracefully
    echo "Error: " . $e->getMessage();
    exit; // or redirect to an error page
}



// Check if booking_id and vendor_id are provided in the URL
if (isset($_GET['booking_id'], $_GET['vendor_id'])) {
    $booking_id = $_GET['booking_id'];
    $vendor_id = $_GET['vendor_id'];
} else {
    // Handle case where parameters are missing
    echo "Booking ID or Vendor ID not provided.";
    exit; // or redirect to another page
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="style.css">
	<link rel="stylesheet" href="style3.css">
	<title>Form Reviews</title>
</head>
<body>
<?php include 'resuableComponents\clientHeader.php'; ?>
	<div class="rating-background">
<div class="review">

	<div class="wrapper">
		<h3>Give Feedback</h3>
		<form action="submitrating.php" method="POST">
		<input type="hidden" name="booking_id" value="<?php echo htmlspecialchars($booking_id); ?>">
        <input type="hidden" name="vendor_id" value="<?php echo htmlspecialchars($vendor_id); ?>">
		<input type="hidden" name="client_id" value="<?= $rows['client_id']; ?>">
			<div class="rating">
				<input type="text" name="rating" hidden>
				<i class='bx bx-star star' style="--i: 0;"></i>
				<i class='bx bx-star star' style="--i: 1;"></i>
				<i class='bx bx-star star' style="--i: 2;"></i>
				<i class='bx bx-star star' style="--i: 3;"></i>
				<i class='bx bx-star star' style="--i: 4;"></i>
			</div>
            <span>Do you have any thought you would like to share?</span>
			<textarea name="comment" cols="30" rows="5" placeholder="Your opinion..."></textarea>
			<div class="btn-group">
				<button type="submit" class="btn submit">Submit</button>
				<button class="btn cancel">Cancel</button>
			</div>
		</form>
	</div>
</div>
  <script src="review.js"></script>
  </div>
</body>
</html>