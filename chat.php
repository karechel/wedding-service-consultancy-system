<?php 
session_start();
require_once "connection.php"; // Assuming your PDO connection is established in connection.php

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("location: login.php");
    exit; // Ensure script stops execution after redirect
}

// Fetch user details based on session user_id
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM users WHERE user_id = :user_id";
$stmt = $pdo->prepare($sql);
$stmt->execute(['user_id' => $user_id]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

// Redirect to users.php if user not found
if (!$row) {
    header("location: users.php");
    exit; // Ensure script stops execution after redirect
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat with <?php echo htmlspecialchars($row['fname'] . " " . $row['lname']); ?></title>
    <link rel="stylesheet" href="styles.css"> <!-- Ensure your CSS file is linked here -->
</head>
<body>
    <div class="wrapper">
        <section class="chat-area">
            <header>
                <a href="users.php" class="back-icon"><i class="fas fa-arrow-left"></i></a>
                <img src="php/images/<?php echo htmlspecialchars($row['img']); ?>" alt="Profile Image">
                <div class="details">
                    <span><?php echo htmlspecialchars($row['fname']. " " . $row['lname']); ?></span>
                    <p><?php echo htmlspecialchars($row['status']); ?></p>
                </div>
            </header>
            <div class="chat-box">

            </div>
            <form action="#" class="typing-area">
                <input type="hidden" class="incoming_id" name="incoming_id" value="<?php echo htmlspecialchars($user_id); ?>">
                <input type="text" name="message" class="input-field" placeholder="Type a message here..." autocomplete="off">
                <button type="submit"><i class="fab fa-telegram-plane"></i></button>
            </form>
        </section>
    </div>

    <script src="chat.js"></script> <!-- Ensure your JavaScript file path is correct -->
</body>
</html>
