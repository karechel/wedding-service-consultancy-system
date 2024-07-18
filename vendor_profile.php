<?php
include 'connection.php'; // Include your database connection file
// include 'login.php'; // Ensure user is logged in
session_start();


$clientData = [];
$userData = [];

try {
    // Check if the user is logged in and get their user_id
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];

        // Fetch client details
        $clientSql = "SELECT vendor_name, category, location, description
                      FROM vendors WHERE user_id = :user_id";
        $clientStmt = $pdo->prepare($clientSql);
        $clientStmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $clientStmt->execute();
        $clientData = $clientStmt->fetch(PDO::FETCH_ASSOC);

        // Fetch user details
        $userSql = "SELECT username, email, profile_pic FROM users WHERE user_id = :user_id";
        $userStmt = $pdo->prepare($userSql);
        $userStmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $userStmt->execute();
        $userData = $userStmt->fetch(PDO::FETCH_ASSOC);
        

        // Handle form submission
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $vendor_name = $_POST['vendor_name'];
            $category = $_POST['category'];
            $location = $_POST['location'];
            $description = $_POST['description'];
            $username = $_POST['username'];
            $email = $_POST['email'];

            // Handle profile picture upload
            if ($_FILES['profile_pic']['error'] === UPLOAD_ERR_OK) {
                // Read image data
                $imageData = file_get_contents($_FILES['profile_pic']['tmp_name']);

                // Update profile picture in database
                $updatePicSql = "UPDATE users SET profile_pic = :profile_pic WHERE user_id = :user_id";
                $updatePicStmt = $pdo->prepare($updatePicSql);
                $updatePicStmt->bindParam(':profile_pic', $imageData, PDO::PARAM_LOB);
                $updatePicStmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
                $updatePicStmt->execute();
            }

            // Update client details
            $updateClientSql = "UPDATE vendors SET vendor_name = :vendor_name, category = :category, location = :location, description = :description WHERE user_id = :user_id";
            $updateClientStmt = $pdo->prepare($updateClientSql);
            $updateClientStmt->bindParam(':vendor_name', $vendor_name);
            $updateClientStmt->bindParam(':category', $category);
            $updateClientStmt->bindParam(':location', $location);
            $updateClientStmt->bindParam(':description', $description);
            $updateClientStmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $updateClientStmt->execute();

            // Update user details
            $updateUserSql = "UPDATE users SET username = :username, email = :email WHERE user_id = :user_id";
            $updateUserStmt = $pdo->prepare($updateUserSql);
            $updateUserStmt->bindParam(':username', $username);
            $updateUserStmt->bindParam(':email', $email);
            $updateUserStmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $updateUserStmt->execute();

            // Reload the page to show updated data
            header("Location: vendor_profile.php");
            exit();
        }
    } else {
        // Handle case where user is not logged in
        header("Location: index.html");
        exit();
    }
   
} catch (PDOException $e) {
    // Handle errors gracefully
    echo "Error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #ededed7d;
        }
        .form-container {
            width: 50%;
            display: flex;
            margin: auto;
            flex-direction: column;
            align-items: center;
            padding: 20px;
            border-radius: 5px;
        }
        .form-container h2 {
            text-align: center;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            color: #994532;
        }
        .form-group input,
        .form-group textarea {
            width: 700px;
            padding: 8px;
            box-sizing: border-box;
            border: none;
            height: 50px;
        }
        .form-group img {
            max-width: 100px;
            display: block;
            margin-top: 10px;
        }
        .form-group button {
            display: block;
            width: 50%;
            padding: 10px;
            background-color: #e3bdb5;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-left: 135px;
        }
        .form-group button:hover {
            background-color: #000;
        }
        .profile-container {
            display: flex;
            justify-content: row;
        }
        .info-container img {
            width: 150px;
            margin-top: 30px;
            border-radius: 50%
        }
        .info-container {
            align-items: center;
            width: 20%;
            flex-direction: column;
            display: flex;
            background: #fff;
            box-shadow: 5px 10px #a29c9c14;
        }
        .info-container p{
            font-size: x-large;
            font-weight: 600;
        }
        .back-btn{
            display: block;
            width: 5%;
            font-size: 15px;
            padding: 10px;
            background-color: #e3bdb5;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin: 3px 0 35px 35px; 
        }
        .back-btn:hover{
            background-color: #000;
        }
    </style>
</head>
<body>


                    <button class="back-btn" type="button" onclick="goBack()"><i class='bx bx-arrow-back'></i> Back</button>
               
    <div class="profile-container">
        <div class="info-container">
        <?php
         if ($userData['profile_pic'] !== null) {
        $imageData = base64_encode(stream_get_contents($userData['profile_pic']));
        echo '<img class="main-image" src="data:image/jpeg;base64,' . $imageData . '" alt="Uploaded Image">';
         }
         else{
            echo '<img class="main-image" src="Images/profile2.svg" alt="Default Profile Picture">';
         }
        ?>

        <p><?php  echo htmlspecialchars($clientData['vendor_name']?? ''); ?></p>

        </div>
        <div class="form-container">
            <h2>Edit Profile</h2>
            <form action="client_profile.php" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="vendor_name">Name:</label>
                    <input type="text" id="vendor_name" name="vendor_name" value="<?php echo htmlspecialchars($clientData['vendor_name'] ?? ''); ?>" >
                </div>
                <div class="form-group">
                    <label for="category">Service:</label>
                    <input type="text" id="category" name="category" value="<?php echo htmlspecialchars($clientData['category'] ?? ''); ?>" >
                </div>
                <div class="form-group">
                    <label for="location">Location:</label>
                    <input type="text" id="location" name="location" value="<?php echo htmlspecialchars($clientData['location'] ?? ''); ?>">
                </div>
               <div class="form-group">
                    <label for="description">Description:</label>
                    <input type="text" id="description" name="description" value="<?php echo htmlspecialchars($clientData['description'] ?? ''); ?>">
                </div>
                <div class="form-group">
                    <label for="profile_pic">Profile Picture:</label>
                    <input type="file" id="profile_pic" name="profile_pic">
                </div>
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($userData['username'] ?? ''); ?>" >
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($userData['email'] ?? ''); ?>" >
                </div>
                <div class="form-group">
                    <button type="submit">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
    <script src="back.js"></script>
</body>
</html>
