<?php
include 'connection.php'; // Ensure connection to the database

$rows = [];
try {
    // Get the selected service category from the POST request
    $category = isset($_POST['category']) ? $_POST['category'] : '';

    // SQL query to select data from the tables
    $sql = "SELECT services.service_name, vendor_services.price, vendor_services.rating,  vendor_services.image, services.location
    FROM services
    JOIN vendor_services ON services.service_id = vendor_services.vendor_service_id
    WHERE services.service_name = :category";

    // Prepare the SQL statement
    $stmt = $pdo->prepare($sql);
    
    // Bind parameter values
    $stmt->bindParam(':category', $category, PDO::PARAM_STR);

    // Execute query
    $stmt->execute();

    // Fetch all rows as associative array
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Handle errors gracefully
    echo "Error: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Website with Login and Registration Form</title>
        <link rel="stylesheet" href="style3.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Parisienne&display=swap" rel="stylesheet">
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    </head>
    <body>
        <div class="background">
        <header class="header">
            <nav class="navbar">
                <a href="#">Home</a>
                <a href="#">About</a>
                <a href="#">Contact</a>
               <a href="Weddingservices.html"> Wedding services</a>
               <div id="servicesDropdown">
                <select id="servicesSelect">
                    <option value="Venue Booking">Venue</option>
                    <option value="catering">catering</option>
                </select>
               </div>
               <a href="">Vendors</a>
                <!-- <div class="sign-in-up">
                    <a href="#" class="login-link">Sign In</a>
                    <a href="#" class="register-link">Sign Up</a>
                </div> -->
            </nav>
         
          </header>
       
          <div class="container">
            <div class="content">
             
                <div class="filter-city">
                    <label for="search">Search:</label>
                    <input type="search" name="" id="search" placeholder="City/ Town">
                </div>
                <div class="service-content" id="service-content">
                  
                    <div class="row">
                    <div class="service-blocks">
    <?php foreach ($rows as $row): ?>  
        <div class="image">
            <a href=""><img src="<?php echo $row['image']; ?>" alt="Service Image"></a>
            <i class="bx bx-heart" style="cursor: pointer;" onclick="toggleHeart(this)"></i>
        </div>
        <div class="details">
            <div class="top-details">
                <h3 class="category-title"><?php echo $row['service_name']; ?></h3>
                <ul class="rating">
                    <li>
                        <i class='bx bx-star' style='color:#ddc04c'></i> <?php echo $row['rating']; ?>
                        <p><?php echo $row['location']; ?></p>
                    </li>
                </ul>
            </div>
            <div class="bottom-details">
                <span>Price: <?php echo $row['price']; ?></span>
                <div class="block-buttons">
                    <button class="btn">Book Now</button>
                </div>
            </div>
        </div>
    <?php endforeach; ?>   
</div> 
                   
                    <div class="service-blocks">
                        <div class="image">
                            <a href=""><img src="Images/venue.jpg" alt=""></a>
                            <i class="bx bx-heart" style="cursor: pointer;" onclick="toggleHeart(this)"></i>
                    </div>
                    <div class="details">
                        <div class="top-details">
                            <h3 class="category-title">Wedding Venues</h3>
                            <ul class="rating">
                                <li>
                                    <i class='bx bx-star' style='color:#ddc04c'  ></i> 4.9
                                    <p float-right>Mombasa, Kenya</p>
                                </li>
                               
                                
                            </div>
                            <div class="bottom-details ">
                                <span>price: ksh 10,000</span>
                                <div class="block-buttons">
                                <button class=" btn">Book Now</button>
                            </div>
                            </div>
                    </div>                  

                    </div>
                    <div class="service-blocks">
                        <div class="image">
                            <a href=""><img src="Images/venue.jpg" alt=""></a>
                            <i class="bx bx-heart" style="cursor: pointer;" onclick="toggleHeart(this)"></i>
                    </div>
                    <div class="details">
                        <div class="top-details">
                            <h3 class="category-title">Wedding Venues</h3>
                            <ul class="rating">
                                <li>
                                    <i class='bx bx-star' style='color:#ddc04c'  ></i> 4.9
                                    <p float-right>Mombasa, Kenya</p>
                                </li>
                               
                                
                            </div>
                            <div class="bottom-details">
                                <span>price: ksh 10,000</span>
                                <div class="block-buttons">
                                    <button class=" btn">Book Now</button>
                                </div>
                            </div>
                    </div>                  

                    </div>
                    <div class="service-blocks">
                        <div class="image">
                            <a href=""><img src="Images/venue.jpg" alt=""></a>
                            <i class="bx bx-heart" style="cursor: pointer;" onclick="toggleHeart(this)"></i>
                    </div>
                    <div class="details">
                        <div class="top-details">
                            <h3 class="category-title">Wedding Venues</h3>
                            <ul class="rating">
                                <li>
                                    <i class='bx bx-star' style='color:#ddc04c'  ></i> 4.9
                                    <p float-right>Mombasa, Kenya</p>
                                </li>
                               
                                
                            </div>
                            <div class="bottom-details">
                                <span>price: ksh 10,000</span>
                                <div class="block-buttons">
                                    <button class=" btn">Book Now</button>
                                </div>
                            </div>
                    </div>                  

                    </div>

                </div>
                <div class="row">
                    <div class="service-blocks">
                        <div class="image">
                            <a href=""><img src="Images/venue.jpg" alt=""></a>
                            <i class="bx bx-heart" style="cursor: pointer;" onclick="toggleHeart(this)"></i>
                    </div>
                    <div class="details">
                        <div class="top-details">
                            <h3 class="category-title">Wedding Venues</h3>
                            <ul class="rating">
                                <li>
                                    <i class='bx bx-star' style='color:#ddc04c'  ></i> 4.9
                                    <p float-right>Mombasa, Kenya</p>
                                </li>
                               
                                
                            </div>
                            <div class="bottom-details">
                                <span>price: ksh 10,000</span>
                                <div class="block-buttons">
                                    <button class=" btn">Book Now</button>
                                </div>
                            </div>
                    </div>                  

                    </div>
                    <div class="service-blocks">
                        <div class="image">
                            <a href=""><img src="Images/venue.jpg" alt=""></a>
                            <i class="bx bx-heart" style="cursor: pointer;" onclick="toggleHeart(this)"></i>
                    </div>
                    <div class="details">
                        <div class="top-details">
                            <h3 class="category-title">Wedding Venues</h3>
                            <ul class="rating">
                                <li>
                                    <i class='bx bx-star' style='color:#ddc04c'  ></i> 4.9
                                    <p float-right>Mombasa, Kenya</p>
                                </li>
                               
                                
                            </div>
                            <div class="bottom-details">
                                <span>price: ksh 10,000</span>
                                <div class="block-buttons">
                                    <button class=" btn">Book Now</button>
                                </div>
                            </div>
                    </div>                  

                    </div>
                    <div class="service-blocks">
                        <div class="image">
                            <a href=""><img src="Images/venue.jpg" alt=""></a>
                            <i class="bx bx-heart" style="cursor: pointer;" onclick="toggleHeart(this)"></i>
                    </div>
                    <div class="details">
                        <div class="top-details">
                            <h3 class="category-title">Wedding Venues</h3>
                            <ul class="rating">
                                <li>
                                    <i class='bx bx-star' style='color:#ddc04c'  ></i> 4.9
                                    <p float-right>Mombasa, Kenya</p>
                                </li>
                               
                                
                            </div>
                            <div class="bottom-details">
                                <span>price: ksh 10,000</span>
                                <div class="block-buttons">
                                    <button class=" btn">Book Now</button>
                                </div>
                            </div>
                    </div>                  

                    </div>
                    <div class="service-blocks">
                        <div class="image">
                            <a href=""><img src="Images/venue.jpg" alt=""></a>
                            <i class="bx bx-heart" style="cursor: pointer;" onclick="toggleHeart(this)"></i>
                    </div>
                    <div class="details">
                        <div class="top-details">
                            <h3 class="category-title">Wedding Venues</h3>
                            <ul class="rating">
                                <li>
                                    <i class='bx bx-star' style='color:#ddc04c'  ></i> 4.9
                                    <p float-right>Mombasa, Kenya</p>
                                </li>
                               
                                
                            </div>
                            <div class="bottom-details">
                                <span>price: ksh 10,000</span>
                                <div class="block-buttons">
                                    <button class=" btn">Book Now</button>
                                </div>
                            </div>
                    </div>                  

                    </div>

                </div>
                </div>
                <footer class="footer">
                    <div class="footer-heading">
                        <h3>Start Today</h3>
                    </div>
                    <div class="footer-buttons">
                        <button class="btn">Add Listing</button>
                        <button class="btn">Browse Listings</button>
                    </div>
                    <div class="footer-columns">
                        <div class="footer-column">
                            <h4>Locations</h4>
                            <ul>
                                <li><a href="#">Location 1</a></li>
                                <li><a href="#">Location 2</a></li>
                                <!-- Add more locations as needed -->
                            </ul>
                        </div>
                        <div class="footer-column">
                            <h4>Quick Links</h4>
                            <ul>
                                <li><a href="#">Link 1</a></li>
                                <li><a href="#">Link 2</a></li>
                                <!-- Add more quick links as needed -->
                            </ul>
                        </div>
                        <div class="footer-column">
                            <h4>Contacts</h4>
                            <ul>
                                <li>Email: info@example.com</li>
                                <li>Phone: +1234567890</li>
                                <!-- Add more contact information as needed -->
                            </ul>
                        </div>
                    </div>
                </footer>
        </div>
       
          </div>
          
        
          <script>
    // Add event listener to the select element
    document.getElementById('servicesSelect').addEventListener('change', function() {
        var serviceCategory = this.value;
        fetch('getServices.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'category=' + serviceCategory
        })
        .then(response => response.json())
        .then(services => {
            var servicesList = '';
            services.forEach(service => {
                servicesList += `
                    <div class="service-block">
                        <div class="image">
                            <a href=""><img src="${service.image}" alt="${service.service_name}"></a>
                            <i class="bx bx-heart" style="cursor: pointer;" onclick="toggleHeart(this)"></i>
                        </div>
                        <div class="details">
                            <div class="top-details">
                                <h3 class="category-title">${service.service_name}</h3>
                                <ul class="rating">
                                    <li>
                                        <i class='bx bx-star' style='color:#ddc04c'></i> ${service.rating}
                                        <p>${service.location}</p>
                                    </li>
                                </ul>
                            </div>
                            <div class="bottom-details">
                                <span>Price: ${service.price}</span>
                                <div class="block-buttons">
                                    <button class="btn">Book Now</button>
                                </div>
                            </div>
                        </div>
                    </div>`;
            });
            document.getElementsByClassName('service-blocks')[0].innerHTML = servicesList;
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });
</script>
    </div>
</div>
    </body>
</html>