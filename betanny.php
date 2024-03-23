<?php
$host = "localhost";
$port = "5432";
$dbname = "MyBookstore";
$user = "postgres";
$password = "#Wa1r1mu";

try {
    $dsn = "pgsql:host=$host;port=$port;dbname=$dbname;user=$user;password=$password";
    $db_connection = new PDO($dsn);

    // Set PDO to throw exceptions for errors
    $db_connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Extract data from the registration form
    $userType = isset($_POST['userType']) ? $_POST['userType'] : $_POST['userType1'];
    $firstName = isset($_POST['firstName']) ? $_POST['firstName'] : null;
    $lastName = isset($_POST['lastName']) ? $_POST['lastName'] : null;
    $companyName = isset($_POST['companyName']) ? $_POST['companyName'] : null;
    $email = isset($_POST['email']) ? $_POST['email'] : null;
    $password = isset($_POST['password']) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : null;

    // Insert data into the 'users' table
    $insertUserStmt = $db_connection->prepare("INSERT INTO users (email, password) VALUES (?, ?)");
    $insertUserStmt->execute([$email, $password]);

    // Get the user_id of the inserted user
    echo $db_connection->lastInsertId();
    $user_id = 'us000' . $db_connection->lastInsertId();

    if ($userType == "School") {
        $insertClientStmt = $db_connection->prepare("INSERT INTO clients (user_id, client_type, email, first_name, last_name) VALUES (?, ?, ?, ?, ?)");
        $insertClientStmt->execute([$user_id, $userType, $email, $firstName, $lastName]);
    }
    // } elseif ($userType == "Author") {
    //     // Additional logic for Author type if needed
    // } elseif (in_array($userType, ["School", "Manufacturer", "Publisher"])) {
    //     $insertClientStmt = $db_connection->prepare("INSERT INTO clients (user_id, client_type, email, first_name, last_name) VALUES (?, ?, ?, ?)");
    //     $insertClientStmt->execute([$user_id, $email, $userType, $firstName, $lastName]);
    // }
    echo $userType;
    echo "Registration successful.";

    // Close the connection
    $db_connection = null;
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>