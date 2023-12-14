<?php
include 'navbar.php';
?>
<?php
include 'Config.php'; // Include the database connection file
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $owner_id = $_SESSION['user_id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $pet_type = $_POST['pet_type'];

    // Handle image upload
    $targetDir = "uploads/";
    $targetFile = $targetDir . basename($_FILES['image']['name']);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Check if the image file is a valid image
    $check = getimagesize($_FILES['image']['tmp_name']);
    if ($check === false) {
        echo "File is not an image.";
        $uploadOk = 0;
    }

    // Check if the file already exists
    if (file_exists($targetFile)) {
        echo "Sorry, the image file already exists.";
        $uploadOk = 0;
    }

    // Check file size (limit to 5MB)
    if ($_FILES['image']['size'] > 5 * 1024 * 1024) {
        echo "Sorry, the image file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    $allowedFormats = array("jpg", "jpeg", "png", "gif");
    if (!in_array($imageFileType, $allowedFormats)) {
        echo "Sorry, only JPG, JPEG, PNG, and GIF files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your image file was not uploaded.";
    } else {
        // If everything is ok, try to upload the file
        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
            // File uploaded successfully, insert pet details into the database
            $insertPet = $conn->prepare("INSERT INTO pets (owner_id, name, description, image_path, price, pet_type) VALUES (?, ?, ?, ?, ?, ?)");
            $insertPet->bind_param("isssds", $owner_id, $name, $description, $targetFile, $price, $pet_type);

            if ($insertPet->execute()) {
                echo "Pet details uploaded successfully!";
            } else {
                echo "Error uploading pet details. Please try again.";
            }

            $insertPet->close();
        } else {
            echo "Sorry, there was an error uploading your image file.";
        }
    }
}

// Close the database connection
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>database</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    
</body>
</html>