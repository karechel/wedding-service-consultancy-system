<?php

if (isset($_SESSION['user_id'])) {
    include '../../connection.php';
    $outgoing_id = $_SESSION['user_id'];
    $output = "";

    try {
        $stmt = $pdo->query("SELECT * FROM users");
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $user_id = $row['user_id'];
            $user_role = $row['role'];
            $name = "";

            // Fetch profile picture as bytea and encode it to base64
            $profile_pic = isset($row['profile_pic']) ? base64_encode(stream_get_contents($row['profile_pic'])) : '';

            // Determine the name based on the user's role
            if ($user_role === 'Vendor') {
                $stmt_vendor = $pdo->prepare("SELECT vendor_name FROM vendors WHERE user_id = :user_id");
                $stmt_vendor->bindParam(':user_id', $user_id, PDO::PARAM_INT);
                $stmt_vendor->execute();
                $vendor = $stmt_vendor->fetch(PDO::FETCH_ASSOC);
                if ($vendor) {
                    $name = htmlspecialchars($vendor['vendor_name']);
                } else {
                    $name = "Unknown Vendor";
                }
            } elseif ($user_role === 'Client') {
                $stmt_client = $pdo->prepare("SELECT first_name, last_name FROM clients WHERE user_id = :user_id");
                $stmt_client->bindParam(':user_id', $user_id, PDO::PARAM_INT);
                $stmt_client->execute();
                $client = $stmt_client->fetch(PDO::FETCH_ASSOC);
                if ($client) {
                    $name = htmlspecialchars($client['first_name'] . " " . $client['last_name']);
                } else {
                    $name = "Unknown Client";
                }
            }

            $sql2 = "SELECT * FROM messages 
                     WHERE (incoming_msg_id = :user_id OR outgoing_msg_id = :user_id)
                     AND (outgoing_msg_id = :outgoing_id OR incoming_msg_id = :outgoing_id)
                     ORDER BY msg_id DESC LIMIT 1";
            $stmt2 = $pdo->prepare($sql2);
            $stmt2->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt2->bindParam(':outgoing_id', $outgoing_id, PDO::PARAM_INT);
            $stmt2->execute();

            $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
            $result = $row2 ? $row2['msg'] : "No message available";
            $msg = (strlen($result) > 28) ? substr($result, 0, 28) . '...' : $result;

            $you = isset($row2['outgoing_msg_id']) && $outgoing_id == $row2['outgoing_msg_id'] ? "You: " : "";
            $offline = $row['status'] == "Offline now" ? "offline" : "";
            $hid_me = $outgoing_id == $user_id ? "hide" : "";

            $output .= '<a href="chat.php?user_id=' . $user_id . '">
                        <div class="content ' . $hid_me . '">
                        <img src="data:image/jpeg;base64,' . $profile_pic . '" alt="Profile Picture">
                        <div class="details">
                            <span>' . $name . '</span>
                            <p>' . htmlspecialchars($you . $msg) . '</p>
                        </div>
                        </div>
                        <div class="status-dot ' . $offline . '"><i class="fas fa-circle"></i></div>
                    </a>';
        }
        echo $output;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    header("Location:../../index.html");
    exit();
}
?>
