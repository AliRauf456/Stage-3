<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Broker Login</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="home-page-prospective.html">Home</a></li>
                <li><a href="login.html">Login</a></li>
                <li><a href="create-account.html">Create an Account</a></li>
                <li><a href="broker-login.php">Broker Login</a></li>
                <li><a href="mortgage-product.php">Mortgage-product</a></li>
            </ul>
        </nav>
    </header>

    <div class="left-background"></div> 
    <div class="right-background"></div> 
    
    <div class="container">
        <header>
            <h1>Broker Login</h1>
        </header>
        <div class="content">
            <?php
            // Check if form is submitted
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                // Get form data
                $employeeID = $_POST['employeeID'];
                $password = $_POST['password'];

                // Connect to the database
                $db = new PDO("sqlite:C:/xampp/Data/Mortgage Database.db");
                $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                // Prepare SQL statement
                $stmt = $db->prepare("SELECT * FROM broker WHERE brokerid = :employeeID AND password = :password");

                // Bind parameters and execute the statement
                $stmt->bindParam(':employeeID', $employeeID);
                $stmt->bindParam(':password', $password);
                $stmt->execute();

                // Fetch matching row
                $row = $stmt->fetch(PDO::FETCH_ASSOC);

                // Check if a row was found
                if ($row) {
                    // Redirect to mortgage-product.php
                    header("Location: mortgage-product.php");
                    exit();
                } else {
                    // Display error message
                    echo "<div id='errorMessage'>Invalid Employee ID or Password.</div>";
                }
            }
            ?>
            <form method="post">
                <div style="margin-top: 20px;"> 
                    <label for="employeeID">Employee ID:</label>
                </div>
                <input type="text" id="employeeID" name="employeeID" placeholder="Enter your employee ID" required>

                <label for="password">Password:</label>
                <input type="password" id="password" name="password" placeholder="Enter your password" required>

                <input type="submit" value="Login">
            </form>
        </div>
    </div>
</body>
</html>
