<?php
include 'navbar.php';
?>
<?php
include 'Config.php'; // Include the database connection file
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "Login to continue";
    header("Location: login.html"); // Redirect to the login page if not logged in
    exit();
}


// Get user details from the database
$user_id = $_SESSION['user_id'];
$get_user_details = $conn->prepare("SELECT id, username, email FROM users WHERE id = ?");
$get_user_details->bind_param("i", $user_id);
$get_user_details->execute();
$user_details = $get_user_details->get_result()->fetch_assoc();
$get_user_details->close();

// Get the user's uploaded pets from the database
$get_uploaded_pets = $conn->prepare("SELECT id, name, description, image_path, price, pet_type FROM pets WHERE owner_id = ?");
$get_uploaded_pets->bind_param("i", $user_id);
$get_uploaded_pets->execute();
$uploaded_pets = $get_uploaded_pets->get_result()->fetch_all(MYSQLI_ASSOC);
$get_uploaded_pets->close();

// Get the user's purchased pets from the database
$get_purchased_pets = $conn->prepare("SELECT P.id, P.name, P.description, P.image_path, P.price, P.pet_type FROM pets P
                                    INNER JOIN purchases PU ON P.id = PU.pet_id
                                    WHERE PU.buyer_id = ?");
$get_purchased_pets->bind_param("i", $user_id);
$get_purchased_pets->execute();
$purchased_pets = $get_purchased_pets->get_result()->fetch_all(MYSQLI_ASSOC);
$get_purchased_pets->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Welcome, <?php echo $user_details['username']; ?>!</h2>
    
    <h3>Your Uploaded Pets:</h3>
    <?php foreach ($uploaded_pets as $pet): ?>
        <div>
            <img src="<?php echo $pet['image_path']; ?>" alt="<?php echo $pet['name']; ?>" style="max-width: 150px; max-height: 150px;">
            <p>Name: <?php echo $pet['name']; ?></p>
            <p>Description: <?php echo $pet['description']; ?></p>
            <p>Price: <?php echo $pet['price']; ?></p>
            <p>Pet Type: <?php echo $pet['pet_type']; ?></p>
        </div>
    <?php endforeach; ?>

    <h3>Your Purchased Pets:</h3>
    <?php foreach ($purchased_pets as $pet): ?>
        <div>
            <img src="<?php echo $pet['image_path']; ?>" alt="<?php echo $pet['name']; ?>" style="max-width: 150px; max-height: 150px;">
            <p>Name: <?php echo $pet['name']; ?></p>
            <p>Description: <?php echo $pet['description']; ?></p>
            <p>Price: <?php echo $pet['price']; ?></p>
            <p>Pet Type: <?php echo $pet['pet_type']; ?></p>
        </div>
    <?php endforeach; ?>

    <p><a href="pet_upload_form.php">Upload a New Pet</a></p>
    <p><a href="logout.php">Logout</a></p>
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
