<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php

// Database connection parameters
$host = 'localhost';  // Replace with your PostgreSQL host
$port = '5433';  // Replace with your PostgreSQL port (usually 5432)
$dbname = 'Online_wedding_services';   // Replace with your PostgreSQL database name
$user = 'postgres';          // Replace with your PostgreSQL username
$password = 'root';      // Replace with your PostgreSQL password

// Connection string
$dsn = "pgsql:host=$host;port=$port;dbname=$dbname;user=$user;password=$password";

try {
    // Create a new PDO instance
    $pdo = new PDO($dsn);

    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Connection successful
  //  echo "Connected to the database successfully!";
} catch (PDOException $e) {
    // Connection failed, display error message
    echo "Connection failed: " . $e->getMessage();
}

?>
</body>
</html>
