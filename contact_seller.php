<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $sellerEmail = $_POST['seller_email'];
    $petName = $_POST['pet_name'];
    $message = $_POST['message'];

    // Validate and sanitize form data (you may want to add more validation)
    $sellerEmail = filter_var($sellerEmail, FILTER_SANITIZE_EMAIL);
    $petName = htmlspecialchars($petName);
    $message = htmlspecialchars($message);

    // Construct email message
    $subject = "Interested Buyer for $petName";
    $body = "Hello,\n\nYou have received interest from a buyer for the pet named $petName.\n\nMessage: $message";

    // Send email (you may need to configure mail settings on your server)
    $headers = "From: webmaster@example.com"; // Change this to a valid sender email address

    if (mail($sellerEmail, $subject, $body, $headers)) {
        echo "Your message has been sent to the seller. Thank you!";
    } else {
        echo "Error sending the message. Please try again.";
    }
} else {
    header("Location: browse_pets.php"); // Redirect if the form is not submitted
    exit();
}
?>
