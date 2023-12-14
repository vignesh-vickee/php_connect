<?php
include 'navbar.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Pet Details</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <h2>Upload Pet Details</h2>
    <form action="upload_pet.php" method="post" enctype="multipart/form-data">
        
        <label for="pet_type">Pet Type:</label>
        <input type="text" id="pet_type" name="pet_type" required><br>

        <label for="name">Pet Name:</label>
        <input type="text" id="name" name="name" required><br>

        <label for="description">Description:</label>
        <textarea id="description" name="description" rows="4" required></textarea><br>

        <label for="image">Image:</label>
        <input type="file" id="image" name="image" accept="image/*" required><br>

        <label for="price">Price expected:</label>
        <input type="text" id="price" name="price" required><br>

        

        <input type="submit" value="Upload Pet">
    </form>
</body>
</html>
