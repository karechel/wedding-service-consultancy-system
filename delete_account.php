// delete_account.php
<?php
session_start();
require_once 'connection.php';

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $role = $_SESSION['role'];

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['delete_self'])) {
            $status = 'deleted';
            $stmt = $pdo->prepare("UPDATE users SET status = :status WHERE user_id = :user_id");
            $stmt->bindParam(':status', $status);
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->execute();
            echo "<script>alert('You deleted your account!!'); window.location.href='index.html';</script>";
            session_destroy();
        } elseif ($role == 'Manager' && isset($_POST['suspend_user'])) {
            $suspend_user_id = $_POST['suspend_user_id'];
            $status = 'suspended';
            $stmt = $pdo->prepare("UPDATE users SET status = :status WHERE user_id = :user_id");
            $stmt->bindParam(':status', $status);
            $stmt->bindParam(':user_id', $suspend_user_id, PDO::PARAM_INT);
            $stmt->execute();
            echo "<script>alert('User account suspended successfully.'); window.location.href='managerDash.php';</script>";
        }
    }
} else {
    header("Location: index.html");
    exit();
}
?>
