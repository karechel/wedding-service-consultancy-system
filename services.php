<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Image Upload Page</title>
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <link rel="stylesheet" href="style2.css">
</head>
<body>
<header class="header">
    <nav class="navbar">
        <a href="#">Home</a>
        <a href="#">About</a>
        <a href="#">Services</a>
   
    </nav>
</header>
<div class="background">
  <div class="services-container">
    <div class="image-upload-section">
      <!-- Image Upload Section -->
      <!-- <h2>Upload Images</h2> -->
      <form id="uploadForm" action="upload_image.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="add-service" value="1">
        <div class="img_uploads">
        <div class="form-group">
          <label for="mainImage">Main Image:
          <input type="file" accept="image/jpeg, image/png, image/jpg" name="images[]" id="mainImage"  style="display: none;">
          <i class='bx bx-images' style="font-size: 48px; color:#e3bdb5;"></i> 
        </label>
        </div>
        <div class="form-group">
          <label for="image1">Image 1:
          <input type="file" accept="image/jpeg, image/png, image/jpg" name="images[]" id="image1" style="display: none;">
          <i class='bx bx-images' style="font-size: 48px; color:#e3bdb5;"></i>  
        </label>
        </div>
        <div class="form-group">
          <label for="image2">Image 2:
          <input type="file" accept="image/jpeg, image/png, image/jpg" name="images[]" id="image2" style="display: none;">
          <i class='bx bx-images' style="font-size: 48px; color:#e3bdb5;"></i> 
        </label>
        </div>
        <div class="form-group">
          <label for="image3">Image 3:
          <input type="file" accept="image/jpeg, image/png, image/jpg" name="images[]" id="image3" style="display: none;">
          <i class='bx bx-images' style="font-size: 48px; color:#e3bdb5;"></i> 
        </label>
        </div>
        <div class="form-group">
          <label for="image4">Image 4:
          <input type="file" accept="image/jpeg, image/png, image/jpg" name="images[]" id="image4" style="display: none;">
          <i class='bx bx-images' style="font-size: 48px; color:#e3bdb5;"></i> 
        </label>
        </div>
        </div>
        <div class="form-group">
          <label for="itemPrice">Price:</label>
          <input type="text" name="price" class="form-control" id="itemPrice" placeholder="Enter item price">
        </div>
        <div class="form-group">
          <label for="itemCategory">Category:</label>
          <select name="service_id" class="form-control" id="itemCategory">
            <option value="1">Venue Booking</option>
            <option value="2">Floral Arrangements</option>
            <option value="3">Catering Services</option>
            <option value="4">Wedding Attire</option>
            <option value="5">Photography and Videography</option>
            <option value="6">Transportation</option>
            <option value="7">Decor and Event Planning</option>
            <option value="8">Entertainment and Music</option>
            <option value="9">Wedding Cake and Desserts</option>
            <option value="10">Invitations and Stationery</option>
            <option value="11">Makeup and Hair</option>
            <option value="12">Wedding Favors</option>
            <option value="13">Gift Registry</option>
            <option value="16">Bridal Jewelry</option>
          </select>
        </div>
        <div class="form-group">
          <label for="itemDescription">Description:</label>
          <textarea name="description" class="form-control description" id="itemDescription" placeholder="Enter Service description"></textarea>
        </div>
        <button type="submit" class="btn btn-submit">Upload Now</button>
      </form>
    </div>
    <div class="image-preview" id="imagePreview"></div>
  </div>
</div>
<script>
  document.querySelectorAll('input[type="file"]').forEach(input => {
    input.addEventListener('change', function(event) {
      const preview = document.getElementById('imagePreview');
      preview.innerHTML = ''; // Clear previous previews
      const files = event.target.files;
      for (let i = 0; i < files.length; i++) {
        const file = files[i];
        const reader = new FileReader();

        reader.onload = function(event) {
          const image = document.createElement('img');
          image.src = event.target.result;
          image.classList.add('uploaded-image'); // Add CSS class for image sizing
          preview.appendChild(image);
          const imageName = document.createElement('div');
          imageName.textContent = `Image ${i + 1}: ${file.name}`;
          preview.appendChild(imageName);
        };

        reader.readAsDataURL(file);
      }
    });
  });
</script>
</body>
</html>
