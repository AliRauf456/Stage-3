<?php
// Establish a connection to your database
$database_file = "your_database_file.db"; // Change this to your SQLite database file
$db = new SQLite3($database_file);

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $firstname = $_POST['firstName'];
    $surname = $_POST['surname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    // Validate form data (you can add more validation as needed)
    if ($password !== $confirmPassword) {
        echo "Passwords do not match.";
        exit();
    }

    // Hash the password before storing it in the database (for security)
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Prepare a SQL statement to insert the user data
    $stmt = $db->prepare("INSERT INTO user (firstname, surname, email, password) VALUES (:firstname, :surname, :email, :password)");
    $stmt->bindParam(':firstname', $firstname);
    $stmt->bindParam(':surname', $surname);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $hashed_password);

    // Execute the statement
    $result = $stmt->execute();

    if ($result) {
        echo "Account created successfully.";
    } else {
        echo "Error creating account.";
    }
}
?>
