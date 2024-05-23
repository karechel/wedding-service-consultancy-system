<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once 'connection.php';
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->bindParam(':username', $username);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && $user['password'] === $password) {
        // Authentication successful
        $_SESSION['username'] = $username;
        $_SESSION['user_id']=$user['user_id'];
        $_SESSION['client_id']=$user['client_id'];

        // Redirect based on user type
        switch ($user['role']) {
            case 'Client':
                header("Location: client.html");
                break;
            case 'Manager':
                header("Location: adminDash.php");
                break;
            case 'Vendor':
                header("Location: vendorDash.php");
                break;
            default:
                
                header("Location: welcome.php");
        }

        exit(); // Exit to prevent further output
    } else {
        // Authentication failed, redirect back to login page with error message
        header("Location: login.html?error=1");
        exit(); // Exit to prevent further output
    }
}
?>
