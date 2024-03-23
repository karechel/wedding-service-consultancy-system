<?php
session_start();

if($_SERVER["REQUEST_METHOD"]=="POST"){
        require_once'connection.php';
        $username = $_POST['username'];
        $password = $_POST['password'];

        $stmt = $pdo-> prepare("SELECT * FROM users WHERE username = :username");

        $stmt->bindParam(':username',$username);
        $stmt->execute();
        
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if ($user && $user['password'] === $password) {
            // Authentication successful, set session variable and return success JSON response
            $_SESSION['username'] = $username;
            header("Location: welcome.php");
            echo json_encode(['success' => true]);
           
            exit(); // Exit to prevent further output
        } else {
            // Authentication failed, return error JSON response
            echo json_encode(['success' => false, 'error' => 'Invalid username or password']);
            exit(); // Exit to prevent further output
        }
           
            

}
?>