<?php
    // Assuming you have a database connection established
    // You should replace these with your actual database connection code
    $path = 'C:/xampp/htdocs/Stage-3-1/Isaac Database.db';
    $realPath = realpath($path);

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
            echo "Error: Unable to open database.";
        } else {
            // Query the user table to check if the provided credentials are valid
            $query = "SELECT * FROM user WHERE email=:email AND password=:password";
            $stmt = $db->prepare($query);
            $stmt->bindValue(':email', $email, SQLITE3_TEXT);
            $stmt->bindValue(':password', $password, SQLITE3_TEXT);
            $result = $stmt->execute();

            // Check if the query returns any rows
            if ($result->fetchArray(SQLITE3_ASSOC)) {
                // Redirect to another page upon successful login
                header("Location: home-page.html"); // Change 'dashboard.php' to your desired page
                exit();
            } else {
                // Handle invalid credentials
                echo "Invalid email or password.";
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
        /* Additional styles here */
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

    <div class="container">
        <div class="left-background"></div> 
        <div class="right-background"></div> 
        
        <h1>Login</h1>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <input type="text" id="email" name="email" placeholder="Email">
            <input type="password" id="password" name="password" placeholder="Password">
            <input type="submit" value="Confirm">
        </form>
    </div>
    <script>
        document.getElementById("loginForm").addEventListener("submit", function(event) {
            event.preventDefault(); // Prevent the form from submitting

            // Retrieve form data
            var email = document.getElementById("email").value;
            var password = document.getElementById("password").value;
            if (email === "valid_email@example.com" && password === "password") {
                window.location.href = "view_mortgage-product.php";
            } else {
                alert("Invalid email or password. Please try again.");
            }
        });
    </script>
</body>
</html>
