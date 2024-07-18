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

    if ($user) {
        if ($user['status'] == 'deleted') {
            echo "<script>alert('You deleted your account!!'); window.location.href='index.html';</script>";
            exit();
        } elseif ($user['status'] == 'suspended') {
            echo "<script>alert('Your account has been deleted or Suspended by the Manager.'); window.location.href='index.html';</script>";
            exit();
        } elseif ($user['password'] === $password) {
            $_SESSION['username'] = $username;
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['client_id'] = $user['client_id'];
            $_SESSION['role'] = $user['role'];

            header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
            header("Cache-Control: post-check=0, pre-check=0", false);
            header("Pragma: no-cache");

            switch ($user['role']) {
                case 'Client':
                    header("Location: client.php");
                    break;
                case 'Manager':
                    header("Location: managerDash.php");
                    break;
                case 'Vendor':
                    header("Location: vendorD.php");
                    break;
                default:
                    header("Location: welcome.php");
            }
            exit();
        } else {
            header("Location: index.html?error=1");
            exit();
        }
    } else {
        header("Location: index.html?error=1");
        exit();
    }
}
?>
