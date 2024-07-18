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
    <section class="users">
      <header>
        <div class="content">
          <?php 
          try {
              $sql = "SELECT * FROM users WHERE user_id = :user_id";
              $stmt = $pdo->prepare($sql);
              $stmt->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
              $stmt->execute();

              if ($stmt->rowCount() > 0) {
                  $row = $stmt->fetch(PDO::FETCH_ASSOC);
                  
                  // Determine the name based on the user's role
                  if ($row['role'] === 'Vendor') {
                      $stmt_vendor = $pdo->prepare("SELECT vendor_name FROM vendors WHERE user_id = :user_id");
                      $stmt_vendor->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
                      $stmt_vendor->execute();
                      $vendor = $stmt_vendor->fetch(PDO::FETCH_ASSOC);
                      $name = htmlspecialchars($vendor['vendor_name']);
                  } elseif ($row['role'] === 'Client') {
                      $stmt_client = $pdo->prepare("SELECT first_name, last_name FROM clients WHERE user_id = :user_id");
                      $stmt_client->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
                      $stmt_client->execute();
                      $client = $stmt_client->fetch(PDO::FETCH_ASSOC);
                      $name = htmlspecialchars($client['first_name'] . " " . $client['last_name']);
                  } elseif ($row['role'] === 'Manager') {
                      $stmt_manager = $pdo->prepare("SELECT username FROM users WHERE user_id = :user_id");
                      $stmt_manager->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
                      $stmt_manager->execute();
                      $manager = $stmt_manager->fetch(PDO::FETCH_ASSOC);
                      $name = htmlspecialchars($manager['username']);
                  } else {
                      $name = "Unknown";
                  }

                  // Handle binary data for profile_pic
                  $profile_pic = isset($row['profile_pic']) ? base64_encode(stream_get_contents($row['profile_pic'])) : '';
              } else {
                  echo "User not found.";
                  exit();
              }
          } catch (PDOException $e) {
              echo 'Error: ' . $e->getMessage();
              exit();
          }
          ?>
          <img src="data:image/jpeg;base64,<?php echo $profile_pic; ?>" alt="Profile Picture">
          <div class="details">
            <span><?php echo htmlspecialchars($name); ?></span>
            <p><?php echo htmlspecialchars($row['status']); ?></p>
          </div>
        </div>

      </header>
      <div class="search">
        <span class="text">Select a user to start chat</span>
        <input type="text" placeholder="Enter name to search...">
        <button><i class="fas fa-search"></i></button>
      </div>
      <div class="users-list">
  
      </div>
    </section>
  </div>

  <script src="javascript/users.js"></script>

</body>
</html>
