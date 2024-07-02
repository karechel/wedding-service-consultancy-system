<?php
include 'connection.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        if (isset($_POST['services_form'])) {
            // Service form submission
            $name = $_POST['name'];
            $description = $_POST['description'];

            $sql = "INSERT INTO services(service_name, description) VALUES (:name, :description)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':description', $description);
            $stmt->execute();
            
            echo "Service record inserted successfully!";
        } elseif (isset($_POST['register_user_form'])) {
            // User registration form submission
            $username = $_POST['Username'];
            $email = $_POST['email'];
            $password = $_POST['Password'];
            $role = isset($_POST['role']) ? $_POST['role'] : null;

            // Check if role is either 'Client' or 'Vendor'
            if ($role !== null && ($role === 'Client' || $role === 'Vendor')) {
                $sql = "INSERT INTO users(username, email, password, role, registration_date) VALUES (:username, :email, :password, :role, CURRENT_DATE)";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':username', $username);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':password', $password);
                $stmt->bindParam(':role', $role);
                $stmt->execute();

                // Fetch the user_id of the newly inserted user
                $user_id = $pdo->lastInsertId();
                $_SESSION['user_id'] = $user_id;
                echo "User registered successfully with user_id: $user_id";
            } else {
                echo "Error: Invalid role.";
                exit; // Stop execution if an invalid role is provided
            }
        } elseif(isset($_POST['client-account'])) {
            // Client account form submission
            $user_id = $_SESSION['user_id'];
            $fname = $_POST['fname'];
            $lname = $_POST['lname'];
            $contact_number = $_POST['contact_number'];
            $wedding_date = $_POST['wedding_date'];
            $location = $_POST['location'];

            // Insert into the clients table with the obtained user_id
            $sql = "INSERT INTO clients(user_id, first_name, last_name, contact_number, wedding_date, location) 
                    VALUES (:user_id, :fname, :lname, :contact_number, :wedding_date, :location)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':user_id', $user_id);
            $stmt->bindParam(':fname', $fname);
            $stmt->bindParam(':lname', $lname);
            $stmt->bindParam(':contact_number', $contact_number);
            $stmt->bindParam(':wedding_date', $wedding_date);
            $stmt->bindParam(':location', $location);
            $stmt->execute();
            
            $isDataProcessedSuccessfully = true;

            if ($isDataProcessedSuccessfully) {
                // Redirect to index.html
                header("Location: index.html");
                exit();
            } 
            else{
                header("Location: index.html?register=true");
                exit();
            }
        }
        elseif(isset($_POST['vendor-account'])) {
            // Client account form submission
            $user_id = $_SESSION['user_id'];
            $vendor_name = $_POST['vendor_name'];
            $category = $_POST['category'];
            $location = $_POST['location'];
            $description = $_POST['description'];
            

          
            // Insert into the clients table with the obtained user_id
            $sql = "INSERT INTO vendors(user_id, vendor_name, category, location,description) 
                    VALUES (:user_id, :vendor_name, :category, :location,:description)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':user_id', $user_id);
            $stmt->bindParam(':vendor_name', $vendor_name);
            $stmt->bindParam(':category', $category);
            $stmt->bindParam(':location', $location);
            $stmt->bindParam(':description', $description);
            $stmt->execute();
            $isDataProcessedSuccessfully = true;

            if ($isDataProcessedSuccessfully) {
                // Redirect to index.html
                header("Location: index.html");
                exit();
            } 
            else{
                header("Location: index.html?register=true");
                exit();
            }
        }elseif (isset($_POST['manager-account'])) {
            // User registration form submission
            $username = $_POST['Username'];
            $email = $_POST['email'];
            $password = $_POST['Password'];
            $role = ($_POST['role']) ;

            // Check if role is either 'Client' or 'Vendor'
           
                $sql = "INSERT INTO users(username, email, password, role, registration_date) VALUES (:username, :email, :password, :role, CURRENT_DATE)";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':username', $username);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':password', $password);
                $stmt->bindParam(':role', $role);
                $stmt->execute();

                // Fetch the user_id of the newly inserted user
                $user_id = $pdo->lastInsertId();
                $_SESSION['user_id'] = $user_id;
                echo "User registered successfully with user_id: $user_id";
        }

elseif(isset($_POST['add-service'])) {
    if ($_FILES['image']['error'] === UPLOAD_ERR_OK) {
        // Read image data
        $imageData = file_get_contents($_FILES['image']['tmp_name']);
        
        // Get other form data
        $price = $_POST['price'];
        // $category = $_POST['category'];
        $description = $_POST['description'];
        
        // Prepare SQL statement
        $sql = "INSERT INTO vendor_services (price, other_service_details, image) VALUES (:price,  :description, :imageData)";
        $stmt = $pdo->prepare($sql);
        
        // Bind parameters
        $stmt->bindParam(':price', $price);
        // $stmt->bindParam(':category', $category);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':imageData', $imageData, PDO::PARAM_LOB);
        
        // Execute the statement
        if ($stmt->execute()) {
            echo "File uploaded successfully.";
        } else {
            echo "Error uploading file.";
        }
    } else {
        echo "No file uploaded or error occurred while uploading.";
    }
      
}


        else {
            echo "Error: Invalid form submission.";
            exit; // Stop execution if neither form is submitted
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}



?>
