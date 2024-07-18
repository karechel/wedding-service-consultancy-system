<?php 
session_start();
if (isset($_SESSION['user_id'])) {
    include '../../connection.php';
    $outgoing_id = $_SESSION['user_id'];
    $incoming_id = $_POST['incoming_id'];
    $message = $_POST['message'];
    
    if (!empty($message)) {
        try {
            $sql = "INSERT INTO messages (incoming_msg_id, outgoing_msg_id, msg)
                    VALUES (:incoming_id, :outgoing_id, :message)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':incoming_id', $incoming_id, PDO::PARAM_INT);
            $stmt->bindParam(':outgoing_id', $outgoing_id, PDO::PARAM_INT);
            $stmt->bindParam(':message', $message, PDO::PARAM_STR);
            $stmt->execute();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
} else {
    header("Location:index.html");
    exit();
}
?>
