<?php 
session_start();
if (isset($_SESSION['user_id'])) {
    include '../../connection.php';
    $outgoing_id = $_SESSION['user_id'];
    $incoming_id = $_POST['incoming_id'];
    $output = "";

    try {
        $sql = "SELECT * FROM messages 
                LEFT JOIN users ON users.user_id = messages.outgoing_msg_id
                WHERE (outgoing_msg_id = :outgoing_id AND incoming_msg_id = :incoming_id)
                OR (outgoing_msg_id = :incoming_id AND incoming_msg_id = :outgoing_id) 
                ORDER BY msg_id";
                
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':outgoing_id', $outgoing_id, PDO::PARAM_INT);
        $stmt->bindParam(':incoming_id', $incoming_id, PDO::PARAM_INT);
        $stmt->execute();

        $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (count($messages) > 0) {
            foreach ($messages as $row) {
                if ($row['outgoing_msg_id'] === $outgoing_id) {
                    $output .= '<div class="chat outgoing">
                                <div class="details">
                                    <p>'. htmlspecialchars($row['msg']) .'</p>
                                </div>
                                </div>';
                } else {
                    $imgTag = isset($row['img']) ? '<img src="php/images/'. htmlspecialchars($row['img']) .'" alt="">' : '';
                    $output .= '<div class="chat incoming">
                                '. $imgTag .'
                                <div class="details">
                                    <p>'. htmlspecialchars($row['msg']) .'</p>
                                </div>
                                </div>';
                }
            }
        } else {
            $output .= '<div class="text">No messages are available. Once you send a message they will appear here.</div>';
        }

        echo $output;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

} else {
    header("Location: ../../index.html");
    exit();
}
?>
