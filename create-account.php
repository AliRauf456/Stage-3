<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Create Account</title>
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="home-page-prospective.html">Home</a></li>
                <li><a href="login.php">Login</a></li>
                <li><a href="create-account.php">Create an Account</a></li>
            </ul>
        </nav>
    </header>

    <div class="container">
        <div class="left-background"></div> 
        <div class="right-background"></div> 
        <h1>Create an Account</h1>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <input type="text" id="firstname" name="firstname" placeholder="Enter your First Name">
            <input type="text" id="surname" name="surname" placeholder="Enter your Surname">
            <input type="email" id="email" name="email" placeholder="Enter your Email">
            <input type="password" id="password" name="password" placeholder="Enter your Password">
            <input type="password" id="confirmPassword" name="confirmPassword" placeholder="Confirm your Password">
            <input type="submit" value="Create Account">
        </form>

        <?php
// Path validation
$path = 'C:\xampp\htdocs\Stage-3-1\Isaac Database.db';
$realPath = realpath($path);

if ($realPath === false) {
    die("The path '$path' does not exist.");
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve user input from the form
    $firstname = $_POST["firstname"];
    $surname = $_POST["surname"];
    $password = $_POST["password"];
    $confirmPassword = $_POST["confirmPassword"]; // New line to get confirm password
    $email = $_POST["email"];

    // Check if form fields are not empty
    if (empty($firstname) || empty($surname) || empty($password) || empty($confirmPassword) || empty($email)) {
        echo "Error: Please fill in all fields.";
    } else {
        // Check if passwords match
        if ($password !== $confirmPassword) {
            echo "Error: Passwords do not match.";
        } else {
            // Connect to the SQLite database
            $db = new SQLite3($path);

            // Check if the connection is successful
            if (!$db) {
                echo "Error: Unable to open database.";
            } else {
                // Prepare the INSERT statement
                $stmt = $db->prepare("INSERT INTO user (firstname, surname, password, email) VALUES (:firstname, :surname, :password, :email)");

                // Check if the statement was prepared successfully
                if (!$stmt) {
                    echo "Error: Unable to prepare statement.";
                } else {
                    // Bind parameters
                    $stmt->bindParam(':firstname', $firstname);
                    $stmt->bindParam(':surname', $surname);
                    $stmt->bindParam(':password', $password);
                    $stmt->bindParam(':email', $email);

                    // Execute the statement
                    $result = $stmt->execute();

                    // Check if the insertion was successful
                    if ($result) {
                        echo "Your account has been successfully created.";
                    } else {
                        echo "Error: Unable to create your account.";
                    }

                    // Close the statement and the database connection
                    $stmt->close();
                    $db->close();
                }
            }
        }
    }
}
?>

    </div>
</body>
</html>
