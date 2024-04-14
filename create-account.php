<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Form Submission Result</title>
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="home-page-prospective.html">Home</a></li>
                <li><a href="login.php">Login</a></li>
                <li><a href="create-account.html">Create an Account</a></li>
                <li><a href="broker-login.html">broker Login</a></li>
            </ul>
        </nav>
    </header>
<body>

    <title>Form Submission Result</title>

<body>
    <h1>Form Submission Result</h1>

    <?php
    // Your PHP code here

    // Path validation
    $path = 'C:\xampp\htdocs\Stage-3-main data\data.db';
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
        $email = $_POST["email"];

        // Check if form fields are not empty
        if (empty($firstname) || empty($surname) || empty($password) || empty($email)) {
            echo "Error: Please fill in all fields.";
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
                        echo "User added successfully.";
                    } else {
                        echo "Error: Unable to add user.";
                    }

                    // Close the statement and the database connection
                    $stmt->close();
                    $db->close();
                    header("Location:login.php");
                }
            }
        }
    }
    ?>

    <form method="post" action="">
        <label for="firstname">First Name:</label>
        <input type="text" id="firstname" name="firstname"><br>

        <label for="surname">Surname:</label>
        <input type="text" id="surname" name="surname"><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password"><br>
        
        <label for="email">Email:</label>
        <input type="email" id="email" name="email"><br>

        <input type="submit" value="Submit">
    </form>
</body>
</html>
