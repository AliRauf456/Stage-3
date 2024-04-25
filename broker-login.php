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
                <li><a href="login.php">Back</a></li>
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
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $employeeID = $_POST['employeeID'];
                $password = $_POST['password'];

                $db = new PDO("sqlite:/xampp/htdocs/Stage-3-1/Isaac Database.db");
                $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $stmt = $db->prepare("SELECT * FROM Brokers WHERE broker_id = :employeeID AND password = :password");

                $stmt->bindParam(':employeeID', $employeeID);
                $stmt->bindParam(':password', $password);
                $stmt->execute();

                $row = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($row) {
                    header("Location: mortgage-product.php");
                    exit();
                } else {
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
