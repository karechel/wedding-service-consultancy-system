<?php 
session_start();
include_once "../connection.php"; // Include your connection file

if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.html");
    exit();
}
?>
<?php include_once "header.php"; ?>
<body>
  <div class="wrapper">
    <section class="chat-area">
      <header>
        <?php 
        $user_id = $_GET['user_id'];
        try {
            $sql = "SELECT * FROM users WHERE user_id = :user_id";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->execute();

            if($stmt->rowCount() > 0){
                $row = $stmt->fetch(PDO::FETCH_ASSOC);

                // Handle binary data for profile_pic
                $profile_pic = isset($row['profile_pic']) ? base64_encode(stream_get_contents($row['profile_pic'])) : '';

                // Determine the name based on the user's role
                if ($row['role'] === 'Vendor') {
                    // Fetch vendor name
                    $stmt_vendor = $pdo->prepare("SELECT vendor_name FROM vendors WHERE user_id = :user_id");
                    $stmt_vendor->bindParam(':user_id', $user_id, PDO::PARAM_INT);
                    $stmt_vendor->execute();
                    $vendor = $stmt_vendor->fetch(PDO::FETCH_ASSOC);
                    $name = htmlspecialchars($vendor['vendor_name']);
                } elseif ($row['role'] === 'Client') {
                    // Fetch client name
                    $stmt_client = $pdo->prepare("SELECT first_name, last_name FROM clients WHERE user_id = :user_id");
                    $stmt_client->bindParam(':user_id', $user_id, PDO::PARAM_INT);
                    $stmt_client->execute();
                    $client = $stmt_client->fetch(PDO::FETCH_ASSOC);
                    $name = htmlspecialchars($client['first_name'] . " " . $client['last_name']);
                } elseif ($row['role'] === 'Manager') {
                    $name = htmlspecialchars($row['username']); // Assuming username is the appropriate column
                } else {
                    $name = "Unknown";
                }
            } else {
                header("location: users.php");
                exit();
            }
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
            exit();
        }
        ?>
        <a href="users.php" class="back-icon"><i class="fas fa-arrow-left"></i></a>
        <img src="data:image/jpeg;base64,<?php echo $profile_pic; ?>" alt="Profile Picture">
        <div class="details">
          <span><?php echo $name; ?></span>
          <p><?php echo htmlspecialchars($row['status']); ?></p>
        </div>
      </header>
      <div class="chat-box">

      </div>
      <form action="#" class="typing-area">
        <input type="text" class="incoming_id" name="incoming_id" value="<?php echo htmlspecialchars($user_id); ?>" hidden>
        <input type="text" name="message" class="input-field" placeholder="Type a message here..." autocomplete="off">
        <button><i class="fab fa-telegram-plane"></i></button>
      </form>
    </section>
  </div>

  <script src="javascript/chat.js"></script>

</body>
</html>
