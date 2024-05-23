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
      <h2>Upload Images</h2>
      <div class="image-preview" id="imagePreview">
      <form id="uploadForm" action="insert.php" method="post" enctype="multipart/form-data">
      <input type="hidden" name="add-service" value="1">
        <label for="fileInput" class="upload">
          <input type="file" accept="image/jpeg, image/png, image/jpg" name="image" id="fileInput" style="display: none;">
          <i class='bx bx-images' style="font-size: 48px; color:#e3bdb5;"></i>
        </label>
        <span>Upload Image</span>
      </div>
    
      <!-- <button class="btn upload-image" id="uploadButton">Click to upload</button> -->

    </div>
    <div class="field-input-section">
      <!-- Input Fields -->
      <h2>Enter Details</h2>
      
       
        <div class="form-group">
          <label for="itemPrice">Price:</label>
          <input type="text" name="price" class="form-control" id="itemPrice" placeholder="Enter item price">
        </div>
        <div class="form-group">
          <label for="itemCategory">Category:</label>
          <select name="category" class="form-control" id="itemCategory">
            <option value="Venue">Wedding Cake and Desserts</option>
            <option value="Caterer">Catering Services</option>
            <option value="Photographer">Photographer</option>
            <option value="Photographer">  Wedding Attire</option>
            <option value="Photographer">  Makeup and Hair </option>
            <option value="Photographer">   Bridal jewelry </option>
            <option value="Photographer">   Floral arrangements </option>
            <option value="Photographer">Decor and Event Planning </option>

         
          </select>
        </div>
        <div class="form-group ">
          <label  for="itemDescription">Description:</label>
          <textarea name="description" class="form-control description" id="itemDescription" placeholder="Enter item description"></textarea>
        </div>
        <button type="submit" class="btn btn-submit">Upload Now</button>
      </form>
    </div>
  </div>
</div>
<script>
  //uploaing image
  document.getElementById('uploadButton').addEventListener('click', function() {
    document.getElementById('fileInput').click();
  });

  document.getElementById('fileInput').addEventListener('change', function(event) {
    const preview = document.getElementById('imagePreview');
    const file = event.target.files[0];
    const reader = new FileReader();

    reader.onload = function(event) {
      preview.innerHTML = '';
      const image = document.createElement('img');
      image.src = event.target.result;
      mage.classList.add('uploaded-image'); // Add CSS class for image sizing
      preview.appendChild(image);
    };

    reader.readAsDataURL(file);
  });

 
</script>
</body>
</html>
