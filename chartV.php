<?php
include 'connection.php'; // Include your database connection file
$pdo = new PDO($dsn, $user, $password); // Establish PDO connection

function fetchFinanceData($period) {
    global $pdo;

    switch ($period) {
        case 'monthly':
            $sql = "SELECT to_char(transaction_date, 'Mon') AS period_label, SUM(amount) AS total_amount
                    FROM transactions
                    WHERE EXTRACT(YEAR FROM transaction_date) = EXTRACT(YEAR FROM CURRENT_DATE)
                    GROUP BY EXTRACT(MONTH FROM transaction_date), to_char(transaction_date, 'Mon')
                    ORDER BY EXTRACT(MONTH FROM transaction_date)";
            break;
        
        case 'quarterly':
            $sql = "SELECT CONCAT('Q', EXTRACT(QUARTER FROM transaction_date)) AS period_label, SUM(amount) AS total_amount
                    FROM transactions
                    WHERE EXTRACT(YEAR FROM transaction_date) = EXTRACT(YEAR FROM CURRENT_DATE)
                    GROUP BY EXTRACT(QUARTER FROM transaction_date)
                    ORDER BY EXTRACT(QUARTER FROM transaction_date)";
            break;
        
        case 'yearly':
            $sql = "SELECT EXTRACT(YEAR FROM transaction_date) AS period_label, SUM(amount) AS total_amount
                    FROM transactions
                    GROUP BY EXTRACT(YEAR FROM transaction_date)
                    ORDER BY EXTRACT(YEAR FROM transaction_date)";
            break;
        
        default:
            return null;
    }

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Output JSON encoded data
    header('Content-Type: application/json');
    echo json_encode($data);
}

// Check if 'period' parameter is set and call fetchFinanceData
if (isset($_GET['period'])) {
    fetchFinanceData($_GET['period']);
}
?>
