<?php
    // Assuming you have a database connection established
    // You should replace these with your actual database connection code
    $path = 'C:/xampp/htdocs/Stage-3-1/Isaac Database.db';
    $realPath = realpath($path);

    // Initialize error message variable
    $error_message = "";

    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Retrieve form data
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Check if the database file exists
        if ($realPath === false) {
            die("The database file does not exist.");
        }

        // Open SQLite database connection
        $db = new SQLite3($realPath);

        // Check if the connection is successful
        if (!$db) {
            $error_message = "Error: Unable to open database.";
        } else {
            // Query the user table to check if the provided credentials are valid
            $query = "SELECT * FROM user WHERE email=:email AND password=:password";
            $stmt = $db->prepare($query);
            $stmt->bindValue(':email', $email, SQLITE3_TEXT);
            $stmt->bindValue(':password', $password, SQLITE3_TEXT);
            $result = $stmt->execute();

            // Check if the query returns any rows
            if (!$result->fetchArray(SQLITE3_ASSOC)) {
                // Set error message
                $error_message = "Invalid email or password.";
            } else {
                // Redirect to another page upon successful login
                header("Location: view_mortgage-product.php"); // Change 'dashboard.php' to your desired page
                exit();
            }

            // Close the database connection
            $db->close();
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .broker-login-box {
            margin-top: 20px;
        }
        .broker-login-box h2 {
            margin-bottom: 10px;
        }
        .broker-login-box p {
            margin-bottom: 20px;
        }
        .broker-login-button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        .broker-login-button:hover {
            background-color: #0056b3;
        }
        .error-message {
            color: red;
            margin-top: 10px;
            text-align: center;
        }
    </style>
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

    <div class="left-background"></div> 
    <div class="right-background"></div> 
    
    <div class="container">
        <h1>Login</h1>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <input type="text" id="email" name="email" placeholder="Email">
            <input type="password" id="password" name="password" placeholder="Password">
            <input type="submit" value="Confirm">
        </form>

        <div class="error-message">
            <?php echo $error_message; ?>
        </div>

        <!-- Broker Login Box -->
        <div class="broker-login-box">
            <h2>Broker Login</h2>
            <p>If you are a broker, please login below:</p>
            <a class="broker-login-button" href="broker-login.php">Broker Login</a>
        </div>
    </div>
</body>
</html>
