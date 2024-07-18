<?php
session_start();
include '../../connection.php';

$outgoing_id = $_SESSION['user_id'];
$searchTerm = $_POST['searchTerm'];

try {
    $sql = "SELECT * FROM users 
            LEFT JOIN vendors ON users.user_id = vendors.user_id
            LEFT JOIN clients ON users.user_id = clients.user_id
            WHERE users.user_id != :outgoing_id 
              AND (users.username ILIKE :searchTerm 
                   OR (users.role = 'Vendor' AND vendors.vendor_name ILIKE :searchTerm) 
                   OR (users.role = 'Client' AND (clients.first_name ILIKE :searchTerm OR clients.last_name ILIKE :searchTerm)))";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':outgoing_id', $outgoing_id, PDO::PARAM_INT);
    $searchTerm = "%$searchTerm%";
    $stmt->bindParam(':searchTerm', $searchTerm, PDO::PARAM_STR);
    $stmt->execute();

    $output = "";
    if ($stmt->rowCount() > 0) {
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            // Determine the displayed name based on role
            if ($row['role'] === 'Vendor') {
                $name = htmlspecialchars($row['vendor_name']);
            } elseif ($row['role'] === 'Client') {
                $name = htmlspecialchars($row['first_name'] . " " . $row['last_name']);
            } else {
                $name = htmlspecialchars($row['username']);
            }

            // Build HTML output for each user
            $output .= '<div class="user">
                            <div class="details">
                                <span>'. $name .'</span>
                                <p>'. htmlspecialchars($row['status']) .'</p>
                            </div>
                            <button class="start-chat" data-userid="'. $row['user_id'] .'">Start Chat</button>
                        </div>';
        }
    } else {
        $output .= 'No user found related to your search term';
    }
    echo $output;
} catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
}
?>
