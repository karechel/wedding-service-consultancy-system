<?php
session_start();
include '../../connection.php';

$outgoing_id = $_SESSION['user_id'];

try {
    $sql = "SELECT * FROM users WHERE user_id != :outgoing_id ORDER BY user_id DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':outgoing_id', $outgoing_id, PDO::PARAM_INT);
    $stmt->execute();

    $output = "";
    if ($stmt->rowCount() == 0) {
        $output .= "No users are available to chat";
    } else {
        include 'data.php';
    }
    echo $output;
} catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
}
?>
