<?php
include 'connection.php'; // Ensure connection to the database

$rows = [];
try {
    // Get the selected service category from the POST request
    $category = isset($_POST['category']) ? $_POST['category'] : '';

    // SQL query to select data from the tables
    $sql = "SELECT services.service_name, vendor_services.price, vendor_services.rating,  vendor_services.image 
    FROM services
    JOIN vendor_services ON services.service_id = vendor_services.service_id
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

<!-- Place the select element before the PHP code -->
<select id="servicesSelect">
    <option value="Venue Booking">Venue</option>
    <option value="catering">Catering</option>
</select>

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
