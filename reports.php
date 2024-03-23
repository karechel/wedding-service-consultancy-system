<?php
include 'connection.php';
$pdo = new PDO($dsn, $user, $password);

$statement1 = $pdo->query('SELECT COUNT(*) FROM clients');
$clientsCount = $statement1->fetchColumn();

$statement2 = $pdo->query('SELECT COUNT(*) FROM vendors');
$vendorsCount = $statement2->fetchColumn();



// Return counts as JSON
echo json_encode(array(
    'clientsCount' => $clientsCount,
    'vendorsCount' => $vendorsCount,
    
));
?>