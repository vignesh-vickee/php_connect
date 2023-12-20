<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pet Exchange Platform</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* Add your styles for the navigation bar here */
        body {
            margin: 0;
            font-family: 'Arial', sans-serif;
        }
 
</style>
</head>
<body>
    <nav>
        <!-- Move "Pet Exchange" link to the left -->
        <a href="index.php">Pet Exchange</a>
        
        <!-- Move the existing links to the right -->
        <div>
            <a href="index.php">Home</a>
            <a href="pet_upload_form.php">Sell your pet</a>
            <a href="browse_pets.php">Pet Listings</a>
            <a href="user_account.php">User profile</a>

            <div class="dropdown">
                <a href="#">Settings</a>
                <div class="dropdown-content">
                    <a href="about.php">About us</a>
                    
                    <a href="register.html">New user registration</a>
                    <a href="logout.php">Logout</a>
                </div>
            </div>
            
        </div>
    </nav>
</body>
</html>
