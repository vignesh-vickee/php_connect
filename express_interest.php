<?php
include 'Config.php'; // Include the database connection file

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['pet_id'])) {
    $petId = $_GET['pet_id'];

    // Retrieve pet details, including seller information
    $getPetDetailsStmt = $conn->prepare("SELECT p.*, u.username as seller_username, u.email as seller_email FROM pets p JOIN users u ON p.owner_id = u.id WHERE p.id = ?");
    $getPetDetailsStmt->bind_param("i", $petId);
    $getPetDetailsStmt->execute();
    $petDetails = $getPetDetailsStmt->get_result()->fetch_assoc();
    $getPetDetailsStmt->close();

    if (!$petDetails) {
        echo "Pet not found or unavailable.";
        exit();
    }

    // Perform additional actions as needed, such as updating the database or notifying the seller

} else {
    header("Location: browse_pets.php"); // Redirect if pet ID is not provided
    exit();
}

// Close the database connection
$conn->close();
?>
<?php
include 'navbar.php';
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Express Interest</title>
    <link rel="stylesheet" href="style.css"> <!-- Link to your CSS file -->
</head>
<body>
<div class="fmtitle">
        <h1>Express Interest</h1>

        <h2>Crucial Information: Payment Handling and Seller Communication :</h2>
            <h5> Please be aware that our platform does not handle payment transactions, as the pricing of the pet is negotiable.<br>
                 Instead, we provide you with essential information about the seller to facilitate future communications between you and the seller regarding the purchase.</h5>
</div>
    <section>
        <h2>Pet Details</h2>
        <img src="<?php echo $petDetails['image_path']; ?>" alt="<?php echo $petDetails['breed']; ?>" class="pet-image">
        <!--<p><strong>Name:</strong> ?php echo $petDetails['name']; ?></p> -->
        <p><strong>Pet Type:</strong> <?php echo $petDetails['pet_type']; ?></p>
        <p><strong>Description:</strong> <?php echo $petDetails['description']; ?></p>
        <p><strong>Expected Price:</strong> <?php echo $petDetails['price']; ?></p>
        

        <h2>Seller Information</h2>
        <p><strong>Seller Username:</strong> <?php echo $petDetails['seller_username']; ?></p>
        <p><strong>Seller Email:</strong> <?php echo $petDetails['seller_email']; ?></p>

        <h2>Contact the Seller</h2>
        <form action="contact_seller.php" method="post">
            <input type="hidden" name="seller_email" value="<?php echo $petDetails['seller_email']; ?>">
            <input type="hidden" name="pet_breed" value="<?php echo $petDetails['breed']; ?>">
            <label for="message">Your Message:</label>
            <textarea name="message" id="message" rows="4" required></textarea>
            <br>
            <button type="submit">Send Message</button>
        </form>
    </section>
</body>
</html>
