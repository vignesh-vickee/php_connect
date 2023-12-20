<?php
include 'Config.php'; // Include the database connection file

session_start(); // Start the session

$errors = []; // Initialize an array to store error messages

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validate user credentials
    $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            // Authentication successful
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            header("Location:index.php"); // Redirect to the index or another page
            exit();
        } else {
            // Incorrect password
            $errors[] = "Incorrect password.";
        }
    } else {
        // User not found
        $errors[] = "User not found.";
    }

    $stmt->close();
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="form_style.css">
</head>
<body>

    <form method="post" action="">
        <div class="mestitl">
            <h3>LOGIN</h3>
            <p>Please enter your credentials to login.</p>
        </div>
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br>

        <input type="submit" value="Login">
<p class="mesnote">
    <?php
    // Display error messages
    foreach ($errors as $error) {
    echo "<p style='color: red;'>$error</p>";
    }
    ?>
</p>
        <p class="mesnote">Not registered? <a href="register.html">Create an account</a></p>

    </form>

</body>
</html>
