<?php
session_start();

// Check if the delete account button is clicked
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_account'])) {
    // Redirect to the confirmation page
    header("Location: confirm-delete-account.php");
    exit();
}

// If yes button is clicked
if (isset($_POST['yes'])) {
    // Connect to the database
    $db = new PDO("sqlite:C:/xampp/htdocs/Stage-3-1/Isaac Database.db");
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Delete the first entry from the user table using a subquery
    $sql = "DELETE FROM user WHERE rowid = (SELECT rowid FROM user LIMIT 1)";
    
    // Execute the delete query
    $stmt = $db->prepare($sql);
    $stmt->execute();
    
    // Close the database connection
    $db = null;
    
    // Set a session variable to indicate account deletion success
    $_SESSION['account_deleted'] = true;
    
    // Redirect to a confirmation page
    header("Location: successful-delete.html");
    exit();
}

// If no button is clicked
if (isset($_POST['no'])) {
    // Redirect back to the logout page
    header("Location: log-out.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirm Delete Account</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="log-out.php">Log out</a></li>
            </ul>
        </nav>
    </header>

    <div class="container">
        <div class="left-background"></div> 
        <div class="right-background"></div> 
        
        <h1>Confirm Delete Account</h1>
        <p>Are you sure you want to delete your account?</p>
        <form action="confirm-delete-account.php" method="post">
            <input type="submit" name="yes" value="Yes">
            <input type="submit" name="no" value="No">
        </form>
    </div>
</body>
</html>
