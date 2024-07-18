<?php
session_start();
require_once 'connection.php';

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $role = $_SESSION['role'];

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if ($role == 'Manager' && isset($_POST['suspend_user_id'])) {
            $suspend_user_id = $_POST['suspend_user_id'];

            try {
                // Start transaction
                $pdo->beginTransaction();

                // Update user status to 'suspended'
                $sql = "UPDATE users SET status = 'suspended' WHERE user_id = :suspend_user_id";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':suspend_user_id', $suspend_user_id, PDO::PARAM_INT);
                $stmt->execute();

                // Commit transaction
                $pdo->commit();

                // Redirect back to manager dashboard with success message
                header("Location: managerDash.php?status=suspended");
                exit();

            } catch (PDOException $e) {
                // Rollback transaction on error
                $pdo->rollBack();

                // Redirect with error message
                header("Location: managerDash.php?error=" . urlencode($e->getMessage()));
                exit();
            }
        }
    }
} else {
    // Redirect if session is not valid
    header("Location: index.html");
    exit();
}
?>
