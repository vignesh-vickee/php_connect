<?php
include 'Config.php'; // Include the database connection file

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password
    $email = $_POST['email'];

    // Check if the username is already taken
    $checkUsername = $conn->prepare("SELECT id FROM users WHERE username = ?");
    $checkUsername->bind_param("s", $username);
    $checkUsername->execute();

    if ($checkUsername->get_result()->num_rows > 0) {
        echo "Username is already taken. Please choose a different one.";
        exit();
    }

    $checkUsername->close();

    // Insert the new user into the database
    $insertUser = $conn->prepare("INSERT INTO users (username, password, email) VALUES (?, ?, ?)");
    $insertUser->bind_param("sss", $username, $password, $email);

    if ($insertUser->execute()) {
        echo "Registration successful!";
        header("Location: index.php");
    } else {
        echo "Error during registration. Please try again.";
    }

    $insertUser->close();
}

// Close the database connection
$conn->close();
?>
